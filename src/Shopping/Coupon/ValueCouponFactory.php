<?php

namespace Training\Shopping\Coupon;

use Assert\Assertion;
use Money\Currency;
use Money\Money;

final class ValueCouponFactory extends AbstractCouponFactory
{
    protected function issueCoupon(string $code, array $context): Coupon
    {
        Assertion::keyExists($context, 'currency');
        Assertion::keyExists($context, 'amount');
        Assertion::regex($context['currency'], '/^[A-Z]{3}$/');
        Assertion::integerish($context['amount']);

        return new ValueCoupon($code, new Money($context['amount'], new Currency($context['currency'])));
    }
}