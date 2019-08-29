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

namespace PainelDLX\ConfPag\UseCases\CriarGatewayPagamento;


use PainelDLX\ConfPag\Domain\Entities\GatewayAmbiente;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamento;
use PainelDLX\ConfPag\Domain\Repositories\GatewayPagamentoRepositoryInterface;

/**
 * Class CriarGatewayPagamentoCommandHandler
 * @package PainelDLX\ConfPag\UseCases\CriarGatewayPagamento
 * @covers CriarGatewayPagamentoCommandHandlerTest
 */
class CriarGatewayPagamentoCommandHandler
{
    /**
     * @var GatewayPagamentoRepositoryInterface
     */
    private $gateway_pagamento_repository;

    /**
     * CriarGatewayPagamentoCommandHandler constructor.
     * @param GatewayPagamentoRepositoryInterface $gateway_pagamento_repository
     */
    public function __construct(GatewayPagamentoRepositoryInterface $gateway_pagamento_repository)
    {
        $this->gateway_pagamento_repository = $gateway_pagamento_repository;
    }

    /**
     * @param CriarGatewayPagamentoCommand $command
     * @return GatewayPagamento
     */
    public function handle(CriarGatewayPagamentoCommand $command): GatewayPagamento
    {
        $conf_sandbox = $command->getConfSandbox();
        $conf_producao = $command->getConfProducao();

        $gateway = new GatewayPagamento($command->getNome());
        $gateway->addConfiguracao(GatewayAmbiente::SANDBOX, $conf_sandbox['usuario'], $conf_sandbox['senha']);

        if (!is_null($conf_producao)) {
            $gateway->addConfiguracao(GatewayAmbiente::PRODUCAO, $conf_producao['usuario'], $conf_producao['senha']);
        }

        $this->gateway_pagamento_repository->create($gateway);

        return $gateway;
    }
}