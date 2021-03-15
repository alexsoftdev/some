<?php

declare(strict_types=1);

namespace App\UseCase\CreateClient;

use App\Entity\Client;
use App\Event\ClientCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateClientHandler
{
    private ValidatorInterface $validator;
    private EntityManagerInterface $em;
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->validator = $validator;
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(CreateClientDto $dto): Client
    {
        // Это дубликат валидации на тот кейс, когда вызывающий код ее пропустил
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorsString = (string)$errors;
            throw new \InvalidArgumentException($errorsString);
        }

        $client = new Client();
        $client->setName($dto->getName());
        $client->setAddress($dto->getAddress());
        $this->em->persist($client);

        $this->em->flush();

        $event = new ClientCreatedEvent($client);
        $this->eventDispatcher->dispatch($event);

        return $client;
    }

}