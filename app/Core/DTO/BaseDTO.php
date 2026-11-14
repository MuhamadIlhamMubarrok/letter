<?php

namespace App\Core\DTO;

abstract class BaseDTO
{
    /**
     * Convert DTO to array.
     */
    public function toArray(): array
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        $result = [];

        foreach ($properties as $property) {
            $name = $property->getName();
            $result[$name] = $this->{$name};
        }

        return $result;
    }

    /**
     * Filter out null values.
     */
    public function toFilteredArray(): array
    {
        return array_filter($this->toArray(), fn ($value) => $value !== null);
    }
}
