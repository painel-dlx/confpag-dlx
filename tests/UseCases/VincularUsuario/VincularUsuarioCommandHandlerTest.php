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

namespace PainelDLX\Tests\ConfPag\UseCases\VincularUsuario;

use PainelDLX\ConfPag\Domain\Entities\GatewayPagamento;
use PainelDLX\ConfPag\Domain\Exceptions\GatewayPagamentoNaoEncontradoException;
use PainelDLX\ConfPag\Domain\Repositories\GatewayPagamentoRepositoryInterface;
use PainelDLX\ConfPag\UseCases\VincularUsuario\VincularUsuarioCommand;
use PainelDLX\ConfPag\UseCases\VincularUsuario\VincularUsuarioCommandHandler;
use PainelDLX\Domain\Usuarios\Entities\Usuario;
use PHPUnit\Framework\TestCase;

/**
 * Class VincularUsuarioCommandHandlerTest
 * @package PainelDLX\Tests\ConfPag\UseCases\VincularUsuario
 * @coversDefaultClass \PainelDLX\ConfPag\UseCases\VincularUsuario\VincularUsuarioCommandHandler
 */
class VincularUsuarioCommandHandlerTest extends TestCase
{
    /**
     * @covers ::handle
     * @throws GatewayPagamentoNaoEncontradoException
     */
    public function test_Handle_deve_lancar_excecao_quando_nao_encontrar_GatewayPagamento()
    {
        $usuario_id = mt_rand();
        $gateway_pagamento_id = mt_rand();

        $gateway_pagamento_repository = $this->createMock(GatewayPagamentoRepositoryInterface::class);
        $gateway_pagamento_repository->method('find')->willReturn(null);

        /** @var GatewayPagamentoRepositoryInterface $gateway_pagamento_repository */

        $this->expectException(GatewayPagamentoNaoEncontradoException::class);
        $this->expectExceptionCode(10);

        $command = new VincularUsuarioCommand($usuario_id, $gateway_pagamento_id);
        (new VincularUsuarioCommandHandler($gateway_pagamento_repository))->handle($command);
    }

    /**
     * @throws GatewayPagamentoNaoEncontradoException
     * @covers ::handle
     */
    public function test_Handle_deve_vincular_Usuario_ao_GatewayPagamento()
    {
        $usuario_id = mt_rand(1, 99999);
        $gateway_pagamento_id = mt_rand(1, 99999);

        $usuario = $this->createMock(Usuario::class);
        $usuario->method('getId')->willReturn($usuario_id);

        $gateway_pagamento = $this->getMockBuilder(GatewayPagamento::class)
            ->setMethods(['getId'])
            ->disableOriginalConstructor()
            ->getMock();
        $gateway_pagamento->method('getId')->willReturn($gateway_pagamento_id);

        $gateway_pagamento_repository = $this->createMock(GatewayPagamentoRepositoryInterface::class);
        $gateway_pagamento_repository->method('find')->willReturn($gateway_pagamento);
        $gateway_pagamento_repository->method('getReference')->willReturn($usuario);

        /** @var GatewayPagamentoRepositoryInterface $gateway_pagamento_repository */

        $command = new VincularUsuarioCommand($usuario_id, $gateway_pagamento_id);
        $gateway_pagamento = (new VincularUsuarioCommandHandler($gateway_pagamento_repository))->handle($command);

        $this->assertInstanceOf(GatewayPagamento::class, $gateway_pagamento);
        $this->assertEquals($gateway_pagamento_id, $gateway_pagamento->getId());
        $this->assertEquals($usuario_id, $gateway_pagamento->getUsuario()->getId());
    }
}
