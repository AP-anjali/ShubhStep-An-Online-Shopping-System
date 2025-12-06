<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RefundStatusController;

class CheckRefundStatusForReturn extends Command
{
    protected $signature = 'check:refundstatusforreturn';
    protected $description = 'Check refund status for returned orders and update accordingly';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $RefundStatusController = new RefundStatusController();
        $RefundStatusController->checkRefundStatusForReturn();
        $this->info('Checked refund status for returned orders.');
    }
}
