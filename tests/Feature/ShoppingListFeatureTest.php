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
        ShoppingListItem::create(['name' => 'Flour']);

        $this->followingRedirects();

        $this->post('/v1/item', ['name' => 'Sugar'])
            ->assertSeeInOrder(['Flour', 'Sugar']);
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
}
