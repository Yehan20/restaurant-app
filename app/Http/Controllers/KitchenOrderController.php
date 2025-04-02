<?php

namespace App\Http\Controllers;

use App\Events\MyEvent2;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Repositories\Interfaces\KitchenRepositoryInterface;

class KitchenOrderController extends Controller
{
  

    public function __construct(
        protected KitchenRepositoryInterface $kitchenRepository)
    {
     
    }

    public function index()
    {
        // Get the orders that are In-Progress
        $orders = $this->kitchenRepository->getInProgressOrders();
        
        return view('kitchen.index', compact('orders'));
    }

    public function completeOrder(Request $request,Order $order)
    {
        $request->validate([
            'status' => 'required|in:Completed'
        ]);

        // Update the order status to Completed
        $statusUpdated = $this->kitchenRepository->updateOrderStatus($order, $request->status);

        if ($statusUpdated) {
            return redirect()->route('kitchen.index')->with('success', 'Order status updated.');
        }

        return redirect()->route('kitchen.index')->with('error', 'Order must be In-Progress to mark as Completed.');
    }


}
