@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mt-10 mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Orders Management</h2>

        <div id="live-update-wrapper"></div>

        <div class="flex justify-between mb-4">
            <a href="{{ route('orders.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Create Order
            </a>
        </div>

        <div class="overflow-x-auto">
            <!-- Pagination Controls -->
            <div class="flex justify-between items-center my-4">
                <button id="prev-page" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">Previous</button>
                <span id="pagination-info" class="text-gray-700"></span>
                <button id="next-page" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">Next</button>
            </div>
            <table class="w-full border-collapse border border-gray-200 shadow-sm rounded-lg">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        <th class="p-3 border border-gray-200">Order ID</th>
                        <th class="p-3 border border-gray-200">Total Cost</th>
                        <th class="p-3 border border-gray-200">Status</th>
                        <th class="p-3 border border-gray-200">Actions</th>
                        <th class="p-3 border border-gray-200">Time for auto update</th>
                    </tr>
                </thead>
                <tbody id="order-table-body">
                    <!-- Orders will be loaded here via AJAX -->
                </tbody>
            </table>
        </div>


    </div>
@endsection

@push('scripts')
  
    <script>
        let timers = [];
        let timerInterval;
        let currentPage = 1;

        //  Show Success Message
        function showSuccessMessage(message) {
            let statusContainer = document.getElementById('status');
            if (statusContainer) statusContainer.remove();

            let successDiv = document.createElement("div");
            successDiv.className = "mb-4 p-3 bg-green-100 text-green-700 rounded-lg";
            successDiv.textContent = message;

            let container = document.getElementById("live-update-wrapper") || document.body;
            container.prepend(successDiv);

            setTimeout(() => successDiv.remove(), 3000);
        }

        //  Load Orders via AJAX (with Pagination)
        function loadOrders(page = 1) {
            fetch(`/orders/ajax?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    let tbody = document.getElementById("order-table-body");
                    tbody.innerHTML = "";
                    timers = []; // Reset timers

                    if (data.orders.length === 0) {
                        tbody.innerHTML =
                            '<tr><td colspan="5" class="p-4 text-center text-gray-500">No orders found.</td></tr>';
                        return;
                    }

                    data.orders.forEach(order => {
                        let row = `
                            <tr class="border border-gray-200">
                                <td class="p-3">${order.id}</td>
                                <td class="p-3 font-semibold">$${parseFloat(order.total_cost).toFixed(2)}</td>
                                <td class="p-3">
                                    <span class="px-3 py-1 text-sm rounded-lg 
                                        ${order.status === 'Pending' ? 'bg-yellow-100 text-yellow-700' : 
                                        order.status === 'In-Progress' ? 'bg-blue-100 text-blue-700' : 
                                        'bg-green-100 text-green-700'}">
                                        ${order.status}
                                    </span>
                                </td>
                                <td class="p-3 flex space-x-2">
                                    ${order.can_edit ? `<a href="/orders/${order.id}/edit" class="px-3 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">Edit</a>` : ''}

                                    <form action="/orders/${order.id}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Delete</button>
                                    </form>

                                    ${order.status === 'Pending' ? 
                                        `<form action="/orders/${order.id}/send-to-kitchen" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Send to Kitchen</button>
                                                </form>` : 
                                        order.status === 'In-Progress' ?
                                        '<span class="text-blue-600 flex items-center">Already in Progress</span>' :
                                        '<span class="text-green-600 flex items-center">Completed</span>'
                                    }
                                </td>
                                <td class="p-3" id="timer-${order.id}">${order.status === 'Pending' ? 'Calculating...' : '-'}</td>
                            </tr>`;

                        tbody.innerHTML += row;

                        if (order.status === 'Pending' && order.send_to_kitchen_time) {
                            timers.push({
                                orderId: order.id,
                                sendToKitchenTime: new Date(order.send_to_kitchen_time).getTime(),
                            });
                        }
                    });

                    updatePaginationUI(data.pagination);
                    startTimers();
                })
                .catch(error => console.error('Error loading orders:', error));
        }

        //  Countdown Timer
        function startTimers() {
            if (timerInterval) clearInterval(timerInterval);

            if (timers.length > 0) {
                timerInterval = setInterval(updateTimers, 1000);
            }
        }

        function updateTimers() {
            let currentTime = new Date().getTime();
            timers.forEach(timer => {
                const timeLeft = timer.sendToKitchenTime - currentTime;
                const timerElement = document.getElementById(`timer-${timer.orderId}`);

                if (timerElement) {
                    if (timeLeft <= 0) {
                        timerElement.innerHTML = "<span class='text-red-600'>Time's up!</span>";
                    } else {
                        const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                        timerElement.innerHTML =
                            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }
                }
            });
        }

        //  Pagination UI
        function updatePaginationUI(pagination) {
            document.getElementById("pagination-info").innerText =
                `Page ${pagination.current_page} of ${pagination.last_page}`;

            let prevBtn = document.getElementById("prev-page");
            let nextBtn = document.getElementById("next-page");

            prevBtn.disabled = !pagination.prev_page_url;
            nextBtn.disabled = !pagination.next_page_url;

            prevBtn.onclick = () => {
                if (pagination.prev_page_url) loadOrders(--currentPage);
            };
            nextBtn.onclick = () => {
                if (pagination.next_page_url) loadOrders(++currentPage);
            };
        }

       
        document.addEventListener("DOMContentLoaded", () => {
            loadOrders();
        });
    </script>
@endpush
