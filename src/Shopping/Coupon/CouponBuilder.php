<?php

namespace Training\Shopping\Coupon;

use Money\Currency;
use Money\Money;
use Training\Shopping\Coupon\Constraint\LimitedLifetimeCouponConstraint;
use Training\Shopping\Coupon\Constraint\MinimumPurchaseAmountCouponConstraint;

class CouponBuilder
{
    private $coupon;

    private function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public static function ofRate(string $code, float $rate): self
    {
        return new self(new RateCoupon($code, $rate));
    }

    public static function ofPercentage(string $code, float $percentage): self
    {
        return new self(RateCoupon::fromPercentage($code, $percentage));
    }

    // ofValue('CODE', 'EUR 1000')
    public static function ofValue(string $code, string $moneyValue): self
    {
        [$currency, $amount] = explode(' ', $moneyValue);

        return new self(new ValueCoupon($code, new Money($amount, new Currency($currency))));
    }

    public function requiresMinimumPurchaseAmountOf(string $moneyValue)
    {
        [$currency, $amount] = explode(' ', $moneyValue);

        $this->coupon = new MinimumPurchaseAmountCouponConstraint($this->coupon, new Money($amount, new Currency($currency)));

        return $this;
    }

    public function usableBetween(string $from, string $until)
    {
        $this->coupon = LimitedLifetimeCouponConstraint::between($this->coupon, $from, $until);

        return $this;
    }

    public function getCoupon(): Coupon
    {
        return $this->coupon;
    }
}