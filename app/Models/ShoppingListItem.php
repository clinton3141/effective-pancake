<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingListItem extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $table = 'shoppinglistitems';
    protected $primaryKey = 'id';

    protected $connection = 'mysql';

    protected $attributes = [
        'isBought' => false,
    ];

    protected $fillable = ['name', 'isBought'];
}
