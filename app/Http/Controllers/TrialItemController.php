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
        $trailItems = TrialItem::Where();
        
       
        
        return view('admin.trialitems.index', ['trailItems' => $results]);
    }

    public function create($productID)
    {
        $product = Product::find($productID);
        $category_type = $product->Category->category_type; // 获取主产品的类别类型
        $products = Product::with('category')
                            ->whereHas('category', function ($query) use ($category_type) {
                                $query->where('category_type', '<>', $category_type);
                            })
                            ->get();
        $groupedProducts = $products->groupBy(function ($item, $key) {
            return $item->category->category_type;
        });

        return view('admin.trialitems.create', ['MainProduct' => $product , 'groupedProducts' => $groupedProducts]);
    }

    public function store(Request $request)
    {
        $productID = $request['productID'];  // 主商品ID
        $product = Product::find($productID);

        // 获取所选产品列表
        $selectedProductIDs = $request->input('productlist', []);

        // 遍历所选产品列表
        foreach ($selectedProductIDs as $selectedProductID) {
            // 检查是否存在相同部位的试搭项
            $selectedProduct = Product::find($selectedProductID);
            if ($this->hasExistingTrialItem($selectedProduct->Category->category_type)) {
                session()->flash('message', '已存在相同部位的服裝');
                return redirect()->route('admin.product.adminShow', ['product' => $product]);
            }

            // 新增试搭项
            $this->createTrialItem($productID, $selectedProductID);
        }
       
        // 加入试搭成功消息
        session()->flash('message', '加入試搭成功');
        return redirect()->route('admin.product.adminShow', ['product' => $product]);
    }

    public function update(Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        $TrialitemID = $request['TrialitemID'];
        $trialItem = TrialItem::find($TrialitemID);
        $trialItem->delete();
        session()->flash('message', '刪除成功');
        return redirect()->back();
    }

    private function hasExistingTrialItem($categoryType)
    {
        $trialItems = TrialItem::all();
        foreach($trialItems as $trialItem)
        {
            if($trialItem->trialProduct->Category->category_type == $categoryType){
                return true;
            }
            else{
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

