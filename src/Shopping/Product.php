<?php

namespace Training\Shopping;

use Money\Money;

interface Product
{
    public function getName(): string;

    public function getRetailPrice(): Money;
}