<?php

namespace App;

use App\Contracts\IOrder;
use App\Contracts\IOrderItem;
use App\Exceptions\OrderQuantityException;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

class Order implements IOrder, \Serializable, \JsonSerializable
{
    use Traits\Serializer;

    /**
     * @Serializer\Type("ArrayCollection<App\OrderItem>")
     */
    private ArrayCollection $items;

    public function __construct(array $items = [])
    {
        $this->items = new ArrayCollection($items);
    }

    public function addItem(IOrderItem $item): void
    {
        $key = $this->items->indexOf($item);

        if ($key === false) {
            $this->items->add($item);
        } else {
            $this->items->get($key)->increaseQuantity();
        }
    }

    public function removeItem(IOrderItem $item): void
    {
        $key = $this->items->indexOf($item);
        if ($key === false) {
            return;
        }

        /* @var IOrderItem $item */
        $item = $this->items->get($key);

        try {
            $item->decreaseQuantity();
        } catch (OrderQuantityException $exception) {
            $this->removeAll($item);
        }
    }

    public function removeAll(IOrderItem $item): void
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
        }
    }

    public function removeAllItems()
    {
        $this->items->clear();
    }

    public function getPrice(): float
    {
        $callback = function (float $total, IOrderItem $item) {
            $total += $item->getTotal();
            return $total;
        };

        return array_reduce($this->items->toArray(), $callback, 0);
    }

    public function getItems(): ArrayCollection
    {
        return $this->items;
    }
}