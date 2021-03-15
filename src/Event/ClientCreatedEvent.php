<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Client;

class ClientCreatedEvent
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}