<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ShoppingListItem;

class ShoppingListController extends Controller
{
    public function showAll(): View
    {
        $items = ShoppingListItem::orderBy('order')->get();

        $totalCost = $items->reduce(function(float $total, ShoppingListItem $item) {
            return $total + $item->price;
        }, 0);

        return view(
            'index',
            [
                'shoppingList' => $items,
                'totalCost' => $totalCost,
            ]
        );
    }

    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|min:0|max:99999.99|regex:/^[0-9]{0,5}(?:\.[0-9]{0,2})$/'
        ]);

        // possible race condition here. need a locking mechanism in the future
        $order = ShoppingListItem::max('order');
        ShoppingListItem::create([
            'name' => $validated['name'],
            'order' => $order + 1,
            'price' => $validated['price']
        ]);

        return redirect('/');
    }

    public function delete(string $id): RedirectResponse
    {
        $item = ShoppingListItem::find($id);
        // if (!$item) {
            // TODO: 404 if not found
        // }

        if ($item)
        {
            $item->delete();
        }

        return redirect('/');
    }

    public function bought(string $id): RedirectResponse
    {
        $item = ShoppingListItem::find($id);
        // if (!$item) {
            // TODO: 404 if not found
        // }

        if ($item)
        {
            $item->isBought = true;
            $item->save();
        }

        return redirect('/');
    }

    public function sort(Request $request): RedirectResponse
    {
        // This validates that all items are accounted for.
        // There is probably a more efficient way of doing this
        // when more familiar with Laravel.
        $count = ShoppingListItem::count();
        $validated = $request->validate([
            'order' => 'required|array|min:' . $count,
            'order.*' => 'required|uuid|distinct|exists:shoppinglistitems,id'
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['order'] as $order => $id) {
                ShoppingListItem::where('id', $id)
                    ->update(['order' => $order]);
            }
        });

        return redirect('/');
    }
}
