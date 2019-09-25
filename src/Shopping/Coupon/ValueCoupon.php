<?php

namespace Training\Shopping\Coupon;

use Money\Money;

final class ValueCoupon extends AbstractCoupon
{
    private $value;

    public function __construct(string $code, Money $value)
    {
        parent::__construct($code);

        $this->value = $value;
    }

    public function applyOn(Money $totalAmount): Money
    {
        $newAmount = $totalAmount->subtract($this->value);

        return $newAmount->isNegative() ? new Money(0, $newAmount->getCurrency()) : $newAmount;
    }
}