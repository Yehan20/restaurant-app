<?php
 
namespace App\Console\Commands;

use App\Events\MyEvent2;
use Illuminate\Console\Command;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Jobs\ProcessOrderJob;
use Carbon\Carbon;

class ProcessPendingOrders extends Command
{
    protected $signature = 'orders:process';
    protected $description = 'Automatically send pending orders to the kitchen';
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        parent::__construct();
        $this->orderRepository = $orderRepository;
    }

    public function handle()
    {
        $now = Carbon::now();
        $orders = $this->orderRepository->getPendingOrdersToProcess($now);

       

        if ($orders->isEmpty()) {
            $this->info('No orders to process.');
            return;
        }

        

        foreach ($orders as $order) {
            
            ProcessOrderJob::dispatch($order);
        }

        $this->info(count($orders) . ' orders have been queued for processing.');
    }
}
