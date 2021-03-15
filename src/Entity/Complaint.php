<?php

namespace App\Entity;

use App\Model\Currency\Entity\CurrencyType;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Complaint implements TimestampableInterface
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=150, options={"default": ""})
     * @Assert\Length( max = 150 )
     */
    private string $title = '';

    /**
     * @ORM\Column(type="text", options={"default": ""})
     * @Assert\Length( max = 3000 )
     */
    private string $text = '';

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     */
    private Client $client;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private bool $inWork = false;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return Complaint
     */
    public function setTitle(string $title): Complaint
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
     * @return Complaint
     */
    public function setText(string $text): Complaint
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     * @return Complaint
     */
    public function setClient(Client $client): Complaint
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return bool
     */
    public function isInWork(): bool
    {
        return $this->inWork;
    }

    /**
     * @param bool $inWork
     * @return Complaint
     */
    public function setInWork(bool $inWork): Complaint
    {
        $this->inWork = $inWork;
        return $this;
    }



}
