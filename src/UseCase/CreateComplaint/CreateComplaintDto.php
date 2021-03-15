<?php

declare(strict_types=1);

namespace App\UseCase\CreateComplaint;

use App\Entity\Client;
use Symfony\Component\Validator\Constraints as Assert;

class CreateComplaintDto
{
    /**
     * @Assert\NotBlank $client_id
     */
    private int $client_id;

    /**
     * @Assert\NotBlank
     * @Assert\Length( max = 150 )
     */
    private string $title = '';

    /**
     * @Assert\NotBlank
     * @Assert\Length( max = 3000 )
     */
    private string $text = '';

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->client_id;
    }

    /**
     * @param int $client_id
     * @return CreateComplaintDto
     */
    public function setClientId(int $client_id): CreateComplaintDto
    {
        $this->client_id = $client_id;
        return $this;
    }



    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return CreateComplaintDto
     */
    public function setTitle(string $title): CreateComplaintDto
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return CreateComplaintDto
     */
    public function setText(string $text): CreateComplaintDto
    {
        $this->text = $text;
        return $this;
    }



}