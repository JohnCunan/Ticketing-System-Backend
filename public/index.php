<?php // php -S localhost:8080 -t public/

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use DI\ContainerBuilder;

define('APP_ROOT', dirname(__DIR__));
    
require __DIR__ . '/../vendor/autoload.php';

//Dependency Injection
$builder = new ContainerBuilder;
$container = $builder->addDefinitions(APP_ROOT . '/config/definitions.php')
                    ->build();
AppFactory::setContainer($container);

$app = AppFactory::create();

//Routes
$app->get('/api', function (Request $request, Response $response) {
    
    $repository = $this->get(App\Repositories\ProductRepository::class);
    $data = $repository->getAll();
    $body = json_encode($data);
    $response->getBody()->write($body);

    return $response;
});

$app->run();