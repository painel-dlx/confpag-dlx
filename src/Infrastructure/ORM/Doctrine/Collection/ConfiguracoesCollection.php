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

namespace PainelDLX\ConfPag\Infrastructure\ORM\Doctrine\Collection;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use PainelDLX\ConfPag\Domain\Collections\ConfiguracoesCollectionInterface;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamentoConfiguracao;
use PainelDLX\ConfPag\Domain\Exceptions\ConfiguracoesCollectionException;

class ConfiguracoesCollection extends ArrayCollection implements ConfiguracoesCollectionInterface
{
    /**
     * @param GatewayPagamentoConfiguracao $element
     * @return bool|true
     */
    public function add($element)
    {
        if (!$element instanceof GatewayPagamentoConfiguracao) {
            throw ConfiguracoesCollectionException::itemInvalido();
        }

        $ambiente = $element->getAmbiente();

        if ($this->hasAmbiente($ambiente)) {
            throw ConfiguracoesCollectionException::ambienteJaAdicionado($ambiente);
        }

        return parent::add($element);
    }

    /**
     * Pegar configuração de um ambiente epecífico.
     * @param string $ambiente
     * @return GatewayPagamentoConfiguracao|null
     */
    public function forAmbiente(string $ambiente): ?GatewayPagamentoConfiguracao
    {
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq('ambiente', $ambiente));

        return $this->matching($criteria)->first() ?: null;
    }

    /**
     * Verificar se a collection já possui configuração de um determinado ambiente
     * @param string $ambiente
     * @return bool
     */
    public function hasAmbiente(string $ambiente): bool
    {
        return $this->exists(function ($key, GatewayPagamentoConfiguracao $configuracao) use ($ambiente) {
            return $configuracao->getAmbiente() === $ambiente;
        });
    }
}