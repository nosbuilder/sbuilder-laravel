<?php

declare(strict_types=1);

namespace App\Entities;

class BasketGoodEntity
{
    private array $attributes;

    private array $fields;

    public function __construct(
        array $data
    )
    {
        $this->attributes = data_get($data, 'attributes', []);
        $this->fields     = data_get($data, 'fields', []);
    }

    public static function make(array $data) : BasketGoodEntity
    {
        return new BasketGoodEntity($data);
    }

    public function getAttributes() : array
    {
        return $this->attributes;
    }

    public function getFields() : array
    {
        return $this->fields;
    }

    public function getAttribute(string $key) : mixed
    {
        return data_get($this->getAttributes(), $key);
    }

    public function getField(string $key) : mixed
    {
        return data_get($this->getFields(), $key);
    }

    public function getTotal(string $priceField = 'p_price1') : float
    {
        return $this->getPrice($priceField) * $this->getQuantity();
    }

    public function getPrice(string $priceField = 'p_price1') : float
    {
        return (float) $this->getField($priceField);
    }

    public function getQuantity() : int
    {
        return (int) $this->getField('p_count');
    }
}
