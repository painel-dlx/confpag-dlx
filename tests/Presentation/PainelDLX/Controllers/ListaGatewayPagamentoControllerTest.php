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

use DLX\Core\Exceptions\ArquivoConfiguracaoNaoEncontradoException;
use DLX\Core\Exceptions\ArquivoConfiguracaoNaoInformadoException;
use PainelDLX\Application\Services\Exceptions\AmbienteNaoInformadoException;
use PainelDLX\Application\Services\PainelDLX;
use PainelDLX\ConfPag\Presentation\PainelDLX\Controllers\ListaGatewayPagamentoController;
use PainelDLX\Tests\ConfPag\TestCase\ConfpagTestCase;
use PainelDLX\Tests\TestCase\IniciarPainelDLX;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Vilex\Exceptions\ContextoInvalidoException;
use Vilex\Exceptions\PaginaMestraNaoEncontradaException;
use Vilex\Exceptions\ViewNaoEncontradaException;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class ListaGatewayPagamentoControllerTest
 * @package PainelDLX\Tests\ConfPag\Presentation\PainelDLX\Controllers
 * @coversDefaultClass \PainelDLX\ConfPag\Presentation\PainelDLX\Controllers\ListaGatewayPagamentoController
 */
class ListaGatewayPagamentoControllerTest extends ConfpagTestCase
{
    /**
     * @throws ContextoInvalidoException
     * @throws PaginaMestraNaoEncontradaException
     * @throws ViewNaoEncontradaException
     */
    public function test_ListaGatewaysPagamento_deve_retornar_HtmlResponse()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getQueryParams')->willReturn([]);

        /** @var ServerRequestInterface $request */

        /** @var ListaGatewayPagamentoController $controller */
        $controller = self::$painel_dlx->getContainer()->get(ListaGatewayPagamentoController::class);
        $response = $controller->listaGatewaysPagamento($request);

        $this->assertInstanceOf(HtmlResponse::class, $response);
    }
}
