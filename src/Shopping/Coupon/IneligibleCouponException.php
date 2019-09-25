<?php

namespace Training\Shopping\Coupon;

class IneligibleCouponException extends \RuntimeException
{
    private $coupon;

    public function __construct(string $message, Coupon $coupon, \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);

        $this->coupon = $coupon;
    }

    public function getCoupon(): Coupon
    {
        return $this->coupon;
    }
}