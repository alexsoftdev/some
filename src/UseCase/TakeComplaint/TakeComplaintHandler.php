<?php

declare(strict_types=1);

namespace App\UseCase\TakeComplaint;

use App\Event\ComplaintTakenEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TakeComplaintHandler
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

    public function handle(TakeComplaintDto $dto)
    {
        // Это дубликат валидации на тот кейс, когда вызывающий код ее пропустил
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            throw new \InvalidArgumentException($errorsString);
        }

        $complaint = $dto->getComplaint();
        $complaint->setInWork(true);
        $this->em->flush();

        $event = new ComplaintTakenEvent($complaint);
        $this->eventDispatcher->dispatch($event);

        return $complaint;
    }

}