<?php

namespace App\Http\Controllers;

use App\Models\Combination;
use App\Http\Requests\StoreCombinationRequest;
use App\Http\Requests\UpdateCombinationRequest;
use App\Models\Product;

class CombinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::all();

        return view('combinations.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('combinations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCombinationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Combination $combination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Combination $combination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCombinationRequest $request, Combination $combination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Combination $combination)
    {
        //
    }
}
