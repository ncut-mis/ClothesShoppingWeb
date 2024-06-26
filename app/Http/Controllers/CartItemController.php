<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth()->user()->id;
        $items = CartItem::with('product') 
                 ->where('user_id', $user_id)
                 ->paginate(10);
                 
        return view('Cartitem.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('sizes') && $request->has('colors')) {
            $sizes = $request->input('sizes');
            $colors = $request->input('colors');
            foreach ($sizes as $productId => $size) {
                $this->addToCart($request->user()->id, $productId, 1, $size, $colors[$productId]); // 假设数量默认为1
            }
         } 
        else {
            // 处理单个商品
            if($request->input('quantity') == ""){
                session()->flash('message', '請輸入數量');
                return redirect()->back();
            }
            $productId = $request->input('ProductID');
            $quantity = $request->input('quantity');
            $size = $request->input('size');
            $color = $request->input('color');
            $this->addToCart($request->user()->id, $productId, $quantity, $size, $color);
        }

        session()->flash('message', '加入購物車成功');
        return redirect(route('cartitem.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
         $cart_id = $request['CartID'];
         $cart = CartItem::find($cart_id);

         if($request->has('quantity')){
            $quantity = $request['quantity'];
            $cart->update([
                'quantity' => $quantity,
            ]);
            
            session()->flash('message', '修改數量成功');
            return back();
         }

         if($request->has('color')){
            $color = $request->input('color');
            $cart->color = $color;

            $cart->save();
            
            session()->flash('message', '修改顏色成功');
            return back();
         }  

         if($request->has('size')){
            $size = $request->input('size');
            $cart->size = $size;

            $cart->save();
            
            session()->flash('message', '修改尺寸成功');
            return back();
         }              
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $cart_id = $request['CartID'];
        $cart = CartItem::find($cart_id);
        $cart->delete();
        session()->flash('message', '移出購物車成功');
        return redirect(route('cartitem.index'));
    }

    protected function addToCart($userId, $productId, $quantity, $size, $color)
    {
        $cartItem = new CartItem();
        $cartItem->user_id = $userId;
        $cartItem->product_id = $productId;
        $cartItem->quantity = $quantity;
        $cartItem->size = $size;
        $cartItem->color = $color;
        $cartItem->save();
    }
}
