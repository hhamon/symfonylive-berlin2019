<?php

namespace Training\Shopping\Coupon\Constraint;

use Money\Money;
use Training\Shopping\Coupon\Coupon;
use Training\Shopping\Coupon\IneligibleCouponException;

final class LimitedLifetimeCouponConstraint extends CouponConstraint
{
    private $from;
    private $until;

    public function __construct(Coupon $coupon, \DateTimeImmutable $from, \DateTimeImmutable $until)
    {
        parent::__construct($coupon);

        $this->from = $from;
        $this->until = $until;
    }

    public static function between(Coupon $coupon, string $from, string $until): self
    {
        return new self($coupon, new \DateTimeImmutable($from), new \DateTimeImmutable($until));
    }

    public function applyOn(Money $totalAmount): Money
    {
        if (time() < $this->from->getTimestamp()) {
            throw new IneligibleCouponException('Coupon is not yet eligible!', $this);
        }

        if (time() > $this->until->getTimestamp()) {
            throw new IneligibleCouponException('Coupon is expired!', $this);
        }

        return $this->coupon->applyOn($totalAmount);
    }
}