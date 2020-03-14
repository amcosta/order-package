<?php

namespace App\Traits;

use JMS\Serializer\SerializerBuilder;

trait Serializer
{
    public function serialize(): string
    {
        return $this->jsonSerialize();
    }

    public function unserialize($serialized): self
    {
        $serializer = SerializerBuilder::create()->build();
        return $serializer->deserialize($serialized, get_class($this), 'json');
    }

    public function jsonSerialize(): string
    {
        $serializer = SerializerBuilder::create()->build();
        return $serializer->serialize($this, 'json');
    }
}
