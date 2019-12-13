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

namespace PainelDLX\ConfPag\UseCases\VincularUsuario;


use PainelDLX\ConfPag\Domain\Entities\GatewayPagamento;
use PainelDLX\ConfPag\Domain\Exceptions\GatewayPagamentoNaoEncontradoException;
use PainelDLX\ConfPag\Domain\Repositories\GatewayPagamentoRepositoryInterface;
use PainelDLX\Domain\Usuarios\Entities\Usuario;

/**
 * Class VincularUsuarioCommandHandler
 * @package PainelDLX\ConfPag\UseCases\VincularUsuario
 * @covers VincularUsuarioCommandHandlerTest
 */
class VincularUsuarioCommandHandler
{
    /**
     * @var GatewayPagamentoRepositoryInterface
     */
    private $gateway_pagamento_repository;

    /**
     * VincularUsuarioCommandHandler constructor.
     * @param GatewayPagamentoRepositoryInterface $gateway_pagamento_repository
     */
    public function __construct(GatewayPagamentoRepositoryInterface $gateway_pagamento_repository)
    {
        $this->gateway_pagamento_repository = $gateway_pagamento_repository;
    }

    /**
     * @param VincularUsuarioCommand $command
     * @return GatewayPagamento
     * @throws GatewayPagamentoNaoEncontradoException
     */
    public function handle(VincularUsuarioCommand $command): GatewayPagamento
    {
        $gateway_pagamento_id = $command->getGatewayPagamentoId();

        /** @var GatewayPagamento|null $gateway_pagamento */
        $gateway_pagamento = $this->gateway_pagamento_repository->find($gateway_pagamento_id);

        if (is_null($gateway_pagamento)) {
            throw GatewayPagamentoNaoEncontradoException::porId($gateway_pagamento_id);
        }

        /** @var Usuario $usuario */
        $usuario = $this->gateway_pagamento_repository->getReference(Usuario::class, $command->getUsuarioId());

        $gateway_pagamento->setUsuario($usuario);
        $this->gateway_pagamento_repository->update($gateway_pagamento);

        return $gateway_pagamento;
    }
}