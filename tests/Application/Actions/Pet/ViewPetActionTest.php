<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Pet;

use App\Application\Actions\ActionError;
use App\Application\Actions\ActionPayload;
use App\Application\Handlers\HttpErrorHandler;
use App\Domain\Pet\Pet;
use App\Domain\Pet\PetNotFoundException;
use App\Domain\Pet\PetRepository;
use App\Domain\Pet\Tag;
use DI\Container;
use Slim\Middleware\ErrorMiddleware;
use Tests\TestCase;

class ViewPetActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $pet = new Pet(1, 'Doggo', 'available', Pet::CATEGORY_DOG, ['/path'], [new Tag(1, 'lovable')]);

        $petRepositoryProphecy = $this->prophesize(PetRepository::class);
        $petRepositoryProphecy
            ->findPetOfId(1)
            ->willReturn($pet)
            ->shouldBeCalledOnce();

        $container->set(PetRepository::class, $petRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/pet/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $pet);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsUserNotFoundException()
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false ,false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        $userRepositoryProphecy = $this->prophesize(PetRepository::class);
        $userRepositoryProphecy
            ->findPetOfId(1)
            ->willThrow(new PetNotFoundException())
            ->shouldBeCalledOnce();

        $container->set(PetRepository::class, $userRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/pet/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'The user you requested does not exist.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
