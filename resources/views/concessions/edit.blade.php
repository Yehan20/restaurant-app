@extends('layouts.app')

@section('content')
<div class="max-w-4xl mt-10 mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">Edit Concession - {{ $concession->name }}</h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('concessions.update', $concession->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" value="{{ $concession->name }}" required class="w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" class="w-full p-2 border border-gray-300 rounded-lg">{{ $concession->description }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Price</label>
            <input type="number" step="0.01" name="price" value="{{ $concession->price }}" required class="w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Current Image</label>
            <img src="{{ asset('storage/'.$concession->image) }}" class="w-32 h-32 rounded-lg mb-2">
            <input type="file" name="image" class="w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                Update Concession
            </button>
        </div>
    </form>
</div>
@endsection
