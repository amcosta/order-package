<?php

namespace App;

use App\Contracts\IOrderItem;
use App\Contracts\IProduct;
use App\Exceptions\OrderQuantityException;
use JMS\Serializer\Annotation as Serializer;

class OrderItem implements IOrderItem, \Serializable, \JsonSerializable
{
    use Traits\Serializer;

    /**
     * @Serializer\Type("App\Product")
     */
    private IProduct $product;

    /**
     * @Serializer\Type("int")
     */
    private int $quantity;

    public function __construct(IProduct $product, int $quantity = 1)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotal(): float
    {
        return $this->product->getPrice() * $this->quantity;
    }

    public function getName(): string
    {
        return $this->product->getName();
    }

    public function increaseQuantity(): void
    {
        $this->quantity++;
    }

    /**
     * @throws OrderQuantityException
     */
    public function decreaseQuantity(): void
    {
        if ($this->quantity <= 1) {
            throw new OrderQuantityException('It is not possible to have product with zero quantity');
        }

        $this->quantity--;
    }

    public function isEquals(IOrderItem $item): bool
    {
        return $this->getIdentifyCode() === $item->getIdentifyCode();
    }

    public function getIdentifyCode()
    {
        return $this->product->getId();
    }
}