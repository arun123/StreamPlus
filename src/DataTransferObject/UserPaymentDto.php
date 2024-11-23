<?php

namespace App\DataTransferObject;

use DateTime;

class UserPaymentDto
{
    private $ccNumber = null;
    private $cvv = null;
    private $expirationDate = null;

    public function __construct()
    {
    }

    public function getCcNumber(): ?string
    {
        return $this->ccNumber;
    }

    public function setCcNumber(string $ccNumber): self
    {
        $this->ccNumber = $ccNumber;

        return $this;
    }

    public function getCvv(): ?string
    {
        return $this->cvv;
    }

    public function setCvv(string $cvv): self
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function getExpirationDate(): ?string
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(string $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }
}