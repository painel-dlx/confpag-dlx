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

namespace PainelDLX\ConfPag\Application\Mappings;


use PainelDLX\ConfPag\UseCases\AtualizarInformacoesAmbiente\AtualizarInformacoesAmbienteCommand;
use PainelDLX\ConfPag\UseCases\AtualizarInformacoesAmbiente\AtualizarInformacoesAmbienteCommandHandler;
use PainelDLX\ConfPag\UseCases\CriarGatewayPagamento\CriarGatewayPagamentoCommand;
use PainelDLX\ConfPag\UseCases\CriarGatewayPagamento\CriarGatewayPagamentoCommandHandler;
use PainelDLX\ConfPag\UseCases\EditarGatewayPagamento\EditarGatewayPagamentoCommand;
use PainelDLX\ConfPag\UseCases\EditarGatewayPagamento\EditarGatewayPagamentoCommandHandler;
use PainelDLX\ConfPag\UseCases\GetGatewayPagamentoAtivo\GetGatewayPagamentoAtivoCommand;
use PainelDLX\ConfPag\UseCases\GetGatewayPagamentoAtivo\GetGatewayPagamentoAtivoCommandHandler;
use PainelDLX\ConfPag\UseCases\GetGatewayPagamentoPorId\GetGatewayPagamentoPorIdCommand;
use PainelDLX\ConfPag\UseCases\GetGatewayPagamentoPorId\GetGatewayPagamentoPorIdCommandHandler;
use PainelDLX\ConfPag\UseCases\ListaGatewaysPagamento\ListaGatewaysPagamentoCommand;
use PainelDLX\ConfPag\UseCases\ListaGatewaysPagamento\ListaGatewaysPagamentoCommandHandler;

class ConfpagMapping
{
    private $mapping = [
        ListaGatewaysPagamentoCommand::class => ListaGatewaysPagamentoCommandHandler::class,
        CriarGatewayPagamentoCommand::class => CriarGatewayPagamentoCommandHandler::class,
        EditarGatewayPagamentoCommand::class => EditarGatewayPagamentoCommandHandler::class,
        AtualizarInformacoesAmbienteCommand::class => AtualizarInformacoesAmbienteCommandHandler::class,
        GetGatewayPagamentoAtivoCommand::class => GetGatewayPagamentoAtivoCommandHandler::class,
        GetGatewayPagamentoPorIdCommand::class => GetGatewayPagamentoPorIdCommandHandler::class,
    ];

    /**
     * @return array
     */
    public function getMapping(): array
    {
        return $this->mapping;
    }
}