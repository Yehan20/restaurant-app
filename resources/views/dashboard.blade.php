@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Dashboard Container -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-xl font-semibold mb-4">Welcome Back, {{ auth()->user()->name }}!</h3>
                <p class="text-lg text-gray-600 mb-6">{{ __("You're logged in!") }}</p>

                <!-- Dashboard Operations -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Operation 1: View Orders -->
                    <div class="bg-indigo-50 p-6 rounded-lg shadow-md hover:bg-indigo-100 transition duration-300">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">View Orders</h4>
                        <p class="text-gray-600 mb-4">View and manage all your customer orders from here.</p>
                        <x-primary-button class="w-full">
                            <a href="{{ route('orders.index') }}">{{ __('Manage Orders') }}</a>
                        </x-primary-button>
                    </div>

                    <!-- Operation 2: Manage Concessions -->
                    <div class="bg-indigo-50 p-6 rounded-lg shadow-md hover:bg-indigo-100 transition duration-300">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">Manage Concessions</h4>
                        <p class="text-gray-600 mb-4">Add, update, or remove concessions available in your system.</p>
                        <x-primary-button class="w-full">
                            <a href="{{ route('concessions.index') }}">{{ __('Manage Concessions') }}</a>
                        </x-primary-button>
                    </div>

                    <!-- Operation 3: Manage Kitchen -->
                    <div class="bg-indigo-50 p-6 rounded-lg shadow-md hover:bg-indigo-100 transition duration-300">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">Manage Kitchen</h4>
                        <p class="text-gray-600 mb-4">View kitchen orders, update their status, and manage tasks.</p>
                        <x-primary-button class="w-full">
                            <a href="{{ route('kitchen.index') }}">{{ __('Manage Kitchen') }}</a>
                        </x-primary-button>
                    </div>

                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
