<?php

namespace App\Exports;

use App\Services\RevenueService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TicketRevenueExport implements FromCollection, WithHeadings, WithTitle
{
    protected $revenueService;

    public function __construct(RevenueService $revenueService)
    {
        $this->revenueService = $revenueService;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $startDate = now('Asia/Ho_Chi_Minh')->subHours(24)->format('Y-m-d H:i:m');
        $endDate = now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:m');

        return $this->revenueService->movieRevenue($startDate, $endDate);

    }

    public function headings(): array
    {
        return [
            'movieId',
            'movieName',
            'amountMoney',
            'numberTicket'
        ];
    }

    public function title(): string
    {
        return 'Revenue Report Daily By Movie Ticket';
    }
}
