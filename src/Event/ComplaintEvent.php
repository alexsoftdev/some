<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Complaint;

class ComplaintEvent
{
    private Complaint $complaint;

    public function __construct(Complaint $complaint)
    {
        $this->complaint = $complaint;
    }

    public function getComplaint(): Complaint
    {
        return $this->complaint;
    }
}