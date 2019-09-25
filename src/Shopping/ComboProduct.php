<?php

namespace Training\Shopping;

use Assert\Assertion;
use Money\Money;

class ComboProduct implements Product
{
    private $name;
    private $retailPrice;
    private $products;

    public function __construct(string $name, array $products, Money $retailPrice = null)
    {
        Assertion::minCount($products, 2);

        $this->products = new ProductList($products);
        $this->name = $name;
        $this->retailPrice = $retailPrice;
    }

    public function add(Product... $products): self
    {
        return new self($this->name, array_merge($this->products->toArray(), $products), $this->retailPrice);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRetailPrice(): Money
    {
        if ($this->retailPrice) {
            return $this->retailPrice;
        }

        return $this->products->getTotalRetailPrice();
    }
}