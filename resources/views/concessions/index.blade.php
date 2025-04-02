@extends('layouts.app')

@section('content')
<div class="max-w-6xl mt-10 mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">Concession Management</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between mb-4">
        <a href="{{ route('concessions.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            + Add Concession
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200 shadow-sm rounded-lg">
            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="p-3 border border-gray-200">Image</th>
                    <th class="p-3 border border-gray-200">Name</th>
                    <th class="p-3 border border-gray-200">Price</th>
                    <th class="p-3 border border-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($concessions as $concession)
                    <tr class="border border-gray-200">
                        <td class="p-3">
                            <img src="{{ asset('storage/'.$concession->image) }}" alt="{{ $concession->name }}" class="w-16 h-16 rounded-lg">
                        </td>
                        <td class="p-3 font-semibold">{{ $concession->name }}</td>
                        <td class="p-3 font-semibold">${{ number_format($concession->price, 2) }}</td>
                        <td class="p-3 flex space-x-2">
                            <a href="{{ route('concessions.edit', $concession->id) }}" class="px-3 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">Edit</a>
                            <form action="{{ route('concessions.destroy', ['concession'=>$concession->id]) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">No concessions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $concessions->links() }}
        </div>
    </div>
</div>
@endsection
