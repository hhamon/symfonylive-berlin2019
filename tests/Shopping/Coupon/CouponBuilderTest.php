<?php

namespace Training\Tests\Shopping\Coupon;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Training\Shopping\Coupon\Constraint\LimitedLifetimeCouponConstraint;
use Training\Shopping\Coupon\Constraint\MinimumPurchaseAmountCouponConstraint;
use Training\Shopping\Coupon\CouponBuilder;
use Training\Shopping\Coupon\RateCoupon;
use Training\Shopping\Coupon\ValueCoupon;

final class CouponBuilderTest extends TestCase
{
    public function testCreateSimpleValueCoupon(): void
    {
        $this->assertEquals(
            new ValueCoupon('ABC', Money::EUR(1000)),
            CouponBuilder::ofValue('ABC', 'EUR 1000')->getCoupon()
        );
    }

    public function testCreateSimpleRateCoupon(): void
    {
        $this->assertEquals(
            new RateCoupon('ABC', .2),
            CouponBuilder::ofRate('ABC', .2)->getCoupon()
        );
    }

    public function testCreateSimplePercentageCoupon(): void
    {
        $this->assertEquals(
            new RateCoupon('ABC', .2),
            CouponBuilder::ofPercentage('ABC', 20)->getCoupon()
        );
    }

    public function testCreateAdvancedValueCoupon(): void
    {
        $this->assertEquals(
            LimitedLifetimeCouponConstraint::between(
                new MinimumPurchaseAmountCouponConstraint(
                    new ValueCoupon('ABC', Money::EUR(1000)),
                    Money::EUR(5000)
                ),
                '2019-04-15',
            '2019-10-10'
            ),
            CouponBuilder::ofValue('ABC', 'EUR 1000')
                ->requiresMinimumPurchaseAmountOf('EUR 5000')
                ->usableBetween('2019-04-15', '2019-10-10')
                ->getCoupon()
        );
    }
}