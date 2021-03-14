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
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamento;
use PainelDLX\ConfPag\Domain\Exceptions\GatewayPagamentoNaoEncontradoException;
use PainelDLX\ConfPag\UseCases\AtualizarInformacoesAmbiente\AtualizarInformacoesAmbienteCommand;
use PainelDLX\ConfPag\UseCases\AtualizarInformacoesAmbiente\AtualizarInformacoesAmbienteCommandHandler;
use PainelDLX\ConfPag\UseCases\GetGatewayPagamentoPorId\GetGatewayPagamentoPorIdCommand;
use PainelDLX\Presentation\Web\Common\Controllers\PainelDLXController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Vilex\Exceptions\PaginaMestraInvalidaException;
use Vilex\Exceptions\TemplateInvalidoException;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class ConfiguracaoAmbienteController
 * @package PainelDLX\ConfPag\Presentation\PainelDLX\Controllers
 * @covers ConfiguracaoAmbienteControllerTest
 */
class ConfiguracaoAmbienteController extends PainelDLXController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface
     * @throws PaginaMestraInvalidaException
     * @throws TemplateInvalidoException
     */
    public function formConfiguracaoAmbiente(ServerRequestInterface $request, array $args = []): ResponseInterface
    {
        $get = $request->getQueryParams();
        $ambiente = $args['ambiente'];

        try {
            /** @var GatewayPagamento $gateway_pagamento */
            $gateway_pagamento = $this->command_bus->handle(new GetGatewayPagamentoPorIdCommand($get['gateway']));
            $gateway_pagamento_configuracao = $gateway_pagamento->getConfiguracaoAmbiente($ambiente);

            // Parâmetros
            $this->view->setAtributo('titulo-pagina', "Configuração de ambiente de {$ambiente}");
            $this->view->setAtributo('gateway-pagamento', $gateway_pagamento);
            $this->view->setAtributo('gateway-pagamento-configuracao', $gateway_pagamento_configuracao);
            $this->view->setAtributo('ambiente-configuracao', $ambiente);

            // Views
            $this->view->addTemplate('painel-dlx/gateways-pagamento/form_configuracao_ambiente');

            // JS
            $versao = Configure::get('app', 'versao');
            $this->view->adicionarJS('vendor/dlepera88-jquery/jquery-form-ajax/jquery.formajax.plugin-min.js', $versao);
            $this->view->adicionarJS('public/js/confpag-min.js', $versao);
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
     * @param array $args
     * @return ResponseInterface
     */
    public function salvarConfiguracaoAmbiente(ServerRequestInterface $request, array $args = []): ResponseInterface
    {
        $get = $request->getParsedBody();
        $ambiente = $args['ambiente'];

        try {
            /* @see AtualizarInformacoesAmbienteCommandHandler */
            $this->command_bus->handle(new AtualizarInformacoesAmbienteCommand(
                $get['gateway'],
                $ambiente,
                $get['usuario'],
                $get['senha']
            ));

            $json['retorno'] = 'sucesso';
            $json['mensagem'] = 'Configurações salvas com sucesso!';
        } catch (GatewayPagamentoNaoEncontradoException $e) {
            $json['retorno'] = 'erro';
            $json['mensagem'] = $e->getMessage();
        }

        return new JsonResponse($json);
    }
}