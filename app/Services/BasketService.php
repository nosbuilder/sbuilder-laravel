<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\BasketGoodEntity;
use App\Models\SBuilder\Cart;
use DOMElement;
use Symfony\Component\DomCrawler\Crawler;

class BasketService
{
    private array $basket;

    public function __construct(
        private readonly Cart $cart
    )
    {
        $this->parseOrder();
    }

    public static function make(Cart $cart) : BasketService
    {
        return new static($cart);
    }

    /**
     * @return array
     */
    public function getBasket() : array
    {
        return $this->basket;
    }

    public function get(string $key, mixed $default = null) : mixed
    {
        return data_get($this->getBasket(), $key, $default);
    }

    /**
     * @return array<int, array>
     */
    public function getGoods() : array
    {
        return array_map(
            callback: static fn(array $good) : BasketGoodEntity => BasketGoodEntity::make($good),
            array: $this->get('goods', []),
        );
    }

    public function getCategories() : array
    {
        return $this->get('categories', []);
    }

    public function getTotal(string $priceField = 'p_price1') : float
    {
        return array_sum(
            array: array_map(
                callback: static fn(BasketGoodEntity $basketGoodEntity) : float => $basketGoodEntity->getTotal(),
                array: $this->getGoods(),
            )
        );
    }

    public function getQuantity() : int
    {
        return array_sum(
            array: array_map(
                callback: static fn(BasketGoodEntity $basketGoodEntity) : int => $basketGoodEntity->getQuantity(),
                array: $this->getGoods(),
            )
        );
    }

    private function parseOrder() : void
    {
        $array = [];

        $crawler = new Crawler($this->cart->getOrder());

        /* @var \DOMElement $good */
        foreach ($crawler->filter('good') as $i => $good) {
            $good->normalize();

            $array['goods'][$i] = [];
            /* @var \DOMAttr $attribute */
            foreach ($good->attributes as $attribute) {
                $value = trim($attribute->nodeValue);

                $array['goods'][$i]['attributes'][$attribute->nodeName] = $value !== '' ? $value : null;
            }

            foreach ($good->childNodes as $field) {
                if($field instanceof DOMElement === false) {
                    continue;
                }

                $value = trim($field->nodeValue);

                $array['goods'][$i]['fields'][$field->nodeName] = $value !== '' ? $value : null;
            }
        }

        /* @var DOMElement $cat */
        foreach ($crawler->filter('cat') as $i => $cat) {
            foreach ($cat->childNodes as $field) {
                if($field instanceof DOMElement === false) {
                    continue;
                }
                $value = trim($field->nodeValue);

                $array['categories'][$i][$field->nodeName] = $value !== '' ? $value : null;
            }
        }

        $this->basket = $array;
    }
}
