@extends('app')

@section('title', 'Your list')
@section('page_heading', 'Your shopping list')

@section('content')
@if (count($shoppingList) === 0)
    <p class="pt-5 pb-5">Your shopping list is empty</p>
    @else
    <ul role="list" class="max-w-md marker:text-red-400 pt-5 pb-5 list-disc pl-5 space-y-3">
        @foreach ($shoppingList as $item)
            <li class="mt-0">
                <div class="flex">
                    <div
                        class="flex-auto pt-1 {{ $item->isBought ? " text-stone-400 line-through" : ""}}"
                        data-bought="{{ $item->isBought ? 'true' : 'false' }}">
                        {{ $item->name }}
                    </div>
                    @if (!$item->isBought)
                    <div class="self-end">
                        <form action="/v1/item/{{ $item->id }}" method="POST" onsubmit="javascript:return confirm('Have you bought &quot;{{ $item->name }}&quot;?')">
                            @method('PATCH')
                            @csrf
                            <input type="hidden" name="bought" value="true" />
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
    @endif
    <p><a class="rounded-lg p-2 bg-blue-200 hover:bg-blue-400 cursor-pointer" href="/item">Add an item</a></p>
@endsection
