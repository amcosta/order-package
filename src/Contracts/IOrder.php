<?php


namespace App\Contracts;


use Doctrine\Common\Collections\ArrayCollection;

interface IOrder
{
    public function getItems();

    public function addItem(IOrderItem $item);

    public function removeItem(IOrderItem $item);

    public function getPrice();
}