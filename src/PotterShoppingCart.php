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
        list($discount, $restBooks) = $this->getDiscount( $this->books );

        return $discount + $restBooks->sum( 'price' );
    }

    private function getDiscount( $books ) {
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

        return [
            (int)round( $discountBooks->sum( 'price' ) * $discountRate ),
            $restBooks
        ];
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

    /**
     * @param $book
     * @param $discountBooks
     * @return bool
     */
    private function isUniqueBook( $book, $discountBooks ) {
        return ! $discountBooks->pluck( 'id' )->contains( $book->id );
    }
}
