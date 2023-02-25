<?php

namespace App\Models;

use Illuminate\Support\Str;

class ShoppingListItem
{
    public readonly string $name;
    public readonly string $id;

    public function __construct(string $name, ?string $id = null)
    {
        $this->name = $name;

        if ($id) {
            $this->id = $id;
        } else {
            $this->id = Str::uuid();
        }
    }
}
