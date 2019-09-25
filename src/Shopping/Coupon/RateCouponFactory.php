<?php

namespace Training\Shopping\Coupon;

use Assert\Assertion;

final class RateCouponFactory extends AbstractCouponFactory
{
    protected function issueCoupon(string $code, array $context): Coupon
    {
        if (!empty($context['percentage'])) {
            $context['rate'] = $context['percentage'] / 100;
        }

        Assertion::keyExists($context, 'rate', 'The "factor" key is missing.');

        return new RateCoupon($code, $context['rate']);
    }
}