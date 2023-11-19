<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportingController extends Controller
{
    public function __construct(protected ReportingService $reportingService)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function generateReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonths(3)->toDateString());
        $endDate = $request->get('end_date', Carbon::now()->toDateString());
        return response()->json([
            'data' => $this->reportingService->generateReport($startDate, $endDate),
        ]);
    }

}
