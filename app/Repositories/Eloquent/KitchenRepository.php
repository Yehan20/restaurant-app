<?php
// app/Repositories/KitchenRepository.php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Interfaces\KitchenRepositoryInterface;

class KitchenRepository implements KitchenRepositoryInterface
{
    public function getInProgressOrders()
    {
        return Order::where('status', 'In-Progress')->with('concessions')->paginate(5);
    }

    public function updateOrderStatus($order, $status)
    {
    
 
        if ($order->status === 'In-Progress') {
            $order->status = $status;
            $order->save();
            return true;
        }

        return false;
    }
}
