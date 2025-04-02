<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function findWithConcessions($id)
    {
        return $this->model->with('concessions')->find($id);
    }

    public function getPendingOrdersToProcess($currentTime): Collection
    {
        return $this->model->where('status', 'Pending')
            ->where('send_to_kitchen_time', '<=', $currentTime)
            ->get();
    }

    public function sendToKitchen($orderId): bool
    {
        $order = $this->model->find($orderId);

        if (!$order || $order->status !== 'Pending') {
            return false;
        }

        $order->status = 'In-Progress';
        return $order->save();
    }

    public function updateOrder($order, array $data)
    {
        // Validate Send to Kitchen Time (ensure it's not in the past)
        if (Carbon::parse($data['send_to_kitchen_time'])->isBefore(Carbon::now())) {
            throw new \Exception('Send to Kitchen Time cannot be in the past.');
        }

        // Update the order with the new data
        $order->concessions()->sync($data['concessions']);
        $order->send_to_kitchen_time = $data['send_to_kitchen_time'];
        $order->save();

        return $order;
    }

    public function getOrdersForDisplay(): LengthAwarePaginator 
    {
        // Fetch the orders with their concessions
        $orders = $this->model->orderBy('id','DESC')->with('concessions')->paginate(10);
        // Transform the collection
        return $orders->through(function ($order) {
            return [
                'id' => $order->id,
                'total_cost' => $order->concessions->sum('price'),
                'status' => $order->status,
                'send_to_kitchen_time' => $order->send_to_kitchen_time,
                'can_edit' => auth()->user()->can('update', $order),
            ];
        });

        // return $orders;
    }
}
