<?php

namespace App\Repositories;

use App\Models\ShoppingListItem;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Arr;

class ListRepository {
    // TODO: the mechanism for bought items is a bit ropey. Basically building
    // a session based db here and it's spiralling. The next story is about
    // persistence so will accept this for now and then fix properly with a
    // db as part of that story.
    const SESSION_TAG = 'shoppingList';
    const BOUGHT_SESSION_TAG = 'shoppingListBought';

    function __construct(private Session $session) {}

    public function getAll(): array
    {
        $items = $this->session->get(self::SESSION_TAG) ?? [];
        $bought = $this->session->get(self::BOUGHT_SESSION_TAG) ?? [];

        array_map(function(ShoppingListItem $item) use ($bought) {
            $item->isBought = isset($bought[$item->id]) && boolval($bought[$item->id]);
        }, $items);

        return $items;
    }

    public function getItem(string $id): ?ShoppingListItem
    {
        return Arr::first($this->getAll(), function(ShoppingListItem $item) use ($id) {
            return $item->id === $id;
        });
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

    public function buy(string $id): void {
        if ($this->has($id)) {
            $bought = $this->session->get(self::BOUGHT_SESSION_TAG) ?? [];
            $bought[$id] = true;
            $this->session->put(self::BOUGHT_SESSION_TAG, $bought);
        }
    }

    private function save($shoppingList): void
    {
        $this->session->put(self::SESSION_TAG, $shoppingList);
    }
}
