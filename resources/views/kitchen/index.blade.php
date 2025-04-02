@extends('layouts.app')

@section('content')
<div class="max-w-6xl mt-10 mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">Kitchen Management</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200 shadow-sm rounded-lg">
            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="p-3 border border-gray-200">Order ID</th>
                    <th class="p-3 border border-gray-200">Total Cost</th>
                    <th class="p-3 border border-gray-200">Concessions</th>
                    <th class="p-3 border border-gray-200">Status</th>
                    <th class="p-3 border border-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border border-gray-200">
                        <td class="p-3">{{ $order->id }}</td>
                        <td class="p-3 font-semibold">${{ number_format($order->concessions->sum('price'), 2) }}</td>
                        <td class="p-3">
                            <ul class="list-disc pl-4 text-gray-700">
                                @foreach($order->concessions as $concession)
                                    <li>{{ $concession->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="p-3">
                            <span class="px-3 py-1 text-sm rounded-lg
                                {{ $order->status === 'In-Progress' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="p-3">
                            <form action="{{ route('kitchen.completeOrder', ['order'=>$order->id]) }}"
                                 method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Completed">
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    Mark as Completed
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">No orders in progress.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
