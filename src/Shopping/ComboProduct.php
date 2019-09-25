<?php

namespace Training\Shopping;

use Assert\Assertion;
use Money\Money;

class ComboProduct implements Product
{
    private $name;
    private $retailPrice;

    /**
     * @param Product[] $products
     */
    private $products = [];

    public function __construct(string $name, array $products, Money $retailPrice = null)
    {
        Assertion::allIsInstanceOf($products, Product::class);
        Assertion::minCount($products, 2);

        $this->products = $products;
        $this->name = $name;
        $this->retailPrice = $retailPrice;
    }

    public function add(Product... $products): self
    {
        return new self($this->name, array_merge($this->products, $products), $this->retailPrice);
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

        $totalPrice = $this->products[0]->getRetailPrice();
        $n = \count($this->products);
        for ($i = 1; $i < $n; ++$i) {
            $totalPrice = $totalPrice->add($this->products[$i]->getRetailPrice());
        }

        return $totalPrice;
    }
}