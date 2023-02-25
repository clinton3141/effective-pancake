@extends('app')

@section('title', 'Your list')
@section('page_heading', 'Your shopping list')

@section('content')
@if (count($shoppingList) === 0)
    <p>Your shopping list is empty</p>
    @else
    <ul role="list" class="max-w-md marker:text-red-400 list-disc pl-5 space-y-3">
        @foreach ($shoppingList as $item)
            <li>{{ $item->name }}</li>
        @endforeach
    </ul>
    @endif
    <p><a href="/item">Add an item</a></p>
@endsection
