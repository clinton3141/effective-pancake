@extends('app')

@section('title', 'Your list')
@section('page_heading', 'Your shopping list')

@section('content')
@if (count($shoppingList) === 0)
    <p class="pt-5 pb-5">Your shopping list is empty</p>
    @else
    <ul role="list" id="shopping-list" class="max-w-md marker:text-red-400 pt-5 pb-5 list-disc pl-5 space-y-3">
        @foreach ($shoppingList as $item)
            <li class="mt-0 cursor-move" data-item-id="{{ $item->id }}">
                <div class="flex">
                    <div
                        class="flex-auto pt-1 {{ $item->isBought ? " text-stone-400 line-through" : ""}}"
                        data-bought="{{ $item->isBought ? 'true' : 'false' }}">
                        {{ $item->name }} (&pound;{{ number_format($item->price, 2) }})
                    </div>
                    @if (!$item->isBought)
                    <div class="self-end">
                        <form action="/v1/item/{{ $item->id }}/bought" method="POST" onsubmit="javascript:return confirm('Mark &quot;{{ $item->name }}&quot; as bought?')">
                            @csrf
                            <input class="bg-green-100 rounded-full pl-2 pr-2 pt-1 pb-1 mr-2 cursor-pointer hover:bg-green-300"
                                value="✅"
                                type="submit"
                                title="Bought &quot;{{ $item->name }}&quot;"
                            />
                        </form>
                    </div>
                    @endif
                    <div class="self-end">
                        <form action="/v1/item/{{ $item->id }}" method="POST" onsubmit="javascript:return confirm('Delete &quot;{{ $item->name }}&quot;?')">
                            @method('DELETE')
                            @csrf
                            <input type="submit" value="❌" class="bg-red-100 rounded-full pl-2 pr-2 pt-1 pb-1 mr-2 cursor-pointer hover:bg-red-300" title="Delete &quot;{{ $item->name }}&quot;" />
                        </form>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <p class="text-right pr-3 mb-5">Total cost: &pound;{{ number_format($totalCost, 2) }}</p>
    @endif

    <div class="flex">
        <p class="flex-auto pt-1"><a class="rounded-lg p-2 bg-blue-200 hover:bg-blue-400" href="/item">Add an item</a></p>

        <!-- TODO: ideally this should be invisible to the user and done with AJAX -->
        <form class="flex-auto" class="m-0" action="/v1/list" method="post">
            @csrf
            @method('patch')
            @foreach ($shoppingList as $item)
            <input type="hidden" class="sort-order" name="order[]" value="{{ $item->id }}" />
            @endforeach
            <input type="submit" value="Save order" id="save-order-button" class="hidden rounded-lg p-1 pl-2 pr-2 bg-blue-200 cursor-pointer hover:bg-blue-400" />
        </form>
    </div>
@endsection
