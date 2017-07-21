<?php
namespace Daisy\Action;

use Daisy\{
    Entity\Comment, Repository\CommentRepository, Repository\PostRepository, Entity\CommentCollection
};
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

use Hal\HalResponseFactory;
use Hal\ResourceGenerator;
use RuntimeException;


class PostAction implements ServerMiddlewareInterface
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    private $commentRepository;

    /** @var ResourceGenerator */
    private $resourceGenerator;

    /** @var HalResponseFactory */
    private $responseFactory;

    public function __construct(
        PostRepository $postRepository,
        CommentRepository $commentRepository,
        ResourceGenerator $resourceGenerator,
        HalResponseFactory $responseFactory
    )
    {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
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

        /** @var CommentCollection $comments */
        $comments = $this->commentRepository->fetchAll();
        $comments->setItemCountPerPage(10);

        // $comment = new Comment();
        // $comment->post_id = 1;

        $resource = $this->resourceGenerator->fromObject($post, $request);
        $resource = $resource->embed('comment', $this->resourceGenerator->fromObject($comments, $request));
        // $resource = $resource->embed('comment', $this->resourceGenerator->fromObject($comment, $request));
        return $this->responseFactory->createResponse($request, $resource);
    }
}