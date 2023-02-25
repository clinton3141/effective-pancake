<?php

namespace Tests\Unit;

use App\Repositories\ListRepository;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class ShoppingListControllerTest extends TestCase
{
    public function test_controller_returns_populated_shopping_list(): void
    {
        $this->instance(
            ListRepository::class,
            Mockery::mock(ListRepository::class, function (MockInterface $mock) {
                $mock->shouldReceive('getAll')->once()->andReturn(['Cherries']);
            })
        );

        $this->call('GET', '/')
            ->assertViewHas('shoppingList', ['Cherries']);
    }
}
