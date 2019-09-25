<?php

namespace Training\Tests\Shopping\Coupon;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Training\Shopping\Coupon\CodeGenerator\FixedCouponCodeGenerator;
use Training\Shopping\Coupon\ValueCoupon;
use Training\Shopping\Coupon\ValueCouponFactory;

final class ValueCouponFactoryTest extends TestCase
{
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new ValueCouponFactory(new FixedCouponCodeGenerator('SFLIVEBERLIN2019'));
    }

    public function testCreateValueCouponWithGeneratedCode(): void
    {
        $this->assertEquals(
            new ValueCoupon('SFLIVEBERLIN2019', Money::EUR(1000)),
            $this->factory->createCoupon(['amount' => '1000', 'currency' => 'EUR'])
        );
    }

    public function testCreateValueCouponWithCustomCode(): void
    {
        $this->assertEquals(
            new ValueCoupon('SYMFONYCON2019', Money::EUR(1000)),
            $this->factory->createCoupon(['code' => 'SYMFONYCON2019', 'amount' => '1000', 'currency' => 'EUR'])
        );
    }
}