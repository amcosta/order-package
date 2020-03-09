<?php


namespace Tests\Builder;


use App\Builder\OrderItemBuilder;
use App\Contracts\IOrderItem;
use App\Product;
use PHPUnit\Framework\TestCase;

class OrderItemBuilderTest extends TestCase
{
    public function testBuildWithProduct()
    {
        $productName = 'Awesome product';
        $productPrice = 150.98;

        $product = new Product($productName, $productPrice);
        $item = (new OrderItemBuilder())->withProduct($product)->build();

        $this->assertInstanceOf(IOrderItem::class, $item);
        $this->assertEquals(1, $item->getQuantity());
        $this->assertEquals($productName, $item->getName());
        $this->assertEquals($productPrice, $item->getTotal());
    }

    public function testBuildWithDefault()
    {
        $productName = 'Supreme product';
        $productPrice = 399;

        $item = (new OrderItemBuilder())->withDefault($productName, $productPrice)->build();

        $this->assertEquals($productName, $item->getName());
        $this->assertEquals($productPrice, $item->getTotal());
        $this->assertEquals(1, $item->getQuantity());
    }

    public function testBuildWithQuantity()
    {
        $productName = 'Fantastic product';
        $productPrice = 100;
        $productQuantity = 3;

        $item = (new OrderItemBuilder())->withDefault($productName, $productPrice)->withQuantity($productQuantity)->build();

        $this->assertEquals($productName, $item->getName());
        $this->assertEquals($productPrice * $productQuantity, $item->getTotal());
        $this->assertEquals($productQuantity, $item->getQuantity());
    }
}