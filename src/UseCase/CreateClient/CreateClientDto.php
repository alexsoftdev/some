<?php

declare(strict_types=1);

namespace App\UseCase\CreateClient;

use Symfony\Component\Validator\Constraints as Assert;

class CreateClientDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Length( max = 200 )
     */
    private string $name = '';

    /**
     * @Assert\NotBlank
     * @Assert\Length( max = 3000 )
     */
    private string $address = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CreateClientDto
     */
    public function setName(string $name): CreateClientDto
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return CreateClientDto
     */
    public function setAddress(string $address): CreateClientDto
    {
        $this->address = $address;
        return $this;
    }

}