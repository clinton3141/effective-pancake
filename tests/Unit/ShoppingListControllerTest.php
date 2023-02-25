<?php

namespace Tests\Unit;

use App\Models\ShoppingListItem;
use App\Repositories\ListRepository;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class ShoppingListControllerTest extends TestCase
{
    public function test_controller_returns_populated_shopping_list(): void
    {
        $list = [new ShoppingListItem('Cherries')];
        $this->instance(
            ListRepository::class,
            Mockery::mock(ListRepository::class, function (MockInterface $mock) use ($list) {
                $mock->shouldReceive('getAll')->once()->andReturn($list);
            })
        );

        $this->call('GET', '/')
            ->assertViewHas('shoppingList', $list);
    }

    public function test_controller_adds_item_to_shopping_list(): void
    {
        $this->instance(
            ListRepository::class,
            Mockery::mock(ListRepository::class, function (MockInterface $mock) {
                $mock->shouldReceive('add')->once('Sugar');
                $mock->shouldReceive('getAll')->andReturns(
                    [new ShoppingListItem('Sugar')]
                );
            })
        );

        $this->followingRedirects();

        $this->call('POST', '/v1/item', ['name' => 'Sugar'])
            ->assertSee(['Sugar']);
    }
}
