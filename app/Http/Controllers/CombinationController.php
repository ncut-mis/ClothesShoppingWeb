<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Combination;
use App\Models\combinations_detail;
use App\Http\Requests\StoreCombinationRequest;
use App\Http\Requests\UpdateCombinationRequest;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\stock;
use App\Models\TrialItem;
use App\Models\specification;


class CombinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Combination $combination)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        $trialItems = TrialItem::where('product_id','=',$product->id)->get();
        return view('admin.combination.create',['MainProduct' => $product ,'trialItems' => $trialItems]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $MainProduct = Product::find($request['MainProductID']);
        $trialItems = TrialItem::where('product_id','=',$MainProduct->id)->get();
        $price = $MainProduct->price;
        foreach($trialItems as $trialItem)
        {
            $price += $trialItem->trialProduct->price;
        }

        $combination = new Combination();
        $combination->staff_id = Auth::guard('admin')->user()->id;
        $combination->name = $request['CombinationName'];
        $combination->price = $price;
        $combination->product_id = $request['MainProductID'];

        $combination->save();

        foreach($trialItems as $trialItem)
        {
            $combinations_detail = new combinations_detail();
            $combinations_detail->combination_id = $combination->id;
            $combinations_detail->product_id = $trialItem->trialProduct->id;
            $combinations_detail->save();

            $trialItem->delete();
        }       

        $combinations = Combination::Where('product_id', '=', $MainProduct->id)->paginate(10);
        $stocks = stock::Where('product_id', '=', $MainProduct->id)->get();
        $specifications = specification::Where('product_id','=',$MainProduct->id)->get();

        session()->flash('message', '新增搭配組合成功');
        return view('admin.product.show', ['product' => $MainProduct , 'combinations' => $combinations , 'TrialItems' => $trialItems , 'stocks' => $stocks , 'specifications' => $specifications]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Combination $combination)
    {
        $product = Product::find($combination->product_id);
        $items = combinations_detail::where('combination_id', $combination->id)
                                  ->join('products', 'combinations_detail.product_id', '=', 'products.id')
                                  ->join('categories', 'products.category_id', '=', 'categories.id')
                                  ->orderBy('categories.category_type', 'asc')  
                                  ->get();
        return view('combination.show',compact('combination','product','items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Combination $combination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCombinationRequest $request)
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
