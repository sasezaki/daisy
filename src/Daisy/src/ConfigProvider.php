<?php

namespace Daisy;

use Daisy\Action\PostCreateAction;
use Daisy\Repository\CommentRepository;
use Hal\Renderer\JsonRenderer;
use Psr\Container\ContainerInterface;
use Hal\HalResponseFactory;
use Hal\ResourceGenerator;

use Daisy\Repository\PostRepository;
use Daisy\Action\PostAction;
use Zend\Db\Adapter\Adapter;
use Zend\Expressive\Helper\UrlHelper;

/**
 * The configuration provider for the Daisy module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
                JsonRenderer::class => JsonRenderer::class
            ],
            'factories'  => [
                // action
                Action\PostAction::class => function (ContainerInterface $container) {
                    return new PostAction(
                        $container->get(PostRepository::class),
                        $container->get(CommentRepository::class),
                        $container->get(ResourceGenerator::class),
                        $container->get(HalResponseFactory::class)
                    );
                },
                Action\PostCreateAction::class => function (ContainerInterface $container) {
                    return new PostCreateAction(
                        $container->get(PostRepository::class),
                        $container->get(JsonRenderer::class),
                        $container->get(UrlHelper::class)
                    );
                },
                Action\CommentAction::class => new class {},
                Action\CommentsAction::class => new class {},
                // repository
                PostRepository::class => function (ContainerInterface $container) {
                    return new PostRepository($container->get(Adapter::class));
                },
                CommentRepository::class => function (ContainerInterface $container) {
                    return new CommentRepository($container->get(Adapter::class));
                }
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
