<?php

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

        $this->withSession([ListRepository::SESSION_TAG => ['Pasta']]);

        $this->assertThat($repo->getAll(), $this->equalTo(['Pasta']));
    }

    public function test_should_add_items_to_list()
    {
        $repo = app(ListRepository::class);

        $this->withSession([ListRepository::SESSION_TAG => ['Cheese', 'Butter']]);

        $repo->add('Ham');

        $this->assertThat($repo->getAll(), $this->equalTo(['Cheese', 'Butter', 'Ham']));
    }
}
