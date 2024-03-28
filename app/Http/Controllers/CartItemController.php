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
        $cartitem = new CartItem();
        $cartitem->user_id = Auth()->user()->id;
        $cartitem->product_id = $request['ProductID'];
        $cartitem->quantity = $request['quantity'];
        $cartitem->save();

        session()->flash('message', '加入購物車成功');
        return redirect(route('Products.show', ['product' => $cartitem->product_id]));

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
         $quantity = $request['quantity'];
         $cart = CartItem::find($cart_id);
         $cart->update([
             'quantity' => $quantity,
         ]);
         $cart->save();
         
         session()->flash('message', '修改數量成功');
         return redirect(route('cartitem.index'));
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
}
