<?php // php -S localhost:8080 -t public/

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

//Routes
$app->get('/api', function (Request $request, Response $response) {
    $response->getBody()->write("Hello world");
    return $response;
});

$app->run();