<?php
declare(strict_types=1);

namespace App\Application\Actions\Pet;

use App\Application\Actions\Action;
use App\Domain\Pet\PetRepository;
use Psr\Log\LoggerInterface;

abstract class PetAction extends Action
{
    /**
     * @var PetRepository
     */
    protected $petRepository;

    /**
     * @param LoggerInterface $logger
     * @param PetRepository  $petRepository
     */
    public function __construct(LoggerInterface $logger, PetRepository $petRepository)
    {
        parent::__construct($logger);
        $this->petRepository = $petRepository;
    }
}
