<?php

namespace Tests;

use App\Order;
use App\OrderItem;
use App\Product;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testCalculateTotal()
    {
        $order = new Order();
        $order->addItem($this->buildItem('Item 1', 10));
        $order->addItem($this->buildItem('Item 2', 10));

        $this->assertEquals(20, $order->getPrice());
        $this->assertCount(2, $order->getItems()->toArray());
    }

    public function testIncreaseAndDecreaseQuantity()
    {
        $itemName = 'Awesome product';
        $itemPrice = 10;

        $item = $this->buildItem($itemName, $itemPrice);
        $order = new Order();

        for ($i = 1; $i <= 5; $i++) {
            $order->addItem($item);
            $this->assertEquals(10 * $i, $order->getPrice());
            $this->assertCount(1, $order->getItems()->toArray());
        }

        for ($i = 5; $i > 1; $i--) {
            $this->assertEquals(10 * $i, $order->getPrice());
            $this->assertCount(1, $order->getItems()->toArray());
            $order->removeItem($item);
        }
    }

    public function testSerializable()
    {
        $item = $this->buildItem('Item 1', 10);
        $order = new Order();
        $order->addItem($item);

        $string = serialize($order);
        $this->assertIsString($string);
        $this->assertInstanceOf(Order::class, unserialize($string));
    }

    private function buildItem($name, $price)
    {
        return new OrderItem(new Product($name, $price));
    }
}