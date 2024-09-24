<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AuditLogsExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        // Search and sorting inputs
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Querying logs
        $logsQuery = AuditLog::with('user')
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })
                    ->orWhere('event_type', 'like', "%$search%")
                    ->orWhere('details', 'like', "%$search%");
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            });

        // Check if records exceed 500
        if ($logsQuery->count() > 500) {
            // Get logs for exporting
            $logs = $logsQuery->get();

            // Export logs to Excel and save to storage
            $fileName = 'audit_logs_' . now()->format('Ymd_His') . '.xlsx';
            Excel::store(new AuditLogsExport($logs), 'public/audit_logs/' . $fileName);

            // Truncate the AuditLog table
            AuditLog::truncate();

            // Redirect with success message
            return redirect()->back()->with('success', 'Logs exported and saved. Table truncated.');
        }

        // Paginate the logs
        $logs = $logsQuery->orderBy($sortBy, $sortDirection)->paginate(20);

        // Handle Excel export on user request
        if ($request->has('export') && $request->export == 'excel') {
            return Excel::download(new AuditLogsExport($logs), 'audit_logs.xlsx');
        }

        return view('audit_logs.index', compact('logs'));
    }

    public function logFiles(Request $request)
{
    // Get the list of files in 'audit_logs' directory from the public disk
    $files = Storage::disk('public')->files('audit_logs');

    // Manually paginate the files
    $perPage = 20; // Number of files per page
    $currentPage = LengthAwarePaginator::resolveCurrentPage(); // Get current page or default to 1
    $currentPageItems = collect($files)->slice(($currentPage - 1) * $perPage, $perPage)->all(); // Slice the collection for the current page

    // Create a LengthAwarePaginator instance
    $paginatedFiles = new LengthAwarePaginator(
        $currentPageItems, // Items for the current page
        count($files), // Total items count
        $perPage, // Items per page
        $currentPage, // Current page number
        ['path' => $request->url()] // URL path for pagination links
    );

    return view('audit_logs.files', compact('paginatedFiles'));
}

    public function downloadFile($file)
    {

        // Validate if the file exists
        if (!Storage::disk('public')->exists('audit_logs/' . $file)) {
            abort(404, 'File not found.');
        }

        // Return the file for download
        return Storage::disk('public')->download('audit_logs/' . $file);
    }
}

