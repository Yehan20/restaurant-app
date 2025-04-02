<?php 

namespace App\Repositories\Interfaces;


use App\Repositories\Interfaces\BaseRepositoryInterface;

interface KitchenRepositoryInterface
{
    public function getInProgressOrders();
    public function updateOrderStatus($order, $status);
}
