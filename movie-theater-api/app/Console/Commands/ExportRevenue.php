<?php

namespace App\Console\Commands;

use App\Exports\TicketRevenueExport;
use App\Services\RevenueService;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportRevenue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-revenue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'export ticket revenue for each movie to an Excel';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $revenueService = app(RevenueService::class);
        Excel::store(new TicketRevenueExport($revenueService), 'movie_revenue_'.now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:m').'.xlsx');

        $this->info('Ticket revenue report ' . now('Asia/Ho_Chi_Minh'));
    }
}
