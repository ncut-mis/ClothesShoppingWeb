<?php

namespace App\Http\Controllers;

use App\Models\Tracked_item;
use App\Http\Requests\StoreTracked_itemRequest;
use App\Http\Requests\UpdateTracked_itemRequest;
use Illuminate\Http\Request;

class TrackedItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth()->user()->id;
        $items = Tracked_item::where('user_id', '=', $user_id)->paginate(10);
        return view('TrackedItem.index',compact('items'));
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
        $ProductID = $request['ProductID'];
        if(Tracked_item::Where('product_id','=','$ProductID')->exists()){
            session()->flash('message', '追蹤失敗，該商品已被追蹤');
            return redirect(route('Products.show', ['product' => $ProductID]));
        }
        else{           
            $TrackedItem = new Tracked_item();
            $TrackedItem->user_id = Auth()->user()->id;
            $TrackedItem->product_id = $ProductID;
    
    
            $TrackedItem->save();
            session()->flash('message', '追蹤成功');
            return redirect(route('Products.show', ['product' => $ProductID]));
        }
        

    }

    /**
     * Display the specified resource.
     */
    public function show(Tracked_item $tracked_item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tracked_item $tracked_item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTracked_itemRequest $request, Tracked_item $tracked_item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $track_id = $request['Track_ID'];
        $track = Tracked_item::find($track_id);
        $track->delete();

        session()->flash('message', '解除追蹤成功');
        return redirect(route('trackeditem.index'));

    }
}
