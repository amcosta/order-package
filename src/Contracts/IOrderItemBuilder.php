<?php

namespace App\Contracts;

interface IOrderItemBuilder
{
    public function withProduct(IProduct $product): self;

    public function withDefault(string $name, float $price): self;

    public function withQuantity(int $quantity): self;

    public function build(): IOrderItem;
}
