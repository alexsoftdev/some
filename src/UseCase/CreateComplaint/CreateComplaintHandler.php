<?php

declare(strict_types=1);

namespace App\UseCase\CreateComplaint;

use App\Entity\Client;
use App\Entity\Complaint;
use App\Event\ComplaintCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateComplaintHandler
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

    public function handle(CreateComplaintDto $dto)
    {
        // Это дубликат валидации на тот кейс, когда вызывающий код ее пропустил
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            throw new \InvalidArgumentException($errorsString);
        }

        $complaint = new Complaint();

        /** @var Client $client */
        $client = $this->em->getRepository(Client::class)->find($dto->getClientId());
        $complaint->setClient($client);
        $complaint->setTitle($dto->getTitle());
        $complaint->setText($dto->getText());
        $this->em->persist($complaint);

        $this->em->flush();

        $event = new ComplaintCreatedEvent($complaint);
        $this->eventDispatcher->dispatch($event);

        return $complaint;
    }

}