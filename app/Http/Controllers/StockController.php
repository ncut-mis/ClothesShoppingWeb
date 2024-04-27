<?php

namespace App\Http\Controllers;

use App\Models\stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function update( Request $request)
    {
        $stock = stock::find($request['stockID']);
        $stock->stock += $request['quantity'];
        $stock->save();

        session()->flash('message', '更新庫存成功');
        return back();
    }
}
