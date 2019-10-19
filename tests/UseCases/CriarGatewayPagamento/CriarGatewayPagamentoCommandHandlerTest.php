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

namespace PainelDLX\Tests\ConfPag\UseCases\CriarGatewayPagamento;

use PainelDLX\ConfPag\Domain\Entities\GatewayAmbiente;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamento;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamentoConfiguracao;
use PainelDLX\ConfPag\Domain\Repositories\GatewayPagamentoRepositoryInterface;
use PainelDLX\ConfPag\UseCases\CriarGatewayPagamento\CriarGatewayPagamentoCommand;
use PainelDLX\ConfPag\UseCases\CriarGatewayPagamento\CriarGatewayPagamentoCommandHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class CriarGatewayPagamentoCommandHandlerTest
 * @package PainelDLX\Tests\ConfPag\UseCases\CriarGatewayPagamento
 * @coversDefaultClass \PainelDLX\ConfPag\UseCases\CriarGatewayPagamento\CriarGatewayPagamentoCommandHandler
 */
class CriarGatewayPagamentoCommandHandlerTest extends TestCase
{
    /**
     * @covers ::handle
     */
    public function test_Handle_deve_retornar_GatewayPagamento_criado()
    {
        $gateway_pagamento_repository = $this->createMock(GatewayPagamentoRepositoryInterface::class);
        $gateway_pagamento_repository->method('update')->willReturn(null);

        /** @var GatewayPagamentoRepositoryInterface $gateway_pagamento_repository */

        $nome = 'Pagateway';
        $classe_servico = "Pagamento\\{$nome}";
        $conf_sandbox = ['usuario' => mt_rand(), 'senha' => 'teste1'];
        $conf_producao = ['usuario' => mt_rand(), 'senha' => 'teste2'];

        $command = new CriarGatewayPagamentoCommand($nome, $classe_servico, $conf_sandbox, $conf_producao);
        $handler = new CriarGatewayPagamentoCommandHandler($gateway_pagamento_repository);

        $gateway = $handler->handle($command);
        $this->assertInstanceOf(GatewayPagamento::class, $gateway);
        $this->assertEquals($nome, $gateway->getNome());
        $this->assertInstanceOf(GatewayPagamentoConfiguracao::class, $gateway->getConfiguracaoAmbiente(GatewayAmbiente::SANDBOX));
        $this->assertInstanceOf(GatewayPagamentoConfiguracao::class, $gateway->getConfiguracaoAmbiente(GatewayAmbiente::PRODUCAO));
    }
}
