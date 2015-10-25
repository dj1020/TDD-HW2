<?php

namespace spec\HW2;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \HW2\Book;

class PotterShoppingCartSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('HW2\PotterShoppingCart');
    }

    // User Story
    // 哈利波特一到五冊熱潮正席捲全球，世界各地的孩子都為之瘋狂。
    // 出版社為了慶祝TDD課程招生順利，決定訂出極大的優惠，來回饋給為了小孩四處奔波買書的父母親們。
    // 定價的方式如下：
    // 1. 一到五集的哈利波特，每一本都是賣100元
    // 2. 如果你從這個系列買了兩本不同的書，則會有5%的折扣
    // 3. 如果你買了三本不同的書，則會有10%的折扣
    // 4. 如果是四本不同的書，則會有20%的折扣
    // 5. 如果你一次買了整套一到五集，恭喜你將享有25%的折扣
    // 6. 需要留意的是，如果你買了四本書，其中三本不同，第四本則是重複的，
    //    那麼那三本將享有10%的折扣，但重複的那一本，則仍須100元。
    //  你的任務是，設計一個哈利波特的購物車，能提供最便宜的價格給這些爸爸媽媽。

    // Feature: PotterShoppingCart
    //     In order to 提供最便宜的價格給來買書的爸爸媽媽
    //     As a 佛心的出版社老闆
    //     I want to 設計一個哈利波特的購物車

    // Scenario: 第一集買了一本，其他都沒買，價格應為100*1=100元
    //     Given 第一集買了 1 本
    //     And 第二集買了 0 本
    //     And 第三集買了 0 本
    //     And 第四集買了 0 本
    //     And 第五集買了 0 本
    //     When 結帳
    //     Then 價格應為 100 元
    public function it_should_return_100_when_buy_1_book_one()
    {
        $this->add(new Book(['id' => 1, 'price' => 100]));

        $this->checkout()->shouldReturn(100);
    }

    // Scenario: 第一集買了一本，第二集也買了一本，價格應為100*2*0.95=190
    //     Given 第一集買了 1 本
    //     And 第二集買了 1 本
    //     And 第三集買了 0 本
    //     And 第四集買了 0 本
    //     And 第五集買了 0 本
    //     When 結帳
    //     Then 價格應為 190 元
    public function it_should_return_190_when_buy_1_book_one_and_1_book_two()
    {
        $this->add(new Book(['id' => 1, 'price' => 100]));
        $this->add(new Book(['id' => 2, 'price' => 100]));

        $this->checkout()->shouldReturn(190);
    }

    // Scenario: 一二三集各買了一本，價格應為100*3*0.9=270
    //     Given 第一集買了 1 本
    //     And 第二集買了 1 本
    //     And 第三集買了 1 本
    //     And 第四集買了 0 本
    //     And 第五集買了 0 本
    //     When 結帳
    //     Then 價格應為 270 元
    public function it_should_return_270_when_buy_one_for_each_book_one_two_three()
    {
        $this->add(new Book(['id' => 1, 'price' => 100]));
        $this->add(new Book(['id' => 2, 'price' => 100]));
        $this->add(new Book(['id' => 3, 'price' => 100]));

        $this->checkout()->shouldReturn(270);
    }

    // Scenario: 一二三四集各買了一本，價格應為100*4*0.8=320
    //     Given 第一集買了 1 本
    //     And 第二集買了 1 本
    //     And 第三集買了 1 本
    //     And 第四集買了 1 本
    //     And 第五集買了 0 本
    //     When 結帳
    //     Then 價格應為 320 元
    public function it_should_return_320_when_buy_one_for_each_book_one_two_three_four()
    {
        $this->add(new Book(['id' => 1, 'price' => 100]));
        $this->add(new Book(['id' => 2, 'price' => 100]));
        $this->add(new Book(['id' => 3, 'price' => 100]));
        $this->add(new Book(['id' => 4, 'price' => 100]));

        $this->checkout()->shouldReturn(320);
    }

    // Scenario: 一次買了整套，一二三四五集各買了一本，價格應為100*5*0.75=375
    //     Given 第一集買了 1 本
    //     And 第二集買了 1 本
    //     And 第三集買了 1 本
    //     And 第四集買了 1 本
    //     And 第五集買了 1 本
    //     When 結帳
    //     Then 價格應為 375 元
    public function it_should_return_375_when_buy_one_for_each_book_from_one_to_five()
    {
        $this->add(new Book(['id' => 1, 'price' => 100]));
        $this->add(new Book(['id' => 2, 'price' => 100]));
        $this->add(new Book(['id' => 3, 'price' => 100]));
        $this->add(new Book(['id' => 4, 'price' => 100]));
        $this->add(new Book(['id' => 5, 'price' => 100]));

        $this->checkout()->shouldReturn(375);
    }

    // Scenario: 一二集各買了一本，第三集買了兩本，價格應為100*3*0.9 + 100 = 370
    //     Given 第一集買了 1 本
    //     And 第二集買了 1 本
    //     And 第三集買了 2 本
    //     And 第四集買了 0 本
    //     And 第五集買了 0 本
    //     When 結帳
    //     Then 價格應為 370 元
    public function it_should_return_370_when_buy_1_book_one_and_1_book_two_and_2_book_three()
    {
        $this->add(new Book(['id' => 1, 'price' => 100]));
        $this->add(new Book(['id' => 2, 'price' => 100]));
        $this->add(new Book(['id' => 3, 'price' => 100]));
        $this->add(new Book(['id' => 3, 'price' => 100]));

        $this->checkout()->shouldReturn(370);
    }

    // Scenario: 第一集買了一本，第二三集各買了兩本，價格應為100*3*0.9 + 100*2*0.95 = 460
    //     Given 第一集買了 1 本
    //     And 第二集買了 2 本
    //     And 第三集買了 2 本
    //     And 第四集買了 0 本
    //     And 第五集買了 0 本
    //     When 結帳
    //     Then 價格應為 460 元

}
