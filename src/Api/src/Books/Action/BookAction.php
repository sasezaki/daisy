<?php
namespace Api\Books\Action;

use Api\Books\Repository;
use Hal\HalResource;
use Hal\Link;
use Hal\Renderer\JsonRenderer;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use Zend\Diactoros\Response\TextResponse;

class BookAction implements MiddlewareInterface
{
    /** @var JsonRenderer */
    private $renderer;

    /** @var Repository */
    private $repository;

    public function __construct(
        Repository $repository,
        JsonRenderer $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $id = $request->getAttribute('id', false);
        if (! $id) {
            throw new RuntimeException('No book identifier provided', 400);
        }

        $book = $this->repository->get($id);

        $resource = new HalResource((array) $book);
        $resource = $resource->withLink(new Link('self'));

        return new TextResponse(
            $this->renderer->render($resource),
            200,
            ['Content-Type' => 'application/hal+json']
        );
    }
}