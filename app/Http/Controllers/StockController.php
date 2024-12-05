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
            'quantity' => 'required',
            'unit' => 'required',
            'total_price' => 'required',
            'product_type' => 'required',
        ]);

        // Check if the product already exists in the stock
        $existingStock = Stock::where('product_id', $request->product_id)->first();

        if ($existingStock) {
            // If product exists, update the existing stock by adding the new quantity
            $existingStock->quantity += $request->quantity;
            $existingStock->total_price = $existingStock->quantity * $request->single_price;
            $existingStock->expiry_date = $request->expiry_date; // Update expiry date if needed
            $existingStock->notes = $request->notes; // Update notes if provided
            $existingStock->status = $request->status == "active" ? '0' : '1'; // Update status
            $existingStock->save(); // Save the updated stock

            return back()->with('success', 'Stock Updated Successfully');
        } else {
            // If product doesn't exist, create new stock entry
            $stockId = 'STID' . date('dmy') . $this->stock() + 1;
            $save = Stock::create([
                'stock_id' => $stockId,
                'product_id' => $request->product_id,
                'category' => $request->category,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                'single_price' => $request->single_price,
                'total_price' => $request->quantity * $request->single_price,
                'added_on' => $request->added_on,
                'vender_name' => $request->vender_name,
                'product_type' => $request->product_type,
                'expiry_date' => $request->expiry_date,
                'notes' => $request->notes,
                'date' => date('Y-m-d H:i:s'),
                'status' =>  $request->status == "active" ? '0' : '1',
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
        $edit_stock = Stock::where('stock_id', $id)->where('locationID', $locationID)->first();
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
            'product_id' => 'required|exists:products,product_id',
            'category' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'total_price' => 'required',
            'product_type' => 'required',
        ]);

        $check = Stock::where('stock_id', $request->stock_id)->whereNull('deleted_at')->first();
        if (is_null($check)) {
            return back()->with('error', 'No Stock Found');
        }

        if ($check) {
            $updated = Stock::where('stock_id', $request->stock_id)->update([

                'product_id' => $request->product_id,
                'category' => $request->category,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                'single_price' => $request->single_price,
                'total_price' => $request->quantity * $request->single_price,
                'added_on' => $request->added_on,
                'vender_name' => $request->vender_name,
                'product_type' => $request->product_type,
                'expiry_date' => $request->expiry_date,
                'notes' => $request->notes,
                'date' => date('Y-m-d H:i:s'),
                'status' =>  $request->status

            ]);
            if ($updated) {
                return redirect()->route('stock.list')->withSuccess('Stock Updated Successfully');
            } else {
                return back()->with('fail', 'Something Went Wrong, Try again');
            }
        } else {
            return back()->with('fail', 'Stock not found');
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
