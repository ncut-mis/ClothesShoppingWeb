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

        $this->createTrialItem($MainproductID, $request->input('product'));

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
        $trialItem->trial_product_id = $selectedProductId;
        $trialItem->save();            
    }
    
}

