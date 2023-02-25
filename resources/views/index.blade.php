@extends('app')

@section('title', 'Your list')
@section('page_heading', 'Your shopping list')

@section('content')
@if (count($shoppingList) === 0)
    <p>Your shopping list is empty</p>
    @else
    <ul role="list" class="max-w-md marker:text-red-400 pt-5 pb-5 list-disc pl-5 space-y-3">
        @foreach ($shoppingList as $item)
            <li class="mt-0">
                <div class="flex">
                    <div class="flex-auto">
                        {{ $item->name }}
                    </div>
                    <div class="self-end">
                        <form action="/v1/item/{{ $item->id }}" method="POST" onsubmit="javascript:return confirm('Delete &quot;{{ $item->name }}&quot;?')">
                            @method('DELETE')
                            @csrf
                            <input type="submit" value="x" class="bg-red-200 rounded-full pl-2 pr-2 pb-1 cursor-pointer hover:bg-red-400" title="Delete &quot;{{ $item->name }}&quot;" />
                        </form>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @endif
    <p><a class="rounded-lg p-2 bg-blue-200 hover:bg-blue-400 cursor-pointer" href="/item">Add an item</a></p>
@endsection
