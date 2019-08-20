<?php
declare(strict_types=1);

namespace App\Application\Actions\Pet;

use Psr\Http\Message\ResponseInterface as Response;

class ViewPetAction extends PetAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user = $this->petRepository->findPetOfId($userId);

        $this->logger->info("Pet of id `${userId}` was viewed.");

        return $this->respondWithData($user);
    }
}
