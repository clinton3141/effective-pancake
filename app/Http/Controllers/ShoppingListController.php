<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use App\Repositories\ListRepository;

class ShoppingListController extends Controller
{
    public function showAll(ListRepository $listRepository): View
    {
        $shoppingList = $listRepository->getAll();

        return view('index', ['shoppingList' => $shoppingList]);
    }
}
