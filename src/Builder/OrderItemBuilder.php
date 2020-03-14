<?php

namespace App\Builder;

use App\Contracts\IOrderItem;
use App\Contracts\IOrderItemBuilder;
use App\Contracts\IProduct;
use App\OrderItem;
use App\Product;

class OrderItemBuilder implements IOrderItemBuilder
{
    private IProduct $product;

    private string $productName;

    private float $productPrice;

    private int $quantity = 1;

    private $id = null;

    public function withProduct(IProduct $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function withDefault(string $name, float $price): self
    {
        $this->productName = $name;
        $this->productPrice = $price;
        return $this;
    }

    public function withQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function withIdentifyCode($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function build(): IOrderItem
    {
        $product = $this->product ?? new Product($this->productName, $this->productPrice, $this->id);
        return new OrderItem($product, $this->quantity);
    }
}