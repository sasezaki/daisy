<?php

namespace Api\Books\Action;

use Api\Books\Repository;
use Interop\Container\ContainerInterface;

use Hal\Renderer\JsonRenderer;

class BookFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $repository   = $container->get(Repository::class);

        return new BookAction($repository, new JsonRenderer());
    }
}
