<?php


namespace App;


use App\Contracts\IOrderItem;
use App\Contracts\IProduct;

class OrderItem implements IOrderItem
{
    private $product;

    private $quantity;

    public function __construct(IProduct $product)
    {
        $this->product = $product;
        $this->quantity = 1;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getTotal()
    {
        return $this->product->getPrice() * $this->quantity;
    }

    public function getName()
    {
        return $this->product->getName();
    }

    public function increaseQuantity()
    {
        $this->quantity++;
    }

    public function decreaseQuantity()
    {
        $this->quantity--;
    }
}