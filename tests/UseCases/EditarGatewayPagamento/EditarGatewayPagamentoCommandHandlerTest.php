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

namespace PainelDLX\Tests\ConfPag\UseCases\EditarGatewayPagamento;

use PainelDLX\ConfPag\Domain\Entities\GatewayPagamento;
use PainelDLX\ConfPag\Domain\Exceptions\GatewayPagamentoNaoEncontradoException;
use PainelDLX\ConfPag\Domain\Repositories\GatewayPagamentoRepositoryInterface;
use PainelDLX\ConfPag\UseCases\EditarGatewayPagamento\EditarGatewayPagamentoCommand;
use PainelDLX\ConfPag\UseCases\EditarGatewayPagamento\EditarGatewayPagamentoCommandHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class EditarGatewayPagamentoCommandHandlerTest
 * @package PainelDLX\Tests\ConfPag\UseCases\EditarGatewayPagamento
 * @coversDefaultClass \PainelDLX\ConfPag\UseCases\EditarGatewayPagamento\EditarGatewayPagamentoCommandHandler
 */
class EditarGatewayPagamentoCommandHandlerTest extends TestCase
{
    /**
     * @covers ::handle
     * @throws GatewayPagamentoNaoEncontradoException
     */
    public function test_Handle_deve_editar_informacoes_do_GatewayPagamento()
    {
        $gateway_pagamento_id = mt_rand();
        $nome = 'Teste';
        $servico = 'Teste\\Teste';
        $gateway = new GatewayPagamento($nome, $servico);

        $gateway_pagamento_repository = $this->createMock(GatewayPagamentoRepositoryInterface::class);
        $gateway_pagamento_repository->method('find')->willReturn($gateway);
        $gateway_pagamento_repository->method('update')->willReturn(null);

        /** @var GatewayPagamentoRepositoryInterface $gateway_pagamento_repository */

        $novo_nome = 'Outro Teste';
        $novo_servico = 'Teste\\OutroServico';
        $command = new EditarGatewayPagamentoCommand($gateway_pagamento_id, $novo_nome, $novo_servico);
        $handler = new EditarGatewayPagamentoCommandHandler($gateway_pagamento_repository);

        $gateway = $handler->handle($command);

        $this->assertEquals($novo_nome, $gateway->getNome());
        $this->assertEquals($novo_servico, $gateway->getNomeServico());
    }

    /**
     * @throws GatewayPagamentoNaoEncontradoException
     * @covers ::handle
     */
    public function test_Handle_deve_lancar_excecao_quando_nao_encontrar_o_GatewayPagamento()
    {
        $gateway_pagamento_repository = $this->createMock(GatewayPagamentoRepositoryInterface::class);
        $gateway_pagamento_repository->method('find')->willReturn(null);

        /** @var GatewayPagamentoRepositoryInterface $gateway_pagamento_repository */

        $this->expectException(GatewayPagamentoNaoEncontradoException::class);
        $this->expectExceptionCode(10);

        $command = new EditarGatewayPagamentoCommand(mt_rand(), 'Teste', 'Teste\\Teste');
        $handler = new EditarGatewayPagamentoCommandHandler($gateway_pagamento_repository);
        $handler->handle($command);
    }
}
