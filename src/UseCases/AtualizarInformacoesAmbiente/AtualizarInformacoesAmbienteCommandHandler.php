<?php
/**
 * MIT License
 *
 * Copyright (c) 2018 PHP DLX
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace PainelDLX\ConfPag\UseCases\AtualizarInformacoesAmbiente;


use PainelDLX\ConfPag\Domain\Entities\GatewayPagamento;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamentoConfiguracao;
use PainelDLX\ConfPag\Domain\Exceptions\GatewayPagamentoNaoEncontradoException;
use PainelDLX\ConfPag\Domain\Repositories\GatewayPagamentoConfiguracaoRepositoryInterface;
use PainelDLX\ConfPag\Domain\Repositories\GatewayPagamentoRepositoryInterface;

/**
 * Class AtualizarInformacoesAmbienteCommandHandler
 * @package PainelDLX\ConfPag\UseCases\AtualizarInformacoesAmbiente
 * @covers AtualizarInformacoesAmbienteCommandHandlerTest
 */
class AtualizarInformacoesAmbienteCommandHandler
{
    /**
     * @var GatewayPagamentoRepositoryInterface
     */
    private $gateway_configuracao_repository;
    /**
     * @var GatewayPagamentoRepositoryInterface
     */
    private $gateway_pagamento_repository;

    /**
     * AtualizarInformacoesAmbienteCommandHandler constructor.
     * @param GatewayPagamentoRepositoryInterface $gateway_pagamento_repository
     * @param GatewayPagamentoConfiguracaoRepositoryInterface $gateway_configuracao_repository
     */
    public function __construct(
        GatewayPagamentoRepositoryInterface $gateway_pagamento_repository,
        GatewayPagamentoConfiguracaoRepositoryInterface $gateway_configuracao_repository
    ) {
        $this->gateway_pagamento_repository = $gateway_pagamento_repository;
        $this->gateway_configuracao_repository = $gateway_configuracao_repository;
    }

    /**
     * @param AtualizarInformacoesAmbienteCommand $command
     * @return GatewayPagamento
     * @throws GatewayPagamentoNaoEncontradoException
     */
    public function handle(AtualizarInformacoesAmbienteCommand $command): GatewayPagamento
    {
        $gateway_pagamento_id = $command->getGatewayPagamentoId();

        /** @var GatewayPagamento|null $gateway */
        $gateway = $this->gateway_pagamento_repository->find($gateway_pagamento_id);

        if (is_null($gateway)) {
            throw GatewayPagamentoNaoEncontradoException::porId($gateway_pagamento_id);
        }

        /** @var GatewayPagamentoConfiguracao|null $configuracao */
        $configuracao = $this->gateway_configuracao_repository->findOneBy([
            'gateway' => $gateway,
            'ambiente' => $command->getAmbiente()
        ]);

        if (is_null($configuracao)) {
            $configuracao = new GatewayPagamentoConfiguracao($gateway, $command->getUsuario(), $command->getSenha(), $command->getAmbiente());
            $this->gateway_configuracao_repository->create($configuracao);
            //$gateway->getConfiguracoes()->add($configuracao);
        } else {
            $configuracao->setUsuario($command->getUsuario());
            $configuracao->setSenha($command->getSenha());
            $this->gateway_configuracao_repository->update($configuracao);
            $gateway->setConfiguracaoAmbiente($command->getAmbiente(), $command->getUsuario(), $command->getSenha());
        }

        return $gateway;
    }
}