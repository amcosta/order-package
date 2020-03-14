<?php

namespace App\Contracts;

use Doctrine\Common\Collections\ArrayCollection;

interface IOrder
{
    public function getAllItems(): ArrayCollection;

    public function addItem(IOrderItem $item): void;

    public function removeItem(IOrderItem $item): void;

    public function getPrice(): float;
}
