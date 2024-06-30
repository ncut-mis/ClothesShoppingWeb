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
        $combination->is_shelf = 1;

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
        return view('combination.show',['combination'=>$combination]);
    }

    public function admin_show(Combination $combination)
    {
        return view('admin.combination.show',['combination'=>$combination]);
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
    public function admin_update(Request $request)
    {
        $combination_id = $request['combinationID'];
        $combination = Combination::find($combination_id);

        $combination->name = $request['combinationName'];
        $combination->price = $request['combinationPrice'];
        $combination->save();

        session()->flash('message', '修改成功');
        return back();
    }




    /**
     * Remove the specified resource from storage.
     */
    public function admin_destroy(Request $request)
    {
        $combination_id = $request['combination_ID'];
        $combination = Combination::find($combination_id);

        foreach ($combination->combinations_detail as $detail){
            $detail->delete();
        }

        $combination->delete();

        $product = Product::find($combination->product_id);
        session()->flash('message', '刪除成功');
        return redirect()->route('admin.product.adminShow', ['product' => $product]) ;
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

    public function stop($combinationID)
    {
        $combination = Combination::find($combinationID);
        $combination->is_shelf = 0;
        $combination->save();

        return back();
    }

    //上架類別
    public function launch($combinationID)
    {
        $combination = Combination::find($combinationID);
        $combination->is_shelf = 1;
        $combination->save();

        return back();
    }

    public function detail_add(Request $request)
    {
        $combinationID = $request['combinationID'];

        // 若成功新增回傳true，否則為false
        if(!$this->createTrialItem($combinationID, $request->input('product')))
        {
            session()->flash('message', '新增失敗，已存在相同的組合商品');
        }

        return back();
        
    }

    public function detail_delete(Request $request)
    {
        $detailID = $request['detail_id'];
        $detail = combinations_detail::find($detailID);
        $detail->delete();

        return back();
    }

    private function createTrialItem($combinationID, $selectedProductId)
    {
        $detail = new combinations_detail();
        $detail->combination_id = $combinationID;

        // 判斷試搭商品是否重複
        $is_exist = combinations_detail::Where('combination_id' , '=' , $combinationID)
                                        ->Where('product_id','=',$selectedProductId)
                                        ->exists();
        if($is_exist){
            return false;
        }
        $detail->product_id = $selectedProductId;
        $detail->save();   
        return true;         
    }


}
