<?php


namespace App;


use App\Contracts\IOrder;
use App\Contracts\IOrderItem;
use Doctrine\Common\Collections\ArrayCollection;

class Order implements IOrder, \Serializable
{
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function addItem(IOrderItem $item)
    {
        $key = $this->items->indexOf($item);

        if ($key === false) {
            $this->items->add($item);
        } else {
            $this->items->get($key)->increaseQuantity();
        }
    }

    public function removeItem(IOrderItem $item)
    {
        $this->items->removeElement($item);
    }

    public function getPrice()
    {
        $callback = function ($total, IOrderItem $item) {
            $total += $item->getTotal();
            return $total;
        };

        return array_reduce($this->items->toArray(), $callback, 0);
    }

    public function getItems()
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }
}