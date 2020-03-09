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
}