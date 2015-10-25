<?php

namespace HW2;

use Illuminate\Support\Collection;

class PotterShoppingCart
{
    private $books;

    public function __construct()
    {
        $this->books = new Collection();
    }

    public function add(Book $books)
    {
        $this->books[] = $books;
    }

    public function checkout()
    {
        $uniqueBooks = $this->books->unique('id');

        $discountRate = $this->getDiscountRate( $uniqueBooks->count() );

        return (int) round($uniqueBooks->sum('price') * $discountRate);
    }

    private function getDiscountRate( $count )
    {
        $discountRate = [
            1 => 1,
            2 => 0.95,
            3 => 0.9,
            4 => 0.8,
            5 => 0.75,
        ];

        return $discountRate[$count];
    }
}
