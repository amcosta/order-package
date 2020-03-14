<?php

namespace App;

use App\Contracts\IProduct;
use InvalidArgumentException;
use JMS\Serializer\Annotation as Serializer;

class Product implements IProduct, \Serializable, \JsonSerializable
{
    use Traits\Serializer;

    /**
     * @Serializer\Type("string")
     */
    private $id;

    /**
     * @Serializer\Type("string")
     */
    private string $name;

    /**
     * @Serializer\Type("float")
     */
    private float $price;

    public function __construct(string $name, float $price, $id = null)
    {
        $this->setName($name);
        $this->setPrice($price);
        $this->id = $id ?? uniqid('_');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    private function setName(string $name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('The name of product must be a string');
        }

        $this->name = $name;
    }

    private function setPrice(float $price)
    {
        if (!is_float($price)) {
            throw new InvalidArgumentException('The price of product must be a float');
        }

        if ($price < 0) {
            throw new InvalidArgumentException('The price can not be below zero');
        }

        $this->price = $price;
    }
}