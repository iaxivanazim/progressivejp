<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HouseCommission;
use App\Exports\HouseCommissionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class HouseCommissionController extends Controller
{
    public function index(Request $request)
    {
        // Search functionality
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');

        // Date range filter
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fetch house commissions with search, sorting, and date range filter
        $commissions = HouseCommission::with('bet')
            ->when($search, function ($query, $search) {
                return $query->whereHas('bet', function ($q) use ($search) {
                    return $q->where('id', 'like', "%{$search}%");
                })->orWhere('commission_amount', 'like', "%{$search}%");
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay(),
                ]);
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(20);

        // Export to Excel functionality
        if ($request->has('export') && $request->export == 'excel') {
            return Excel::download(new HouseCommissionsExport($commissions), 'house_commissions.xlsx');
        }

        return view('house_commissions.index', compact('commissions'));
    }
}
