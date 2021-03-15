<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Complaint;

class ShortComplaintDto
{
    private int $id;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    private bool $inWork;

    private string $title;

    private string $text;

    public static function fromComplaint(Complaint $complaint): self
    {
        $self = new self();

        $self->id = $complaint->getId();
        $self->createdAt = $complaint->getCreatedAt();
        $self->updatedAt = $complaint->getUpdatedAt();
        $self->inWork = $complaint->isInWork();
        $self->title = $complaint->getTitle();
        $self->text = $complaint->getText();

        return $self;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return bool
     */
    public function isInWork(): bool
    {
        return $this->inWork;
    }



    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }




}