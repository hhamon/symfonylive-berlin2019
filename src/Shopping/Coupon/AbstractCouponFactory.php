<?php

namespace Training\Shopping\Coupon;

use Training\Shopping\Coupon\CodeGenerator\CouponCodeGenerator;

abstract class AbstractCouponFactory implements CouponFactory
{
    private $codeGenerator;

    public function __construct(CouponCodeGenerator $codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;
    }

    public function createCoupon(array $context = []): Coupon
    {
        $code = $context['code'] ?? $this->codeGenerator->generate();

        return $this->issueCoupon($code, $context);
    }

    abstract protected function issueCoupon(string $code, array $context): Coupon;
}