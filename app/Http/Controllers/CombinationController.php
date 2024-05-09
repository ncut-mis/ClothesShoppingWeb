<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Combination;
use App\Http\Requests\StoreCombinationRequest;
use App\Http\Requests\UpdateCombinationRequest;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\stock;

class CombinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Combination $combination)
    {
        $product = Product::find($combination->product_id);
        return view('combination.index',compact('combination','product'));
    }

    public function admin_index()
    {
        $combinations = Combination::all();
        return view('admin.combination.index', ['combinations' =>$combinations]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.combination.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCombinationRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);

        $combination = new Combination();
        $combination->name = $validated['name'];
        $combination->price = $validated['price'];
        $combination->description = $validated['description'];
        $combination->category_id = $validated['category_id'];

        $combination->save();
        return redirect()->route('combination.index')
                         ->with('success','新增成功');

    }

    /**
     * Display the specified resource.
     */
    public function show(Combination $combination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Combination $combination)
    {
        $data = [
            'combination'=>$combination,
        ];

        return view('admin.combination.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Combination $combination)
    {
        $combination_id = $request['combinationID'];
        $combination = Combination::find($combination_id);

        if($request->has('quantity')){
            $quantity = $request['quantity'];
            $combination->update([
                'quantity' => $quantity,
            ]);

            session()->flash('message', '修改數量成功');
            return redirect(route('combination.index'));
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $combination_id = $request['CartID'];
        $cart = Combination::find($combination_id);
        $cart->delete();
        session()->flash('message', '刪除成功');
        return redirect(route('combination.index'));
    }

    public function admin_search(Request $request)
    {
        $product = Product::find($request['productID']);
        $keyword = $request['keyword'];
        $combinations = Combination::where('product_id', $product->id)
                           ->where('name', 'like', '%' . $keyword . '%')
                           ->paginate(10);
        $image = ProductPhoto::Where('product_id', '=', $product->id)->first();
        $stocks = stock::Where('product_id', '=', $product->id)->get();
        return view('admin.product.show', ['product' => $product , 'combinations' => $combinations , 'stocks' => $stocks]);
    }
}
