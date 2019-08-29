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

namespace PainelDLX\Tests\ConfPag\Domain\Entities;

use PainelDLX\ConfPag\Domain\Entities\GatewayAmbiente;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamento;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamentoConfiguracao;
use PHPUnit\Framework\TestCase;

/**
 * Class GatewayPagamentoConfiguracaoTest
 * @package PainelDLX\Tests\ConfPag\Domain\Entities
 * @coversDefaultClass \PainelDLX\ConfPag\Domain\Entities\GatewayPagamentoConfiguracao
 */
class GatewayPagamentoConfiguracaoTest extends TestCase
{
    /**
     * @return GatewayPagamentoConfiguracao
     */
    public function test__construct(): GatewayPagamentoConfiguracao
    {
        /** @var GatewayPagamento $gateway */
        $gateway = $this->createMock(GatewayPagamento::class);
        $ambiente = GatewayAmbiente::SANDBOX;
        $usuario = mt_rand();
        $senha = md5('teste');

        $configuracao = new GatewayPagamentoConfiguracao($gateway, $usuario, $senha, $ambiente);

        $this->assertInstanceOf(GatewayPagamento::class, $configuracao->getGateway());
        $this->assertEquals($ambiente, $configuracao->getAmbiente());
        $this->assertEquals($usuario, $configuracao->getUsuario());
        $this->assertEquals($senha, $configuracao->getSenha());

        return $configuracao;
    }
}
