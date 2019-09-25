<?php

namespace Training\Tests\Shopping;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Training\Shopping\ComboProduct;
use Training\Shopping\PhysicalProduct;

final class ComboProductTest extends TestCase
{
    public function testComboProductWithPresetRetailPrice(): void
    {
        $combo = new ComboProduct(
            'COMBO',
            [
                new PhysicalProduct('A', Money::EUR(2990)),
                new PhysicalProduct('B', Money::EUR(5950)),
            ],
            Money::EUR(4100)
        );

        $this->assertEquals(Money::EUR(4100), $combo->getRetailPrice());
    }

    public function testComboProductWithoutPresetRetailPrice(): void
    {
        $combo = new ComboProduct('COMBO', [
            new PhysicalProduct('A', Money::EUR(3000)),
            new PhysicalProduct('B', Money::EUR(6000)),
        ]);

        $this->assertEquals(Money::EUR(9000), $combo->getRetailPrice());
    }
}