<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Concession;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    

    public function __construct(
        protected OrderRepositoryInterface $orderRepository, protected ConcessionRepositoryInterface $concessionRepository)
    {
     
        
    }

    public function index()
    {
        // Fetch orders from the repository
       
        return view('orders.index');
    }

    public function getOrders() {

        $orders = $this->orderRepository->getOrdersForDisplay();

        return response()->json([
            'orders' => $orders->items(), // Actual order data
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
                'next_page_url' => $orders->nextPageUrl(),
                'prev_page_url' => $orders->previousPageUrl(),
            ]
        ]);
    }

    public function create()
    {
        $concessions = $this->concessionRepository->all();
        return view('orders.create', compact('concessions'));
    }

    // public function show($id)
    // {
    //     $order = Order::find($id);
    //     return view('orders.show', compact('order'));
    // }

    public function edit(Order $order)
    {
        Gate::authorize('update', $order);

        $order = $this->orderRepository->findWithConcessions($order->id);
        $concessions = $this->concessionRepository->all();
        

        return view('orders.edit', compact('order','concessions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'concessions' => 'required|array|min:1',
            'send_to_kitchen_time' => 'required|date|after:now',
        ]);

        $order = $this->orderRepository->create([
            'user_id' => Auth::id(),
            'send_to_kitchen_time' => $request->send_to_kitchen_time,
            'status' => 'Pending',
        ]);

        $order->concessions()->attach($request->concessions);

        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
    }

    public function update(Request $request,Order $order) {
          // Validate the incoming data
          $validatedData = $request->validate([
            'concessions' => 'required|array',
            'concessions.*' => 'exists:concessions,id',
            'send_to_kitchen_time' => 'required|date|after_or_equal:now',
        ]);

        try {
            // Use the repository to update the order
            $order = $this->orderRepository->updateOrder($order, $validatedData);

            return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
   

    public function destroy(Order $order) {
         $this->orderRepository->delete($order);
         return redirect('orders')->with('success','Order Deleted');
    }

    public function sendToKitchen($orderId)
    {
        $success = $this->orderRepository->sendToKitchen($orderId);

        return redirect()->back()->with(
            $success ? 'status' : 'error', 
            $success ? 'Order sent to the kitchen.' : 'Order is already in progress or completed.'
        );
    }
}
