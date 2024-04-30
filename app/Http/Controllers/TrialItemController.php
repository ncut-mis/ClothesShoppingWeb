<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrialItem;

class TrialItemController extends Controller
{
    public function index()
    {
        $trailItems = TrialItem::all()->groupBy('product_id');
        
        $results = [];
        foreach($trailItems as $productId => $items){
            $groupData = $items->map(function ($item) {
                // 使用 map 方法构建每条记录的数据结构
                return [
                    'id' => $item->id,
                    'product' => $item->product,
                    'trial_product' => $item->trialProduct,
                    'created_at' => $item->created_at->toDateTimeString(),
                    'updated_at' => $item->updated_at->toDateTimeString(),
                ];
            });
            $results[$productId] = $groupData;
        }
        return view('admin.trialitems.index', ['trailItems' => $results]);
    }

    public function store(Request $request)
    {
        $selectedProducts = $request->input('product', []);
        foreach ($selectedProducts as $productId) {
            $trialItem = new TrialItem();
            $trialItem->product_id = $request['productID'];
            $trialItem->trial_product_id = $productId;
            $trialItem->save();
        }

        session()->flash('message', '加入試搭成功');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        
    }
}
