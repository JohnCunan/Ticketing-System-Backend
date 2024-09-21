<?php // php -S localhost:8080 -t public/

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use DI\ContainerBuilder;
use Slim\Handlers\Strategies\RequestResponseArgs;

define('APP_ROOT', dirname(__DIR__));
    
require __DIR__ . '/../vendor/autoload.php';

//Dependency Injection
$builder = new ContainerBuilder;
$container = $builder->addDefinitions(APP_ROOT . '/config/definitions.php')
                    ->build();
AppFactory::setContainer($container);

//create slim app
$app = AppFactory::create();

//Route collector
$collector = $app->getRouteCollector();
$collector->setDefaultInvocationStrategy(new RequestResponseArgs);

//Routes
$app->get('/api', function (Request $request, Response $response) {
    
    //Create ProductRepository.php class object with DI
    $repository = $this->get(App\Repositories\ProductRepository::class);
    //Use the method in that class
    $data = $repository->getAll();
    //Convert the extracted data to JSON
    $body = json_encode($data);
    //Send the response
    $response->getBody()->write($body);

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/users/{id:[0-9]+}', function (Request $request, Response $response, string $id) {

    $repository = $this->get(App\Repositories\ProductRepository::class);
    
    $data = $repository->getById((int) $id);
    
    $body = json_encode($data);
    
    $response->getBody()->write($body);
    
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();