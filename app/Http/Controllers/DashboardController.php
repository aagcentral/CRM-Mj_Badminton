<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Enquiry;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Unit;
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
        $totallead = Enquiry::count();
        $totalstock = Stock::count();
        $totalproduct = Product::count();
        $totalCategory = Category::count();
        $data = Product::latest()->get();
        $sdata = Enquiry::with(['leads'])->latest()->get();
        $units = Unit::where('status', '0')->orderBy('unit', 'asc')->get();

        return view('pages.dashboard', compact('totalregistration', 'totalproduct', 'totalstock', 'totallead', 'totalCategory', 'data', 'sdata', 'units'));
    }

    public function loguots(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
