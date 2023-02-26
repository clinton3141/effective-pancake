@extends('app')

@section('title', 'Add item')
@section('page_heading', 'Add an item')

@section('content')

<form method="POST" action="/v1/item" class="pt-5">
    @csrf
    <div class="pt-2 pb-2">
        <label for="name">Product name:</label>
        <input type="text" minlength="1" maxlength="255" class="rounded-lg bg-slate-100 p-1" name="name" placeholder="e.g. Broccoli" required />
    </div>
    <div class="pt-2 pb-2">
        <label for="name">Product price: &pound;</label>
        <input type="number" min="0" max="99999.99" step="0.01" class="rounded-lg bg-slate-100 p-1" name="price" placeholder="e.g. 9.99" required />
    </div>
    <div class="actions pt-3">
        <a href="/" class="rounded-lg p-2 bg-red-200 hover:bg-red-400 cursor-pointer">Cancel</a>
        <input type="submit" class="rounded-lg p-1 pl-2 pr-2 bg-blue-200 cursor-pointer hover:bg-blue-400" value="Add it" />
    </div>
</form>

@endsection
