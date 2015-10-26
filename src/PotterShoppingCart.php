<?php

namespace HW2;

use Illuminate\Support\Collection;

class PotterShoppingCart
{
    private $books;

    public function __construct() {
        $this->books = new Collection();
    }

    public function add( Book $book ) {
        $this->books->push( $book );
    }

    public function checkout() {
        return $this->getBestDiscountPriceIn( $this->books );
    }

    private function getBestDiscountPriceIn( Collection $books ) {
        if ($books->count() == 0) {
            return 0;
        }

        $discountBooks = new Collection();
        $restBooks = new Collection();
        while ( $book = $books->shift() ) {
            if ( $this->isUniqueBook( $book, $discountBooks ) ) {
                $discountBooks->push( $book );
            } else {
                $restBooks->push( $book );
            }
        }

        $discountRate = $this->getDiscountRate( $discountBooks->count() );
        $carrySum = (int)round( $discountBooks->sum( 'price' ) * $discountRate );

        return $carrySum + $this->getBestDiscountPriceIn($restBooks);
    }

    private function getDiscountRate( $count ) {
        $discountRate = [
            1 => 1,
            2 => 0.95,
            3 => 0.9,
            4 => 0.8,
            5 => 0.75,
        ];

        return $discountRate[$count];
    }

    private function isUniqueBook( $book, Collection $discountBooks ) {
        return ! $discountBooks->pluck( 'id' )->contains( $book->id );
    }
}
