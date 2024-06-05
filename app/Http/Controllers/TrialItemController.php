<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrialItem;
use App\Models\Product;
use App\Models\stock;
use App\Models\Combination;

class TrialItemController extends Controller
{
    public function index()
    {
        
    }

    public function create($productID)
    {
        $product = Product::find($productID);
        $TrialTtems = TrialItem::Where('product_id','=',$productID)->get();

        return view('admin.trialitems.create', ['MainProduct' => $product , 'TrialTtems' => $TrialTtems]);
    }

    public function store(Request $request)
    {
        $MainproductID = $request['MainProductID'];  // 主商品ID
        $product = Product::find($MainproductID);

        // 若成功新增回傳true，否則為false
        if(!$this->createTrialItem($MainproductID, $request->input('product')))
        {
            session()->flash('message', '新增失敗，已存在相同的試搭商品');
        }

        $TrialTtems = TrialItem::Where('product_id','=',$MainproductID)->get();


        return view('admin.trialitems.create', ['MainProduct' => $product , 'TrialTtems' => $TrialTtems]);
    }

    

    public function update(Request $request)
    {
        // 新增试搭项
        // $this->createTrialItem($productID, $selectedProductID);
        

        // 加入试搭成功消息
        // session()->flash('message', '加入試搭成功');
        // return redirect()->route('admin.product.adminShow', ['product' => $product]);
    }

    public function edit(Request $request,Product $product)
    {
        $data =[
            'product'=>$product,
        ];

        return view('admin.trialitems.edit',$data);
    }


    public function destroy(Request $request)
    {
        $TrialitemID = $request['TrialitemID'];
        $trialItem = TrialItem::find($TrialitemID);
        $trialItem->delete();

        $productID = $request['productID'];
        $product = Product::find($productID);   
        $TrialTtems = TrialItem::Where('product_id','=',$productID)->get();

        session()->flash('message', '刪除成功');
        return view('admin.trialitems.create', ['MainProduct' => $product , 'TrialTtems' => $TrialTtems]);
        
    }


    private function hasExistingTrialItem($categoryType)
    {
        $trialItems = TrialItem::all();
        foreach($trialItems as $trialItem)
        {
            if($trialItem->trialProduct->Category->category_type == $categoryType)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

    }

    private function createTrialItem($productId, $selectedProductId)
    {
        $trialItem = new TrialItem();
        $trialItem->product_id = $productId;

        // 判斷試搭商品是否重複
        $is_exist = TrialItem::Where('trial_product_id' , '=' , $selectedProductId)->exists();
        if($is_exist){
            return false;
        }
        $trialItem->trial_product_id = $selectedProductId;
        $trialItem->save();   
        return true;         
    }
    
}

