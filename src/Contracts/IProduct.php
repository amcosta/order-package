<?php


namespace App\Contracts;


interface IProduct
{
    public function getName(): string;

    public function getPrice(): float;

    public function getId();
}