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

namespace PainelDLX\ConfPag\Presentation\PainelDLX\Controllers;


use DLX\Core\Configure;
use League\Tactician\CommandBus;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamento;
use PainelDLX\ConfPag\Domain\Exceptions\GatewayPagamentoNaoEncontradoException;
use PainelDLX\ConfPag\UseCases\GetGatewayPagamentoPorId\GetGatewayPagamentoPorIdCommand;
use PainelDLX\ConfPag\UseCases\VincularUsuario\VincularUsuarioCommand;
use PainelDLX\ConfPag\UseCases\VincularUsuario\VincularUsuarioCommandHandler;
use PainelDLX\Presentation\Site\Common\Controllers\PainelDLXController;
use PainelDLX\UseCases\Usuarios\GetListaUsuarios\GetListaUsuariosCommand;
use PainelDLX\UseCases\Usuarios\GetListaUsuarios\GetListaUsuariosCommandHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SechianeX\Contracts\SessionInterface;
use Vilex\Exceptions\ContextoInvalidoException;
use Vilex\Exceptions\PaginaMestraNaoEncontradaException;
use Vilex\Exceptions\ViewNaoEncontradaException;
use Vilex\VileX;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class DetalheGatewayPagamentoController
 * @package PainelDLX\ConfPag\Presentation\PainelDLX\Controllers
 * @covers DetalheGatewayPagamentoControllerTest
 */
class DetalheGatewayPagamentoController extends PainelDLXController
{
    /**
     * DetalheGatewayPagamentoController constructor.
     * @param VileX $view
     * @param CommandBus $commandBus
     * @param SessionInterface $session
     * @throws ViewNaoEncontradaException
     */
    public function __construct(VileX $view, CommandBus $commandBus, SessionInterface $session)
    {
        parent::__construct($view, $commandBus, $session);

        $this->view->addArquivoCss('public/temas/painel-dlx/css/confpag.tema.css', false, VERSAO_CONFPAG_DLX);
        $this->view->addArquivoJS('public/js/confpag-min.js', false, VERSAO_CONFPAG_DLX);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws PaginaMestraNaoEncontradaException
     * @throws ContextoInvalidoException
     * @throws ViewNaoEncontradaException
     */
    public function detalheGatewayPagamento(ServerRequestInterface $request): ResponseInterface
    {
        $get = $request->getQueryParams();

        try {
            /** @var GatewayPagamento $gateway_pagamento */
            $gateway_pagamento = $this->command_bus->handle(new GetGatewayPagamentoPorIdCommand($get['gateway']));

            // Parâmetros
            $this->view->setAtributo('titulo-pagina', "Gateway de Pagamento {$gateway_pagamento}");
            $this->view->setAtributo('gateway-pagamento', $gateway_pagamento);

            // Views
            $this->view->addTemplate('painel-dlx/gateways-pagamento/det_gateway_pagamento');
        } catch (GatewayPagamentoNaoEncontradoException $e) {
            $this->view->addTemplate('common/mensagem_usuario');
            $this->view->setAtributo('mensagem', [
                'tipo' => 'erro',
                'texto' => $e->getMessage()
            ]);
        }

        return $this->view->render();
    }

    /**
     * @todo fazer os testes unitários dos métodos formVincularUsuario e vincularUsuario
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws ContextoInvalidoException
     * @throws PaginaMestraNaoEncontradaException
     * @throws ViewNaoEncontradaException
     */
    public function formVincularUsuario(ServerRequestInterface $request): ResponseInterface
    {
        $get = $request->getQueryParams();

        try {
            /** @var GatewayPagamento $gateway_pagamento */
            $gateway_pagamento = $this->command_bus->handle(new GetGatewayPagamentoPorIdCommand($get['gateway']));

            /** @var array $lista_usuario */
            /* @see GetListaUsuariosCommandHandler */
            $lista_usuarios = $this->command_bus->handle(new GetListaUsuariosCommand());

            // Parâmetros
            $this->view->setAtributo('titulo-pagina', 'Vincular Usuário');
            $this->view->setAtributo('gateway-pagamento', $gateway_pagamento);
            $this->view->setAtributo('lista-usuarios', $lista_usuarios);

            // Views
            $this->view->addTemplate('painel-dlx/gateways-pagamento/form_vincular_usuario');

            // Arquivo JS
            $this->view->addArquivoJS('/vendor/dlepera88-jquery/jquery-form-ajax/jquery.formajax.plugin-min.js', false, VERSAO_CONFPAG_DLX);
        } catch (GatewayPagamentoNaoEncontradoException $e) {
            $this->view->addTemplate('common/mensagem_usuario');
            $this->view->setAtributo('mensagem', [
                'tipo' => 'erro',
                'texto' => $e->getMessage()
            ]);
        }

        return $this->view->render();
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function vincularUsuario(ServerRequestInterface $request): ResponseInterface
    {
        $post = $request->getParsedBody();

        try {
            /* @see VincularUsuarioCommandHandler */
            $this->command_bus->handle(new VincularUsuarioCommand($post['gateway_pagamento_id'], $post['usuario_id']));

            $json['retorno'] = 'sucesso';
            $json['mensagem'] = 'Usuário vinculado com sucesso!';
        } catch (GatewayPagamentoNaoEncontradoException $e) {
            $json['retorno'] = 'erro';
            $json['mensagem'] = $e->getMessage();
        }

        return new JsonResponse($json);
    }
}