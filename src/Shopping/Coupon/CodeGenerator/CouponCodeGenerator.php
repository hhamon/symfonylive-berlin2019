<?php

namespace Training\Shopping\Coupon\CodeGenerator;

interface CouponCodeGenerator
{
    public function generate(): string;
}