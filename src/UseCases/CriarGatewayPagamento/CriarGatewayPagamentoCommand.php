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

namespace PainelDLX\ConfPag\UseCases\CriarGatewayPagamento;


class CriarGatewayPagamentoCommand
{
    /**
     * @var string
     */
    private $nome;
    /**
     * @var array
     */
    private $conf_sandbox;
    /**
     * @var array|null
     */
    private $conf_producao;

    /**
     * CriarGatewayPagamentoCommand constructor.
     * @param string $nome
     * @param array $conf_sandbox
     * @param array|null $conf_producao
     */
    public function __construct(string $nome, array $conf_sandbox, ?array $conf_producao)
    {
        $this->nome = $nome;
        $this->conf_sandbox = $conf_sandbox;
        $this->conf_producao = $conf_producao;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @return array
     */
    public function getConfSandbox(): array
    {
        return $this->conf_sandbox;
    }

    /**
     * @return array|null
     */
    public function getConfProducao(): ?array
    {
        return $this->conf_producao;
    }
}