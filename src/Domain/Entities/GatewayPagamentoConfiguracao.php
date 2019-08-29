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

namespace PainelDLX\ConfPag\Domain\Entities;


use DLX\Domain\Entities\Entity;

/**
 * Class GatewayPagamentoConfiguracao
 * @package PainelDLX\ConfPag\Domain\Entities
 * @covers GatewayPagamentoConfiguracaoTest
 */
class GatewayPagamentoConfiguracao extends Entity
{
    /** @var GatewayPagamento */
    private $gateway;
    /** @var string */
    private $ambiente = 'sandbox';
    /** @var string */
    private $usuario;
    /** @var string */
    private $senha;

    /**
     * GatewayPagamentoConfiguracao constructor.
     * @param GatewayPagamento $gateway
     * @param string $usuario
     * @param string $senha
     * @param string $ambiente
     */
    public function __construct(
        GatewayPagamento $gateway,
        string $usuario,
        string $senha,
        string $ambiente = 'sandbox'
    ) {
        $this->gateway = $gateway;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->ambiente = $ambiente;
    }

    /**
     * @return GatewayPagamento
     */
    public function getGateway(): GatewayPagamento
    {
        return $this->gateway;
    }

    /**
     * @return string
     */
    public function getAmbiente(): string
    {
        return $this->ambiente;
    }

    /**
     * @return string
     */
    public function getUsuario(): string
    {
        return $this->usuario;
    }

    /**
     * @param string $usuario
     */
    public function setUsuario(string $usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return string
     */
    public function getSenha(): string
    {
        return $this->senha;
    }

    /**
     * @param string $senha
     */
    public function setSenha(string $senha): void
    {
        $this->senha = $senha;
    }
}