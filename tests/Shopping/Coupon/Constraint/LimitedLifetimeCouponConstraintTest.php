<?php

namespace Training\Tests\Shopping\Coupon\Constraint;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\ClockMock;
use Training\Shopping\Coupon\Constraint\LimitedLifetimeCouponConstraint;
use Training\Shopping\Coupon\IneligibleCouponException;
use Training\Shopping\Coupon\ValueCoupon;

final class LimitedLifetimeCouponConstraintTest extends TestCase
{
    private $decoratedCoupon;

    protected function setUp(): void
    {
        ClockMock::register(LimitedLifetimeCouponConstraint::class);

        $this->decoratedCoupon = new ValueCoupon('AC', Money::EUR(1000));
    }

    public function testCouponIsExpired(): void
    {
        ClockMock::withClockMock(strtotime('2019-04-15 20:45:12'));

        $coupon = LimitedLifetimeCouponConstraint::between($this->decoratedCoupon, '2019-01-01 00:00:00', '2019-04-15 08:00:00');

        $this->expectException(IneligibleCouponException::class);
        $this->expectExceptionMessage('Coupon is expired!');

        $coupon->applyOn(Money::EUR(3000));
    }

    public function testCouponIsNotYetEligible(): void
    {
        ClockMock::withClockMock(strtotime('2018-12-31 20:45:12'));

        $coupon = LimitedLifetimeCouponConstraint::between($this->decoratedCoupon, '2019-01-01 00:00:00', '2019-04-15 08:00:00');

        $this->expectException(IneligibleCouponException::class);
        $this->expectExceptionMessage('Coupon is not yet eligible!');

        $coupon->applyOn(Money::EUR(3000));
    }

    public function testCouponIsEligibleForDiscount(): void
    {
        ClockMock::withClockMock(strtotime('2019-04-05 20:45:12'));

        $coupon = LimitedLifetimeCouponConstraint::between($this->decoratedCoupon, '2019-01-01 00:00:00', '2019-04-15 08:00:00');

        $this->assertEquals(Money::EUR(2000), $coupon->applyOn(Money::EUR(3000)));
    }
}
