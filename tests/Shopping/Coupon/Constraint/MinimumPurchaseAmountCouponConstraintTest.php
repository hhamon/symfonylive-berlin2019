<?php

namespace Training\Tests\Shopping\Coupon\Constraint;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Training\Shopping\Coupon\Constraint\MinimumPurchaseAmountCouponConstraint;
use Training\Shopping\Coupon\Coupon;
use Training\Shopping\Coupon\IneligibleCouponException;
use Training\Shopping\Coupon\RateCoupon;
use Training\Shopping\Coupon\ValueCoupon;

final class MinimumPurchaseAmountCouponConstraintTest extends TestCase
{
    /**
     * @dataProvider provideCoupon
     */
    public function testCouponIsEligibleForDiscount(Money $expectedFinalAmount, Coupon $decoratedCoupon): void
    {
        $coupon = new MinimumPurchaseAmountCouponConstraint($decoratedCoupon, Money::EUR(5000));

        $this->assertEquals($expectedFinalAmount, $coupon->applyOn(Money::EUR(10000)));
    }

    public function provideCoupon(): iterable
    {
        yield [
            Money::EUR(9000),
            new ValueCoupon('ABC', Money::EUR(1000)),
        ];

        yield [
            Money::EUR(8000),
            new RateCoupon('ABC', .2),
        ];
    }

    /**
     * @dataProvider provideIneligibleCoupon
     */
    public function testCouponIsNotEligibleForDiscount(Coupon $decoratedCoupon): void
    {
        $coupon = new MinimumPurchaseAmountCouponConstraint($decoratedCoupon, Money::EUR(10000));

        $this->expectException(IneligibleCouponException::class);

        $coupon->applyOn(Money::EUR(9900));
    }

    public function provideIneligibleCoupon(): iterable
    {
        yield [new ValueCoupon('ABC', Money::EUR(1000))];
        yield [new RateCoupon('ABC', .2)];
    }
}