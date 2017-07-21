<?php
/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Action\HomePageAction::class, 'home');
 * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
 * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
 * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
 * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Action\ContactAction::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

/** @var \Zend\Expressive\Application $app */
$app->get('/', App\Action\HomePageAction::class, 'home');
$app->get('/api/ping', App\Action\PingAction::class, 'api.ping');

$app->get('/api/book/{id:\d+}', Api\Books\Action\BookAction::class, 'book');

//$app->get('/test', new class() implements Interop\Http\ServerMiddleware\MiddlewareInterface {
//    public function process(\Psr\Http\Message\ServerRequestInterface $request, Interop\Http\ServerMiddleware\DelegateInterface $delegate)
//    {
//        // TODO: Implement __invoke() method.
//    }
//}, 'test');

$app->get('/post/{id:\d+}', Daisy\Action\PostAction::class, 'post');
$app->post('/post', Daisy\Action\PostCreateAction::class, 'post.create');
