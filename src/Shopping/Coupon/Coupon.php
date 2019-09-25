<?php

namespace Training\Shopping\Coupon;

use Money\Money;

interface Coupon
{
    public function getCode(): string;

    public function applyOn(Money $totalAmount): Money;
}