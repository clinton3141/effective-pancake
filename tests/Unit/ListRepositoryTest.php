<?php

use App\Models\ShoppingListItem;
use App\Repositories\ListRepository;
use Tests\TestCase;

class ListRepositoryTest extends TestCase
{
    public function test_should_return_empty_array_if_list_is_empty()
    {
        $repo = app(ListRepository::class);

        $list = $repo->getAll();

        $this->assertThat($list, $this->equalTo([]));
    }

    public function test_should_return_items_in_the_list()
    {
        $repo = app(ListRepository::class);

        $item = new ShoppingListItem('Pasta');

        $this->withSession([
            ListRepository::SESSION_TAG => [$item]
        ]);

        $this->assertThat(
            $repo->getAll(),
            $this->equalTo([$item])
        );
    }

    public function test_should_add_items_to_list()
    {
        $repo = app(ListRepository::class);

        $cheese = new ShoppingListItem('Cheese');
        $butter = new ShoppingListItem('Butter');
        $ham = new ShoppingListItem('Ham');

        $this->withSession([
            ListRepository::SESSION_TAG => [$cheese, $butter]]
        );

        $repo->add($ham);

        $this->assertThat(
            $repo->getAll(),
            $this->equalTo([$cheese, $butter, $ham])
        );
    }
}
