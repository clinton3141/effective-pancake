@extends('app')

@section('title', 'Add item')
@section('page_heading', 'Add an item')

@section('content')

<form method="POST" action="/v1/item" class="pt-5">
    @csrf
    <label for="name">Product name:</label>
    <input type="text" minlength="1" maxlength="255" class="rounded-lg bg-slate-100 p-1" name="name" placeholder="e.g. Broccoli" required />
    <div class="actions pt-3">
        <a href="/" class="rounded-lg p-2 bg-red-200">Cancel</a>
        <input type="submit" class="rounded-lg p-1 pl-2 pr-2 bg-blue-200" value="Add it" />
    </div>
</form>

@endsection
