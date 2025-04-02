@extends('layouts.app')

@section('content')
<div class="max-w-4xl mt-10 mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">Edit Order #{{ $order->id }}</h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.update', $order->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PATCH')

        <div>
            <label class="block text-sm font-medium text-gray-700">Select Concessions</label>
            <select name="concessions[]" multiple required class="w-full p-2 border border-gray-300 rounded-lg">
                @foreach($concessions as $concession)

                    <option value="{{ $concession->id }}"
                         {{ in_array($concession->id, $order->concessions->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $concession->name }} - ${{ number_format($concession->price, 2) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Send to Kitchen Time</label>
            <input type="datetime-local" name="send_to_kitchen_time" value="{{ $order->send_to_kitchen_time }}" required class="w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                Update Order
            </button>
        </div>
    </form>
</div>
@endsection
