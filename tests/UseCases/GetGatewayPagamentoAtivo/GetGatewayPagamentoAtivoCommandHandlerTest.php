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

namespace PainelDLX\Tests\ConfPag\UseCases\GetGatewayPagamentoAtivo;

use PainelDLX\ConfPag\Domain\Repositories\GatewayPagamentoRepositoryInterface;
use PainelDLX\ConfPag\UseCases\GetGatewayPagamentoAtivo\GetGatewayPagamentoAtivoCommand;
use PainelDLX\ConfPag\UseCases\GetGatewayPagamentoAtivo\GetGatewayPagamentoAtivoCommandHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class GetGatewayPagamentoAtivoCommandHandlerTest
 * @package PainelDLX\Tests\ConfPag\UseCases\GetGatewayPagamentoAtivo
 * @coversDefaultClass \PainelDLX\ConfPag\UseCases\GetGatewayPagamentoAtivo\GetGatewayPagamentoAtivoCommandHandler
 */
class GetGatewayPagamentoAtivoCommandHandlerTest extends TestCase
{
    /**
     * @covers ::handle
     */
    public function test_Handle_deve_retornar_null_quando_nao_encontrar_nenhum_GatewayPagamento_ativo()
    {
        $gateway_pagamento_repository = $this->createMock(GatewayPagamentoRepositoryInterface::class);
        $gateway_pagamento_repository->method('findBy')->willReturn(null);

        $command = $this->createMock(GetGatewayPagamentoAtivoCommand::class);

        /** @var GatewayPagamentoRepositoryInterface $gateway_pagamento_repository */
        /** @var GetGatewayPagamentoAtivoCommand $command */

        $gateway_pagamento_ativo = (new GetGatewayPagamentoAtivoCommandHandler($gateway_pagamento_repository))->handle($command);

        $this->assertNull($gateway_pagamento_ativo);
    }
}
