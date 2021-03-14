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

namespace PainelDLX\Tests\ConfPag\Presentation\PainelDLX\Controllers;

use PainelDLX\ConfPag\Presentation\PainelDLX\Controllers\DetalheGatewayPagamentoController;
use PainelDLX\Tests\ConfPag\TestCase\ConfpagTestCase;
use Psr\Http\Message\ServerRequestInterface;
use Vilex\Exceptions\PaginaMestraInvalidaException;
use Vilex\Exceptions\TemplateInvalidoException;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

$_SESSION = [];

/**
 * Class DetalheGatewayPagamentoControllerTest
 * @package PainelDLX\Tests\ConfPag\Presentation\PainelDLX\Controllers
 * @coversDefaultClass \PainelDLX\ConfPag\Presentation\PainelDLX\Controllers\DetalheGatewayPagamentoController
 */
class DetalheGatewayPagamentoControllerTest extends ConfpagTestCase
{
    /**
     * @throws PaginaMestraInvalidaException
     * @throws TemplateInvalidoException
     * @covers ::detalheGatewayPagamento
     */
    public function test_DetalheGatewayPagamento_deve_retornar_HtmlResponse()
    {
        $gateway_pagamento_id = mt_rand();

        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn([
            'gateway' => $gateway_pagamento_id
        ]);

        /** @var ServerRequestInterface $request */

        /** @var DetalheGatewayPagamentoController $controller */
        $controller = self::$painel_dlx->getContainer()->get(DetalheGatewayPagamentoController::class);
        $response = $controller->detalheGatewayPagamento($request);

        $this->assertInstanceOf(HtmlResponse::class, $response);
    }

    /**
     * @throws PaginaMestraInvalidaException
     * @throws TemplateInvalidoException
     * @covers ::formVincularUsuario
     */
    public function test_FormVincularUsuario_deve_retornar_HtmlResponse()
    {
        $gateway_pagamento_id = mt_rand();

        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn([
            'gateway' => $gateway_pagamento_id
        ]);

        /** @var ServerRequestInterface $request */

        /** @var DetalheGatewayPagamentoController $controller */
        $controller = self::$painel_dlx->getContainer()->get(DetalheGatewayPagamentoController::class);
        $response = $controller->formVincularUsuario($request);

        $this->assertInstanceOf(HtmlResponse::class, $response);
    }

    /**
     * @covers ::vincularUsuario
     */
    public function test_VincularUsuario_deve_retornar_JsonResponse()
    {
        $gateway_pagamento_id = mt_rand(1, 99999);
        $usuario_id = mt_rand(1, 99999);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getParsedBody')->willReturn([
            'gateway_pagamento_id' => $gateway_pagamento_id,
            'usuario_id' => $usuario_id
        ]);

        /** @var ServerRequestInterface $request */

        /** @var DetalheGatewayPagamentoController $controller */
        $controller = self::$painel_dlx->getContainer()->get(DetalheGatewayPagamentoController::class);
        $response = $controller->vincularUsuario($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
