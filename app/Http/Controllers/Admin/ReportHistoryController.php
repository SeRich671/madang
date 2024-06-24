<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportHistory;
use Illuminate\Http\Request;

class ReportHistoryController extends Controller
{
    public function index(Request $request) {
        $reports = ReportHistory::paginate(
            $request->input('filters.per_page') ? ($request->input('filters.per_page') == 'all' ? 100000 : $request->input('filters.per_page')) : cache()->get('settings.per_page')
        );

        return view('admin.report.index', [
            'reports' => $reports
        ]);
    }
}
