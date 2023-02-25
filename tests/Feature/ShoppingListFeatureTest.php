<?php

namespace Tests\Feature;

use App\Models\ShoppingListItem;
use App\Repositories\ListRepository;
use Tests\TestCase;

// TODO: these test is coupled to implementation detail
// using withSession. Please fix me.
class ShoppingListFeatureTest extends TestCase
{
    public function test_shopping_list_is_empty_message(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Your shopping list is empty');
    }

    public function test_shopping_list_items_are_shown(): void
    {
        $this->withSession([
            ListRepository::SESSION_TAG => [
                new ShoppingListItem('Tomatos'),
                new ShoppingListItem('Bread')
            ]
        ]);

        $this->get('/')
            ->assertStatus(200)
            ->assertSeeInOrder(['Tomatos', 'Bread']);
    }

    public function test_shopping_list_items_are_added(): void
    {
        $this->withSession([
            ListRepository::SESSION_TAG => [
                new ShoppingListItem('Flour')
            ]
        ]);

        $this->followingRedirects();

        $this->post('/v1/item', ['name' => 'Sugar'])
            ->assertSeeInOrder(['Flour', 'Sugar']);
    }

    public function test_shopping_list_items_are_deleted(): void
    {
        $eggs = new ShoppingListItem('Eggs');
        $this->withSession([
            ListRepository::SESSION_TAG => [
                $eggs
            ]
        ]);

        $this->followingRedirects();

        $this->delete('/v1/item/' . $eggs->id)
            ->assertDontSee(['Eggs']);
    }

    public function test_shopping_list_items_are_marked_as_bought(): void
    {
        $apples = new ShoppingListItem('Granny Smith Apples');
        $this->withSession([
            ListRepository::SESSION_TAG => [
                $apples
            ]
        ]);

        $this->followingRedirects();

        $this->patch('/v1/item/' . $apples->id)
            ->assertSee(['Granny Smith Apples'])
            ->assertSee('data-bought="true"', escape: false);
    }
}
