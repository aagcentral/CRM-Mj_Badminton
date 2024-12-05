<?php

namespace App\Http\Controllers;

use App\Models\DistributedStock;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Registration;
use Illuminate\Http\Request;
use Auth;

class DistributedStockController extends Controller
{
    public function distributed_list()
    {
        $data = DistributedStock::with(['products', 'Category', 'units', 'register'])->latest()->get();
        $Category = Category::where('status', '0')->orderBy('category', 'asc')->get();
        $Product = Product::where('status', '0')->orderBy('product', 'asc')->get();
        $units = Unit::where('status', '0')->orderBy('unit', 'asc')->get();
        $Registrations = Registration::where('status', '0')->orderBy('name', 'asc')->get();
        return view('pages.stock-management.distributed.distributed-stock', compact('data', 'Category', 'Product', 'units', 'Registrations'));
    }

    public function get_distributed_products(Request $request)
    {
        if ($request->category_id) {
            $products = Product::where('category_id', $request->category)->latest()->get();
            return response()->json($products);
        }
    }


    public function dstock()
    {
        $data = DistributedStock::max('id');
        return $data ? $data + 1 : 1;
    }


    public function add_distributed(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'registration_no' => 'required',
            'category' => 'required',
            'product' => 'required',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required',

        ]);


        // Find the product in the stock
        $check_product = Product::where('product_id', $request->product)->where('status', '0')->first();

        if (!$check_product) {
            return back()->with('error', 'No Product Found');
        }

        // Check if stock exists for the product
        $stock = Stock::where('product_id', $request->product)->first();

        if (!$stock) {
            return back()->with('error', 'Stock not available for this product');
        }

        // Check if there is enough stock to distribute
        if ($stock->quantity < $request->quantity) {  // Deduct the requested quantity, not just 1
            return back()->with('error', 'This Product Is Out of Stock');
        }

        // Deduct the quantity from the stock
        $stock->quantity -= $request->quantity;  // Deduct requested quantity
        $stock->save();

        $distributedid = 'DSTID' . date('dmy') . $this->dstock() + 1;
        $save = DistributedStock::create([
            'distributed_id' => $distributedid,
            'registration_no' => $request->registration_no,
            'category' => $request->category,
            'product' => $request->product,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'notes' => $request->notes,
            'date' => date('Y-m-d H:i:s'),
            'status' =>  $request->status == "active" ? '0' : '1',
        ]);

        // Check if save is successful
        if ($save) {
            return back()->with('success', 'Stock Distributed Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }


    // edit
    public function edit_distributed($id)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_dstock = DistributedStock::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_dstock) {
            return redirect()->route('distributed.list')->with('success', 'Location Update.');
        }


        $Category = Category::all();
        $Product = Product::all();
        $units = Unit::where('status', '0')->orderBy('unit', 'asc')->get();
        $Registrations = Registration::where('status', '0')->orderBy('name', 'asc')->get();
        return view('pages.stock-management.distributed.distributed-stock-edit', compact('edit_dstock', 'Category', 'Product', 'units', 'Registrations'));
    }

    // update
    public function update_distributed(Request $request)
    {
        $data = $request->validate([
            'status' => 'required',
            'registration_no' => 'required',
            'category' => 'required',
            'product' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
        ]);
        $check = DistributedStock::where('id', $request->id)->whereNull('deleted_at')->first();
        if ($check) {
            $updated = DistributedStock::where('id', $request->id)->update([
                'registration_no' => $request->registration_no,
                'category' => $request->category,
                'product' => $request->product,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                'notes' => $request->notes,
                'date' => date('Y-m-d H:i:s'),
                'status' =>  $request->status
            ]);
            if ($updated) {
                return redirect()->route('distributed.list')->withSuccess('Distributed Stock Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
        return back()->with('fail', 'No Data Found!!!');
    }

    // delete
    public function destroy_distributed(Request $request)
    {
        $data = DistributedStock::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }
}
