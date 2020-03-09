<?php

namespace Tests;

use App\Contracts\IOrderItem;
use App\Exceptions\OrderQuantityException;
use App\OrderItem;
use App\Product;
use PHPUnit\Framework\TestCase;

class OrderItemTest extends TestCase
{
    /**
     * @var OrderItem
     */
    private OrderItem $item;

    protected function setUp(): void
    {
        $this->item = new OrderItem(new Product('', 10));
    }

    public function testIncreaseAndDecreaseQuantity()
    {
        $this->assertEquals(1, $this->item->getQuantity());

        for ($i = 2; $i <= 10; $i++) {
            $this->item->increaseQuantity();
            $this->assertEquals($i, $this->item->getQuantity());
        }

        for ($i = 9; $i > 1; $i--) {
            $this->item->decreaseQuantity();
            $this->assertEquals($i, $this->item->getQuantity());
        }
    }

    public function testExceptionForZeroQuantity()
    {
        $this->expectException(OrderQuantityException::class);
        $this->item->decreaseQuantity();
    }

    public function testCalculateTotal()
    {
        for ($i = 2; $i <= 10; $i++) {
            $this->item->increaseQuantity();
            $this->assertEquals(10 * $i, $this->item->getTotal());
        }

        for ($i = 9; $i > 1; $i--) {
            $this->item->decreaseQuantity();
            $this->assertEquals(10 * $i, $this->item->getTotal());
        }
    }

    public function testSerializable()
    {
        $string = serialize($this->item);
        $this->assertIsString($string);
        $this->assertInstanceOf(IOrderItem::class, unserialize($string));
    }
}