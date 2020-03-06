<?php


namespace App\Contracts;


interface IOrderItem
{
    public function getQuantity();

    public function getTotal();

    public function getName();

    public function increaseQuantity();

    public function decreaseQuantity();
}