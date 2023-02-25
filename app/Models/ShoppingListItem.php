<?php

namespace App\Models;

use Illuminate\Support\Str;

class ShoppingListItem
{
    public readonly string $name;
    public readonly string $id;
    public ?bool $isBought;

    public function __construct(
        string $name,
        ?string $id = null,
        ?bool $isBought = false
    )
    {
        $this->name = $name;

        $this->isBought = boolval($isBought);

        if ($id) {
            $this->id = $id;
        } else {
            $this->id = Str::uuid();
        }
    }
}
