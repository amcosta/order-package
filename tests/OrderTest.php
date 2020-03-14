<?php

namespace Tests;

use App\Contracts\IOrder;
use App\Order;
use App\OrderItem;
use App\Product;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private IOrder $order;

    protected function setUp(): void
    {
        parent::setUp();
        $this->order = new Order();
    }

    public function testGetItem()
    {
        $item1 = $this->buildItem('Item 1', 10, 1);
        $item2 = $this->buildItem('Item 2', 10, 2);
        $item3 = $this->buildItem('Item 3', 10, 3);

        $order = new Order([$item1, $item2, $item3]);

        $i1 = $order->getItem($this->buildItem('Item 1', 10, 1));
        $this->assertEquals('Item 1', $i1->getName());
        $this->assertEquals(10, $i1->getTotal());
    }

    public function testCalculateTotal()
    {
        $order = new Order();
        $order->addItem($this->buildItem('Item 1', 10));
        $order->addItem($this->buildItem('Item 2', 10));

        $this->assertEquals(20, $order->getPrice());
        $this->assertCount(2, $order->getAllItems()->toArray());
    }

    public function testIncreaseAndDecreaseQuantity()
    {
        $itemName = 'Awesome product';
        $itemPrice = 10;

        $order = new Order();
        for ($i = 1; $i <= 5; $i++) {
            $order->addItem($this->buildItem($itemName, $itemPrice, 1));
            $this->assertEquals(10 * $i, $order->getPrice());
            $this->assertCount(1, $order->getAllItems()->toArray());
        }

        $item = $this->buildItem($itemName, $itemPrice, 1);
        for ($i = 5; $i > 1; $i--) {
            $this->assertEquals(10 * $i, $order->getPrice());
            $this->assertCount(1, $order->getAllItems()->toArray());
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

    private function buildItem($name, $price, $id = null)
    {
        return new OrderItem(new Product($name, $price, $id));
    }
}
