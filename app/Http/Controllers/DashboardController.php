<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Enquiry;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Room;
use App\Models\Package;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    // public function dashboard()
    // {
    //     return view('pages.dashboard');
    // }
    public function dashboard()
    {
        $totalregistration = Registration::count();
        $activePlayers = Registration::where('status', '0')->count();   // Active Players
        $inactivePlayers = Registration::where('status', '1')->count(); // Inactive Players

        $totallead = Enquiry::count();
        $totalstock = Stock::count();
        $totalroomtype = Room::count();
        $totalproduct = Product::count();
        $totalCategory = Category::count();
        $data = Product::latest()->get();
        $sdata = Enquiry::with(['leads'])->latest()->get();
        $convertedLeads = Enquiry::where('is_converted', '1')->count();

        $units = Unit::where('status', '0')->orderBy('unit', 'asc')->get();

        // Default counts
        $payAndPlayCount = 0;
        $membershipCount = 0;
        $trainingProgramCount = 0;

        // Fetch packages based on names
        $payAndPlayPackage = Package::where('package', 'LIKE', '%Pay%Play%')->first();
        $membershipPackage = Package::where('package', 'LIKE', '%Membership%')->first();
        $trainingProgramPackage = Package::where('package', 'LIKE', '%Training%')->orWhere('package', 'LIKE', '%Program%')->first();

        // Count registrations for Pay & Play
        if ($payAndPlayPackage) {
            $payAndPlayCount = Registration::where('package', $payAndPlayPackage->package_id)->count();
        }

        // Count registrations for Membership
        if ($membershipPackage) {
            $membershipCount = Registration::where('package', $membershipPackage->package_id)->count();
        }

        // Count registrations for Training Program
        if ($trainingProgramPackage) {
            $trainingProgramCount = Registration::where('package', $trainingProgramPackage->package_id)->count();
        }

        return view('pages.dashboard', compact(
            'payAndPlayCount',
            'membershipCount',
            'trainingProgramCount',
            'totalregistration',
            'totalproduct',
            'totalstock',
            'totallead',
            'totalCategory',
            'data',
            'sdata',
            'units',
            'inactivePlayers',
            'activePlayers',
            'totalroomtype',
            'convertedLeads'
        ));
    }


    public function loguots(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
