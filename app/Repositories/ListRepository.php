<?php

namespace App\Repositories;

use App\Models\ShoppingListItem;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Arr;

class ListRepository {
    const SESSION_TAG = 'shoppingList';

    function __construct(private Session $session) {}

    public function getAll(): array
    {
        // dd($this->session->get(self::SESSION_TAG));
        return $this->session->get(self::SESSION_TAG) ?? [];
    }

    public function add(ShoppingListItem $item): void
    {
        $shoppingList = $this->getAll();

        array_push($shoppingList, $item);

        $this->save($shoppingList);
    }

    public function has(string $id): bool
    {
        $shoppingList = $this->getAll();

        $item = Arr::first($shoppingList, function(ShoppingListItem $it) use ($id) {
            return $it->id === $id;
        });

        return $item !== null;
    }

    public function remove(string $id): void
    {
        $shoppingList = Arr::where($this->getAll(), function(ShoppingListItem $item) use ($id) {
            return $item->id !== $id;
        });

        $this->save($shoppingList);
    }

    private function save($shoppingList): void
    {
        $this->session->put(self::SESSION_TAG, $shoppingList);
    }
}
