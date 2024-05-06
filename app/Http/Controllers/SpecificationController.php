<?php

namespace App\Http\Controllers;

use App\Models\specification;
use App\Models\stock;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    public function store(Request $request)
    {
        $productID = $request['product_id'];
        $specification = new specification();
        $specification->product_id = $productID;
        $specification->specification_type = $request['type'];
        $specification->name = $request['name'];
        $specification->save();


        session()->flash('message', '新增成功');
        $referer = $request->headers->get('referer');
        
        return redirect()->to($referer);
        // $stock = new stock();
        // $stock->product_id = $productID ;
        // if($specification->specification_type == 'size')
        // {
        //     $stock->size = $specification->specification_type;
        // }
        // if($specification->specification_type == 'color')
        // {

        // }


    }

    public function destroy(Request $request)
    {
        $specificationID = $request['specification_id'];
        $specification = specification::find($specificationID);
        $specificationName = $specification->name;
        $specification->delete();
        $stocks = stock::Where('size' , '=' , $specificationName)
                        ->orWhere('color', '=', $specificationName)
                        ->get();
        foreach($stocks as $stock){
            $stock->delete();
        }
        session()->flash('message', '刪除成功');
        $referer = $request->headers->get('referer');
        
        return redirect()->to($referer);
    }
}
