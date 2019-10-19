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

use PainelDLX\ConfPag\Domain\Collections\ConfiguracoesCollectionInterface;
use PainelDLX\ConfPag\Domain\Entities\GatewayAmbiente;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamento;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamentoConfiguracao;
use PainelDLX\ConfPag\Domain\Exceptions\ConfiguracoesCollectionException;
use PHPUnit\Framework\TestCase;

/**
 * Class GatewayPagamentoTest
 * @package PainelDLX\Tests\ConfPag\Domain\Entities
 * @coversDefaultClass \PainelDLX\ConfPag\Domain\Entities\GatewayPagamento
 */
class GatewayPagamentoTest extends TestCase
{
    /**
     * @return GatewayPagamento
     */
    public function test__construct(): GatewayPagamento
    {
        $nome = 'Pagateway';
        $nome_servico = "Pagamento\\{$nome}";
        $gateway = new GatewayPagamento($nome, $nome_servico);

        $this->assertInstanceOf(GatewayPagamento::class, $gateway);
        $this->assertEquals($nome, $gateway->getNome());
        $this->assertEquals($nome, (string)$gateway);
        $this->assertEquals($nome_servico, $gateway->getNomeServico());
        $this->assertFalse($gateway->isDeletado());
        $this->assertInstanceOf(ConfiguracoesCollectionInterface::class, $gateway->getConfiguracoes());

        return $gateway;
    }

    /**
     * @param GatewayPagamento $gateway
     * @covers ::addConfiguracao
     * @depends test__construct
     */
    public function test_AddConfiguracao_deve_instanciar_GatewayPagamentoConfiguracao_e_adicionar_a_Collection(GatewayPagamento $gateway)
    {
        $gateway->getConfiguracoes()->clear();

        $ambiente = GatewayAmbiente::SANDBOX;
        $usuario = mt_rand();
        $senha = md5('teste');

        $gateway->addConfiguracao($ambiente, $usuario, $senha);

        /** @var GatewayPagamentoConfiguracao $configuracao_adicionada */
        $configuracao_adicionada = $gateway->getConfiguracoes()->get(0);

        $this->assertCount(1, $gateway->getConfiguracoes());
        $this->assertEquals($ambiente, $configuracao_adicionada->getAmbiente());
        $this->assertEquals($usuario, $configuracao_adicionada->getUsuario());
        $this->assertEquals($senha, $configuracao_adicionada->getSenha());
    }

    /**
     * @param GatewayPagamento $gateway
     * @covers ::addConfiguracao
     * @depends test__construct
     */
    public function test_AddConfiguracao_deve_lancar_excecao_quando_tentar_adicionar_ambiente_repetido(GatewayPagamento $gateway)
    {
        $gateway->getConfiguracoes()->clear();

        $ambiente = GatewayAmbiente::SANDBOX;
        $usuario = mt_rand();
        $senha = md5('teste');

        $this->expectException(ConfiguracoesCollectionException::class);
        $this->expectExceptionCode(11);

        $gateway->addConfiguracao($ambiente, $usuario, $senha);
        $gateway->addConfiguracao($ambiente, $usuario, $senha);
    }

    /**
     * @param GatewayPagamento $gateway
     * @covers ::getConfiguracaoAmbiente
     * @depends test__construct
     */
    public function test_GetConfiguracaoAmbiente_deve_retornar_GatewayPagamentoConfiguracao_do_ambiente_desejado(GatewayPagamento $gateway)
    {
        $gateway->getConfiguracoes()->clear();
        $gateway->addConfiguracao(GatewayAmbiente::SANDBOX, mt_rand(), 'teste1');
        $gateway->addConfiguracao(GatewayAmbiente::PRODUCAO, mt_rand(), 'teste2');

        $ambiente_desejado = GatewayAmbiente::PRODUCAO;
        $configuracao = $gateway->getConfiguracaoAmbiente($ambiente_desejado);

        $this->assertEquals($ambiente_desejado, $configuracao->getAmbiente());
    }

    /**
     * @param GatewayPagamento $gateway
     * @covers ::getConfiguracaoAmbiente
     * @depends test__construct
     */
    public function test_GetConfiguracaoAmbiente_deve_retornar_null_quando_nao_tiver_ambiente_desejado(GatewayPagamento $gateway)
    {
        $gateway->getConfiguracoes()->clear();
        $gateway->addConfiguracao(GatewayAmbiente::SANDBOX, mt_rand(), 'teste1');

        $ambiente_desejado = GatewayAmbiente::PRODUCAO;
        $configuracao = $gateway->getConfiguracaoAmbiente($ambiente_desejado);

        $this->assertNull($configuracao);
    }
}
