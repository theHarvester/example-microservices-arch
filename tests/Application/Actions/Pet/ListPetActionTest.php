<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Pet;

use App\Application\Actions\ActionPayload;
use App\Domain\Pet\PetRepository;
use App\Domain\Pet\Pet;
use App\Domain\Pet\Tag;
use DI\Container;
use Tests\TestCase;

class ListPetActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $pet = new Pet(1, 'Doggo', 'available', Pet::CATEGORY_DOG, ['/path'], [new Tag(1, 'lovable')]);

        $petRepositoryProphecy = $this->prophesize(PetRepository::class);
        $petRepositoryProphecy
            ->findAll()
            ->willReturn([$pet])
            ->shouldBeCalledOnce();

        $container->set(PetRepository::class, $petRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/pet');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$pet]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
