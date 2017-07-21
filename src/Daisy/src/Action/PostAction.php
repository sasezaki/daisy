<?php
namespace Daisy\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

use Hal\HalResponseFactory;
use Hal\ResourceGenerator;
use RuntimeException;

use Daisy\Repository\PostRepository;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\JsonResponse;


class PostAction implements ServerMiddlewareInterface
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /** @var ResourceGenerator */
    private $resourceGenerator;

    /** @var HalResponseFactory */
    private $responseFactory;

    public function __construct(
        PostRepository $postRepository,
        ResourceGenerator $resourceGenerator,
        HalResponseFactory $responseFactory
    )
    {
        $this->postRepository = $postRepository;
        $this->resourceGenerator = $resourceGenerator;
        $this->responseFactory = $responseFactory;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $id = $request->getAttribute('id', false);
        if (! $id) {
            throw new RuntimeException('No post identifier provided', 400);
        }

        $post = $this->postRepository->get($id);
        if (!$post) {
            //
        }

        $resource = $this->resourceGenerator->fromObject($post, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }
}