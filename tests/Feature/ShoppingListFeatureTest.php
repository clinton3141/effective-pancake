<?php

namespace Tests\Feature;

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
        $this->withSession(
            [ListRepository::SESSION_TAG => ['Tomatos', 'Bread']]
        );

        $this->get('/')
            ->assertStatus(200)
            ->assertSeeInOrder(['Tomatos', 'Bread']);
    }
}
