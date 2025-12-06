<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SevenDaysStatusController;

class UpdateSevenDaysStatus extends Command
{
    protected $signature = 'orders:update-seven-days-status';
    protected $description = 'Update seven days status for orders';

    protected $sevenDaysStatusController;

    public function __construct(SevenDaysStatusController $sevenDaysStatusController)
    {
        parent::__construct();
        $this->sevenDaysStatusController = $sevenDaysStatusController;
    }

    public function handle()
    {
        $this->sevenDaysStatusController->updateSevenDaysStatus();
        $this->info('Updated 7 days status successfully!');
    }
}
