<?php

namespace App\Http\Controllers;

use App\Models\specification;
use App\Models\stock;
use App\Models\Product;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    public function store(Request $request)
    {
        //新增規格作業
        $productID = $request['product_id'];
        $specification = new specification();
        $specification->product_id = $productID;
        $specification->specification_type = $request['type'];
        $specification->name = $request['name'];
        $specification->save();

        //將該商品的所有規格都抓出來
        $specs = specification::Where('product_id' , '=' , $productID)->get();
        //新增庫存作業
        foreach($specs as $spec){
            //抓出不同類別的規格(如果新增的是顏色，就抓尺寸的)
            if($spec->specification_type != $specification->specification_type){
                $stock = new stock();
                $stock->product_id = $productID;
                if($specification->specification_type == "size"){
                    $stock->size = $specification->name;
                    $stock->color = $spec->name;
                }
                if($specification->specification_type == "color"){
                    $stock->color = $specification->name;
                    $stock->size = $spec->name;
                }
                $stock->stock = 5000;
                $stock->save();
            }
        }

        $product = Product::find($productID);
        session()->flash('message', '新增成功');
        return redirect(route('admin.product.adminShow' , ['product' => $product]));
    }

    public function destroy(Request $request)
    {
        $specificationID = $request['specification_id'];
        $productID = $request['product_id'];
        $specification = specification::find($specificationID);
        $specificationName = $specification->name;
        $specification->delete();

        $stocks = stock::Where('size' , '=' , $specificationName)
                        ->orWhere('color', '=', $specificationName)
                        ->get();
        foreach($stocks as $stock){
            if($stock->product_id == $productID){
                $stock->delete();
            }
        }
        
        $product = Product::find($productID);
        session()->flash('message', '刪除成功');      
        return redirect(route('admin.product.adminShow' , ['product' => $product]));
    }
}
