<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\ShoppingListItem;

class ShoppingListFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_shopping_list_is_empty_message(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Your shopping list is empty');
    }

    public function test_shopping_list_items_are_shown(): void
    {
        ShoppingListItem::create(['name' => 'Tomatos']);
        ShoppingListItem::create(['name' => 'Bread']);

        $this->get('/')
            ->assertStatus(200)
            ->assertSeeInOrder(['Tomatos', 'Bread']);
    }

    public function test_shopping_list_items_are_added(): void
    {
        ShoppingListItem::create(['name' => 'Flour', 'price' => '1.95']);

        $this->followingRedirects();

        $this->post('/v1/item', ['name' => 'Sugar', 'price' => '0.95'])
            ->assertSeeInOrder(['Flour (&pound;1.95)', 'Sugar (&pound;0.95)'], escape: false);
    }

    public function test_shopping_list_total_cost_is_shown(): void
    {
        ShoppingListItem::create(['name' => 'Rice', 'price' => 0.99]);
        ShoppingListItem::create(['name' => 'Pasta', 'price' => 1.19]);

        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Total cost: &pound;2.18', escape: false);
    }

    public function test_shopping_list_items_are_deleted(): void
    {
        $eggs = ShoppingListItem::create(['name' => 'Eggs']);

        $this->followingRedirects();

        $this->delete('/v1/item/' . $eggs->id)
            ->assertDontSee(['Eggs']);
    }

    public function test_shopping_list_items_are_marked_as_bought(): void
    {
        $apples = ShoppingListItem::create(['name' => 'Granny Smith Apples']);

        $this->followingRedirects();

        $this->patch('/v1/item/' . $apples->id)
            ->assertSee(['Granny Smith Apples'])
            ->assertSee('data-bought="true"', escape: false);
    }

    public function test_shopping_list_items_reordered(): void
    {
        $milk = ShoppingListItem::create(['name' => 'Milk', 'order' => 0]);
        $water = ShoppingListItem::create(['name' => 'Water', 'order' => 0]);

        $this->followingRedirects();

        $this->patch('/v1/list/', ['order' => [ $water->id, $milk->id ]])
            ->assertSeeInOrder(['Water', 'Milk']);
    }
}
