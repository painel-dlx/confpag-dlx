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

namespace PainelDLX\Tests\ConfPag\UseCases\AtualizarInformacoesAmbiente;

use PainelDLX\ConfPag\Domain\Entities\GatewayAmbiente;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamento;
use PainelDLX\ConfPag\Domain\Exceptions\GatewayPagamentoNaoEncontradoException;
use PainelDLX\ConfPag\Domain\Repositories\GatewayPagamentoConfiguracaoRepositoryInterface;
use PainelDLX\ConfPag\Domain\Repositories\GatewayPagamentoRepositoryInterface;
use PainelDLX\ConfPag\UseCases\AtualizarInformacoesAmbiente\AtualizarInformacoesAmbienteCommand;
use PainelDLX\ConfPag\UseCases\AtualizarInformacoesAmbiente\AtualizarInformacoesAmbienteCommandHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class AtualizarInformacoesAmbienteCommandHandlerTest
 * @package PainelDLX\Tests\ConfPag\UseCases\AtualizarInformacoesAmbiente
 * @coversDefaultClass \PainelDLX\ConfPag\UseCases\AtualizarInformacoesAmbiente\AtualizarInformacoesAmbienteCommandHandler
 */
class AtualizarInformacoesAmbienteCommandHandlerTest extends TestCase
{
    /**
     * @covers ::handle
     * @throws GatewayPagamentoNaoEncontradoException
     */
    public function test_Handle_deve_atualizar_informacoes_de_um_determiando_ambiente()
    {
        $ambiente = GatewayAmbiente::SANDBOX;
        $usuario = mt_rand();
        $senha = 'teste1';
        $servico = 'Pagamento\\Pagateway';

        $gateway = new GatewayPagamento('Pagateway', $servico);
        $gateway->addConfiguracao($ambiente, $usuario, $senha);

        $gateway_pagamento_repository = $this->createMock(GatewayPagamentoRepositoryInterface::class);
        $gateway_pagamento_repository->method('find')->willReturn($gateway);
        $gateway_pagamento_repository->method('update')->willReturn(null);

        $gateway_pagamento_configuracao_repository = $this->createMock(GatewayPagamentoConfiguracaoRepositoryInterface::class);
        $gateway_pagamento_configuracao_repository->method('findOneBy')->willReturn($gateway->getConfiguracaoAmbiente($ambiente));

        /** @var GatewayPagamentoRepositoryInterface $gateway_pagamento_repository */
        /** @var GatewayPagamentoConfiguracaoRepositoryInterface $gateway_pagamento_configuracao_repository */

        $novo_usuario = mt_rand();
        $nova_senha = 'teste2';

        $command = new AtualizarInformacoesAmbienteCommand(mt_rand(), $ambiente, $novo_usuario, $nova_senha);
        $handler = new AtualizarInformacoesAmbienteCommandHandler($gateway_pagamento_repository, $gateway_pagamento_configuracao_repository);

        $gateway = $handler->handle($command);
        $configuracao = $gateway->getConfiguracaoAmbiente($ambiente);

        $this->assertEquals($novo_usuario, $configuracao->getUsuario());
        $this->assertEquals($nova_senha, $configuracao->getSenha());
    }

    /**
     * @covers ::handle
     * @throws GatewayPagamentoNaoEncontradoException
     */
    public function test_Handle_deve_lancar_excecao_quando_nao_encontrar_GatewayPagamento()
    {
        $ambiente = GatewayAmbiente::SANDBOX;
        $usuario = mt_rand();
        $senha = 'teste1';

        $gateway_pagamento_repository = $this->createMock(GatewayPagamentoRepositoryInterface::class);
        $gateway_pagamento_repository->method('find')->willReturn(null);

        $gateway_pagamento_configuracao_repository = $this->createMock(GatewayPagamentoConfiguracaoRepositoryInterface::class);

        /** @var GatewayPagamentoRepositoryInterface $gateway_pagamento_repository */
        /** @var GatewayPagamentoConfiguracaoRepositoryInterface $gateway_pagamento_configuracao_repository */

        $command = new AtualizarInformacoesAmbienteCommand(mt_rand(), $ambiente, $usuario, $senha);
        $handler = new AtualizarInformacoesAmbienteCommandHandler($gateway_pagamento_repository, $gateway_pagamento_configuracao_repository);

        $this->expectException(GatewayPagamentoNaoEncontradoException::class);
        $this->expectExceptionCode(10);

        $handler->handle($command);
    }
}
