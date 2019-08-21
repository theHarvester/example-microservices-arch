<?php
declare(strict_types=1);

namespace App\Application\Actions\Pet;

use Psr\Http\Message\ResponseInterface as Response;

class CreatePetAction extends PetAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // TODO this is incomplete

        $users = $this->petRepository->findAll();

        $this->logger->info("Users list was viewed.");

        return $this->respondWithData($users);
    }
}
