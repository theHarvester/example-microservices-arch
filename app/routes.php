<?php
declare(strict_types=1);

use App\Application\Actions\Pet\CreatePetAction;
use App\Application\Actions\Pet\ListPetsAction;
use App\Application\Actions\Pet\ViewPetAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/pet', function (Group $group) use ($container) {
        $group->get('', ListPetsAction::class);
        $group->get('/{id}', ViewPetAction::class);
        $group->post('/', CreatePetAction::class);
    });
};
