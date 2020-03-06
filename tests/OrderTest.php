<?php


namespace Tests;


use App\Contracts\IOrderItem;
use App\Contracts\IProduct;
use App\Order;
use App\OrderItem;
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

    public function testIncreaseDecreaseQuantity()
    {
        $item = $this->buildItem('Item 1', 10);
        $order = new Order();
        $order->addItem($item);

        $this->assertEquals(10, $order->getPrice());
        $this->assertCount(1, $order->getItems()->toArray());

        $order->addItem($item);
        $this->assertEquals(20, $order->getPrice());
        $this->assertCount(1, $order->getItems()->toArray());

        $order->addItem($item);
        $this->assertEquals(20, $order->getPrice());
        $this->assertCount(1, $order->getItems()->toArray());
    }

    private function buildItem($name, $price)
    {
        return new OrderItem($this->buildProduct($name, $price));
    }

    private function buildProduct($name, $price)
    {
        $mock = $this->createMock(IProduct::class);
        $mock->method('getName')->willReturn($name);
        $mock->method('getPrice')->willReturn($price);
        return $mock;
    }
}