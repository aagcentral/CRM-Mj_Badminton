<?php

namespace App\Http\Controllers;

use App\Models\RegisterStatusTracker;
use App\Models\Registration;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function fee_report(Request $request)
    {
        $registrations = Registration::all();
        $query = RegisterStatusTracker::with('Registration')
            ->select('*')
            ->whereIn('id', function ($subquery) {
                $subquery->selectRaw('MAX(id)')
                    ->from('register_status_trackers')
                    ->groupBy('registration_no');
            });

        if ($request->has('month') && $request->month !== null) {
            $query->whereMonth('created_at', date('m', strtotime($request->month)));
        }

        if ($request->has('year') && $request->year !== null) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->has('payment_status') && $request->payment_status !== null) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('registration_no') && $request->registration_no !== null) {
            $query->where('registration_no', $request->registration_no);
        }

        $data = $query->get();

        return view('pages.report.fee-report', compact('data', 'registrations'));
    }
}
