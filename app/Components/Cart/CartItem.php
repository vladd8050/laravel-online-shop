<?php

namespace AutoKit\Components\Cart;

use AutoKit\Product;

class CartItem
{
    /**
     * @var Product
     */
    public $product;

    /**
     * @var int
     */
    public $quantity;

    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getAmount(): float
    {
        return round_up($this->product->price * $this->quantity, 2);
    }

    public function allInCart(): bool
    {
        return $this->quantity === $this->product->quantity;
    }
}