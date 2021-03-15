<?php

declare(strict_types=1);

namespace App\UseCase\TakeComplaint;

use App\Entity\Client;
use App\Entity\Complaint;
use Symfony\Component\Validator\Constraints as Assert;

class TakeComplaintDto
{
    /**
     * @Assert\NotBlank
     */
    private Complaint $complaint;

    /**
     * @return Complaint
     */
    public function getComplaint(): Complaint
    {
        return $this->complaint;
    }

    /**
     * @param Complaint $complaint
     * @return TakeComplaintDto
     */
    public function setComplaint(Complaint $complaint): TakeComplaintDto
    {
        $this->complaint = $complaint;
        return $this;
    }

}