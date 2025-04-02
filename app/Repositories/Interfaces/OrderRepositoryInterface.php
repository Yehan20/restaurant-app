<?php
namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function findWithConcessions($id);
    public function getPendingOrdersToProcess($currentTime): Collection;
    public function sendToKitchen($orderId): bool;
    public function updateOrder($orderId, array $data);
    public function getOrdersForDisplay(): LengthAwarePaginator ;
    
}
