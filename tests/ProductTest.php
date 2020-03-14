<?php

namespace Tests;

use App\Contracts\IProduct;
use App\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testThrowExceptionWithInvalidPrice()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Product('name', -10);
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testValidParametersToCreateAProduct($name, $price)
    {
        $product = new Product($name, $price);
        $this->assertEquals($name, $product->getName());
        $this->assertEquals($price, $product->getPrice());
    }

    public function validDataProvider()
    {
        return [
            ['Some name', 0],
            ['Some name', 100],
            ['Some name', 15.69],
        ];
    }

    public function testSerializable()
    {
        $string = serialize(new Product('Super product', 1.99));
        $this->assertIsString($string);
        $this->assertInstanceOf(IProduct::class, unserialize($string));
    }

    public function testProductId()
    {
        $product1 = new Product('Expensive Product', 999.99);
        $this->assertIsString($product1->getId());

        $product2 = new Product('Cheap Product', 5.10, 'SHA256');
        $this->assertEquals('SHA256', $product2->getId());

        $product2 = new Product('Just a Product', 10, 9000);
        $this->assertEquals(9000, $product2->getId());
    }
}