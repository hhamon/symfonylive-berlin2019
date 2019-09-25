<?php

namespace Training\Shopping\Coupon\Constraint;

use Money\Money;
use Training\Shopping\Coupon\Coupon;
use Training\Shopping\Coupon\IneligibleCouponException;

final class MinimumPurchaseAmountCouponConstraint extends CouponConstraint
{
    private $minimumAmount;

    public function __construct(Coupon $coupon, Money $minimumAmount)
    {
        parent::__construct($coupon);

        $this->minimumAmount = $minimumAmount;
    }

    public function applyOn(Money $totalAmount): Money
    {
        if ($totalAmount->lessThan($this->minimumAmount)) {
            throw new IneligibleCouponException('Minimum amount required!', $this->coupon);
        }

        return $this->coupon->applyOn($totalAmount);
    }
}