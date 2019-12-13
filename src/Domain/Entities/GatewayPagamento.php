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

use CheckoutDLX\Domain\Services\Pagamento\GatewayPagamentoInterface;
use DLX\Domain\Entities\Entity;
use PainelDLX\ConfPag\Domain\Collections\ConfiguracoesCollectionInterface;
use PainelDLX\ConfPag\Infrastructure\ORM\Doctrine\Collection\ConfiguracoesCollection;
use PainelDLX\Domain\Usuarios\Entities\Usuario;

/**
 * Class GatewayPagamento
 * @package PainelDLX\ConfPag\Domain\Entities
 * @covers GatewayPagamentoTest
 */
class GatewayPagamento extends Entity
{
    /** @var int|null */
    private $id;
    /** @var string */
    private $nome;
    /** @var Usuario */
    private $usuario;
    /** @var GatewayPagamentoInterface|string|null */
    private $servico;
    /** @var bool */
    private $ativo = false;
    /** @var bool */
    private $deletado = false;
    /** @var ConfiguracoesCollectionInterface */
    private $configuracoes;

    /**
     * GatewayPagamento constructor.
     * @param string $nome
     * @param string|null $servico
     */
    public function __construct(string $nome, ?string $servico)
    {
        $this->nome = $nome;
        $this->servico = $servico;
        $this->configuracoes = new ConfiguracoesCollection();
    }

    public function __toString()
    {
        return $this->getNome();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return Usuario|null
     */
    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     * @return GatewayPagamento
     */
    public function setUsuario(Usuario $usuario): GatewayPagamento
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomeServico(): string
    {
        return $this->servico;
    }

    /**
     * @param string $nome_servico
     * @return $this
     */
    public function setNomeServico(string $nome_servico): self
    {
        $this->servico = $nome_servico;
        return $this;
    }

    /**
     * @param string $ambiente
     * @return GatewayPagamentoInterface|null
     */
    public function getServico(string $ambiente = 'producao'): ?GatewayPagamentoInterface
    {
        if (is_string($this->servico)) {
            if (class_exists($this->servico)) {
                $configuracao = $this->getConfiguracaoAmbiente($ambiente);

                if (!is_null($configuracao)) {
                    $nomeServico = $this->getNomeServico();
                    return new $nomeServico($configuracao->getUsuario(), $configuracao->getSenha(), $configuracao->getAmbiente());
                }
            }

            return null;
        }

        return $this->servico;
    }

    /**
     * @return bool
     */
    public function isAtivo(): bool
    {
        return $this->ativo;
    }

    /**
     * @return bool
     */
    public function isDeletado(): bool
    {
        return $this->deletado;
    }

    /**
     * @return ConfiguracoesCollection
     */
    public function getConfiguracoes(): ConfiguracoesCollection
    {
        if (!$this->configuracoes instanceof ConfiguracoesCollectionInterface) {
            return new ConfiguracoesCollection($this->configuracoes->toArray());
        }

        return $this->configuracoes;
    }

    /**
     * @param string $ambiente
     * @param string $usuario
     * @param string $senha
     * @return GatewayPagamento
     */
    public function addConfiguracao(string $ambiente, string $usuario, string $senha): self
    {
        $configuracao = new GatewayPagamentoConfiguracao($this, $usuario, $senha, $ambiente);

        $this->getConfiguracoes()->add($configuracao);
        return $this;
    }
    
    /**
     * Obter configuração de um ambiente específico.
     * @param string $ambiente
     * @return GatewayPagamentoConfiguracao|null
     */
    public function getConfiguracaoAmbiente(string $ambiente): ?GatewayPagamentoConfiguracao
    {
        return $this->getConfiguracoes()->forAmbiente($ambiente);
    }

    /**
     * @param string $ambiente
     * @param string $usuario
     * @param string $senha
     * @return GatewayPagamento
     */
    public function setConfiguracaoAmbiente(string $ambiente, string $usuario, string $senha): self
    {
        $configuracao = $this->getConfiguracaoAmbiente($ambiente);

        if (!is_null($configuracao)) {
            $configuracao->setUsuario($usuario);
            $configuracao->setSenha($senha);
        }

        return $this;
    }
}