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
        try {
            $item = $this->getItem($item);
            $item->increaseQuantity();
        } catch (\OutOfBoundsException $exception) {
            $this->items->add($item);
        }
    }

    public function removeItem(IOrderItem $reference): void
    {
        try {
            $item = $this->getItem($reference);
        } catch (\OutOfBoundsException $exception) {
            return;
        }

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

    public function getAllItems(): ArrayCollection
    {
        return $this->items;
    }

    public function getItem(IOrderItem $item): IOrderItem
    {
        $callback = function (IOrderItem $collectionItem) use ($item) {
            return $collectionItem->isEquals($item);
        };

        $filteredItems = $this->items->filter($callback);
        if ($filteredItems->count() === 0) {
            throw new \OutOfBoundsException();
        }

        $key = $this->items->indexOf($filteredItems->first());
        return $this->items->get($key);
    }
}
