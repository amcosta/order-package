<?php

namespace App\Contracts;

use App\Exceptions\OrderQuantityException;

interface IOrderItem
{
    public function getQuantity(): int;

    public function getTotal(): float;

    public function getName(): string;

    public function increaseQuantity(): void;

    /**
     * @throws OrderQuantityException
     */
    public function decreaseQuantity(): void;

    public function getIdentifyCode();

    public function isEquals(IOrderItem $item): bool;
}
