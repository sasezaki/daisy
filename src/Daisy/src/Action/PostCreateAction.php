<?php
namespace Daisy\Action;

use Interop\Http\ServerMiddleware\ {
    DelegateInterface, MiddlewareInterface
};
use Psr\Http\Message\ServerRequestInterface;
use Fig\Http\Message\StatusCodeInterface as StatusCode;

use Zend\Diactoros\Response;
use Hal\ {
    HalResource, Renderer\JsonRenderer, Link
};

use Daisy\Repository\PostRepository;
use Daisy\Entity\Post;
use Zend\Expressive\Helper\UrlHelper;

class PostCreateAction implements MiddlewareInterface
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    private $renderer;

    /** @var UrlHelper */
    private $urlHelper;

    public function __construct(
        PostRepository $postRepository,
        JsonRenderer $renderer,
        UrlHelper $urlHelper
    ){
        $this->postRepository = $postRepository;
        $this->renderer = $renderer;
        $this->urlHelper = $urlHelper;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $data = $request->getParsedBody();

        // @todo validate

        $post = new Post;
        $post->title = $data['title'];
        $post->body = $data['body'];

        $id = $this->postRepository->save($post);

        $url= $this->urlHelper->generate('post', ['id' => $id]);

        $resource = new HalResource;
        $resource = $resource->withLink(new Link('self', $url));

        return new Response\TextResponse(
            $this->renderer->render($resource),
            StatusCode::STATUS_CREATED,
            ['location' => $url]
        );
    }
}