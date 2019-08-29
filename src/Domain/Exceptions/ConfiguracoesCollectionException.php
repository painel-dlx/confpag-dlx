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

namespace PainelDLX\ConfPag\Domain\Exceptions;


use Error;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamentoConfiguracao;

class ConfiguracoesCollectionException extends Error
{
    /**
     * @return ConfiguracoesCollectionException
     */
    public static function itemInvalido(): self
    {
        return new self('O item deve ser uma instância de ' . GatewayPagamentoConfiguracao::class, 10);
    }

    /**
     * @param string $ambiente
     * @return ConfiguracoesCollectionException
     */
    public static function ambienteJaAdicionado(string $ambiente): self
    {
        return new self("Configuração do ambiente '{$ambiente}' já foi adicionado.", 11);
    }
}