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

        if ($uniqueBooks->count() > 3) {
            return (int) round($uniqueBooks->sum('price') * 0.8);
        } elseif ($uniqueBooks->count() > 2) {
            return (int) round($uniqueBooks->sum('price') * 0.9);
        } elseif ($uniqueBooks->count() > 1) {
            return (int) round($uniqueBooks->sum('price') * 0.95);
        }

        return 100;
    }
}
