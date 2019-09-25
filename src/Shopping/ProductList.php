<?php

namespace Training\Shopping;

use Assert\Assertion;
use Money\Money;

final class ProductList
{
    private $products = [];

    public function __construct(array $products)
    {
        Assertion::allIsInstanceOf($products, Product::class);

        $this->products = array_values($products);
    }

    public function byName(string $name): ?Product
    {
        // ...
    }

    public function getTotalRetailPrice(): Money
    {
        $totalPrice = $this->products[0]->getRetailPrice();
        $n = \count($this->products);
        for ($i = 1; $i < $n; ++$i) {
            $totalPrice = $totalPrice->add($this->products[$i]->getRetailPrice());
        }

        return $totalPrice;
    }

    public function toArray(): array
    {
        return $this->products;
    }
}