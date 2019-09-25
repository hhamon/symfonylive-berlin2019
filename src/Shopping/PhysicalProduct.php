<?php

namespace Training\Shopping;

use Money\Money;

class PhysicalProduct implements Product
{
    private $name;
    private $retailPrice;

    public function __construct(string $name, Money $retailPrice)
    {
        $this->name = $name;
        $this->retailPrice = $retailPrice;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRetailPrice(): Money
    {
        return $this->retailPrice;
    }
}