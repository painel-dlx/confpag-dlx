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

namespace PainelDLX\ConfPag\Domain\Collections;


use Doctrine\Common\Collections\Collection;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamentoConfiguracao;

interface ConfiguracoesCollectionInterface extends Collection
{
    /**
     * Adicionar uma nova configuração.
     * @param $element
     * @return bool Sempre TRUE
     */
    public function add($element);

    /**
     * Pegar configuração de um ambiente epecífico.
     * @param string $ambiente
     * @return GatewayPagamentoConfiguracao|null
     */
    public function forAmbiente(string $ambiente): ?GatewayPagamentoConfiguracao;

    /**
     * Verificar se a collection já possui configuração de um determinado ambiente
     * @param string $ambiente
     * @return bool
     */
    public function hasAmbiente(string $ambiente): bool;
}