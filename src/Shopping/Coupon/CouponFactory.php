<?php

namespace Training\Shopping\Coupon;

interface CouponFactory
{
    public function createCoupon(array $context = []): Coupon;
}