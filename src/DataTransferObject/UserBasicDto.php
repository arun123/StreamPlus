<?php

namespace App\DataTransferObject;

class UserBasicDto
{
    private $name = null;
    private $email = null;
    private $phoneNumber = null;
    private $subscriptionType = null;


    public function __construct()
    {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getSubscriptionType(): ?int
    {
        return $this->subscriptionType;
    }

    public function setSubscriptionType(?int $subscriptionType): void
    {
        $this->subscriptionType = $subscriptionType;
    }
}