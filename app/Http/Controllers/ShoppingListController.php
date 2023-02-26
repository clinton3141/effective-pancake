<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

use App\Models\ShoppingListItem;

class ShoppingListController extends Controller
{
    public function showAll(): View
    {
        $items = ShoppingListItem::orderBy('created_at')->get();

        return view(
            'index',
            ['shoppingList' => $items]
        );
    }

    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        ShoppingListItem::create([
            'name' => $validated['name']
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

    public function update(string $id): RedirectResponse
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
}
