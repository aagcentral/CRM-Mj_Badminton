<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;

class StockController extends Controller
{
    public function stock_list(Request $request)
    {
        $element = Stock::with(['products', 'Category']);
        // dd($data);
        $units = Unit::where('status', '0')->orderBy('unit', 'asc')->get();
        $Category = Category::where('status', '0')->orderBy('category', 'asc')->get();
        $Product = Product::where('status', '0')->orderBy('product', 'asc')->get();

        if ($request->has('category') && $request->category !== null) {
            $element->where('category', $request->category);
        }
        if ($request->has('product') && $request->product !== null) {
            $element->where('product_id', $request->product);
        }

        $data = $element->latest()->get();
        return view('pages.stock-management.stock.stock-list', compact('data', 'units', 'Category', 'Product'));
    }

    public function getProductsByCategory(Request $request)
    {
        $products = Product::where('category', $request->category_id)
            ->where('status', '0')
            ->orderBy('product', 'asc')
            ->get();
        return response()->json($products);
    }


    public function get_products(Request $request)
    {
        if ($request->category_id) {
            $products = Product::where('category', $request->category_id)->latest()->get();
            return response()->json($products);
        }
    }

    public function stock()
    {
        $data = Stock::max('id');
        return $data ? $data + 1 : 1;
    }

    // add
    public function add_stock(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'category' => 'required',
            'quantity' => 'required|numeric|min:1', // Ensure quantity is provided and valid
            'unit' => 'required',
            'product_type' => 'required',
        ]);

        // Check if the product already exists in the stock
        $existingStock = Stock::where('product_id', $request->product_id)->first();

        if ($existingStock) {
            // If the product exists, update the quantity
            $existingStock->quantity += $request->quantity; // Add the new quantity to the existing quantity

            // Update other fields if needed
            $existingStock->expiry_date = $request->expiry_date;
            $existingStock->notes = $request->notes;
            $existingStock->status = $request->status == "active" ? '0' : '1';
            $existingStock->save();

            return back()->with('success', 'Stock Updated Successfully');
        } else {
            // If product doesn't exist, create a new stock entry
            $stockId = 'STID' . date('dmy') . $this->stock() + 1;
            $save = Stock::create([
                'stock_id' => $stockId,
                'product_id' => $request->product_id,
                'category' => $request->category,
                'quantity' => $request->quantity, // Set the initial quantity
                'unit' => $request->unit,
                'product_type' => $request->product_type,
                'added_on' => $request->added_on,
                'vender_name' => $request->vender_name,
                'expiry_date' => $request->expiry_date,
                'notes' => $request->notes,
                'date' => date('Y-m-d H:i:s'),
                'status' => $request->status == "active" ? '0' : '1',
            ]);

            // Check if save is successful
            if ($save) {
                return back()->with('success', 'Stock Added Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        }
    }



    // edit
    public function edit_stock($id)
    {
        $user = Auth::user();
        $locationID = $user->locationID;
        $edit_stock = Stock::where('id', $id)->where('locationID', $locationID)->first();
        if (!$edit_stock) {
            return redirect()->route('stock.list')->with('success', 'Location Update.');
        }

        $units = Unit::where('status', '0')->orderBy('unit', 'asc')->get();
        $category = Category::all();
        $products = Product::all();

        return view('pages.stock-management.stock.edit-stock', compact('edit_stock', 'units', 'category', 'products'));
    }


    public function update_stock(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'stock_id' => 'required|exists:stocks,stock_id',
            'product_id' => 'required|exists:products,product_id',
            'category' => 'required',
            'quantity' => 'required|numeric|min:1', // Ensure quantity is valid
            'unit' => 'required',
            'product_type' => 'required',
        ]);

        // Check if the stock exists and is not deleted
        $existingStock = Stock::where('stock_id', $request->stock_id)->whereNull('deleted_at')->first();

        if (is_null($existingStock)) {
            return back()->with('error', 'No Stock Found');
        }

        // Update stock
        $existingStock->quantity += $request->quantity; // Add the new quantity to the existing quantity
        $existingStock->product_id = $request->product_id;
        $existingStock->category = $request->category;
        $existingStock->unit = $request->unit;
        $existingStock->product_type = $request->product_type;
        $existingStock->added_on = $request->added_on;
        $existingStock->vender_name = $request->vender_name;
        $existingStock->expiry_date = $request->expiry_date;
        $existingStock->notes = $request->notes;
        $existingStock->status = $request->status;
        $existingStock->date = now();

        if ($existingStock->save()) {
            return redirect()->route('stock.list')->with('success', 'Stock Updated Successfully');
        } else {
            return back()->with('fail', 'Something Went Wrong, Try again');
        }
    }


    // delete
    public function destroy_stock(Request $request)
    {
        $data = Stock::where('id', $request->id)->first();
        $data->delete();
        return response()->json(['message' => 'data deleted successfully.']);
    }
}
