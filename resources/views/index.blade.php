@extends('app')

@section('title', 'Your list')

@section('content')
@if (count($shoppingList) === 0)
    <p>Your shopping list is empty</p>
    @else
    <ul role="list" class="max-w-md marker:text-red-400 list-disc pl-5 space-y-3">
        @foreach ($shoppingList as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>
@endif
@endsection
