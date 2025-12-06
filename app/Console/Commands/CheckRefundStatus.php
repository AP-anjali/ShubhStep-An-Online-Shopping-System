<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\OrderController;

class CheckRefundStatus extends Command
{
    protected $signature = 'check:refundstatus';
    protected $description = 'Check refund status for cancelled or rejected orders and update accordingly';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $orderController = new OrderController();
        $orderController->checkRefundStatus();
        $this->info('Checked refund status for cancelled or rejected orders.');
    }
}
