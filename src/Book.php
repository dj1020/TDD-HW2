<?php
/**
 * Author: twinkledj
 * Date: 10/25/15
 */

namespace HW2;

class Book
{
    /**
     * Book constructor.
     * @param array $array
     */
    public function __construct(array $props)
    {
        $this->id = $props['id'];
        $this->price = $props['price'];
    }
}