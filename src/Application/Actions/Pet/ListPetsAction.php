<?php
declare(strict_types=1);

namespace App\Application\Actions\Pet;

use Psr\Http\Message\ResponseInterface as Response;

class ListPetsAction extends PetAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $params = $this->request->getQueryParams();

        $statusFilter = null;
        if (isset($params['status']) && is_string($params['status'])) {
            $statusFilter = $params['status'];
        }

        $pets = $this->petRepository->findAll($statusFilter);

        $this->logger->info("Pets list was viewed.");

        return $this->respondWithData($pets);
    }
}
