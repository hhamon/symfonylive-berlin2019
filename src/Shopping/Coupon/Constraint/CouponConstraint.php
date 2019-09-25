<?php

namespace Training\Shopping\Coupon\Constraint;

use Training\Shopping\Coupon\Coupon;

abstract class CouponConstraint implements Coupon
{
    protected $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function getCode(): string
    {
        return $this->coupon->getCode();
    }
}