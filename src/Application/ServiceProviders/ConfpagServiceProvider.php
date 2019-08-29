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

namespace PainelDLX\ConfPag\Application\ServiceProviders;


use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamento;
use PainelDLX\ConfPag\Domain\Entities\GatewayPagamentoConfiguracao;
use PainelDLX\ConfPag\Domain\Repositories\GatewayPagamentoConfiguracaoRepositoryInterface;
use PainelDLX\ConfPag\Domain\Repositories\GatewayPagamentoRepositoryInterface;
use PainelDLX\Infrastructure\ORM\Doctrine\Services\RepositoryFactory;

class ConfpagServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        GatewayPagamentoRepositoryInterface::class,
        GatewayPagamentoConfiguracaoRepositoryInterface::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->leagueContainer property or the `getLeagueContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories();
    }

    /**
     * Registrar as repositories
     */
    private function registerRepositories(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(
            GatewayPagamentoRepositoryInterface::class,
            RepositoryFactory::create(GatewayPagamento::class)
        );

        $container->add(
            GatewayPagamentoConfiguracaoRepositoryInterface::class,
            RepositoryFactory::create(GatewayPagamentoConfiguracao::class)
        );
    }
}