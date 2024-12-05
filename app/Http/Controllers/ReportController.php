<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\PaymentDetails;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function registration_report()
    {
        $data = Registration::all();
        // $viewpayment = PaymentDetails::where('registration_no', $registration_no)->first();
        return view('pages.report.registration-report', compact('data'));
    }
}
