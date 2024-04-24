<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Combination;
use App\Http\Requests\StoreCombinationRequest;
use App\Http\Requests\UpdateCombinationRequest;
use App\Models\Product;

class CombinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //global $data;
        $combinations = Combination::all();
        return view('combinations.index',compact('combinations'));
    }

    public function admin_index()
    {
        $combinations = Combination::all();
        return view('admin.combination.index', ['combinations' =>$combinations]);
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);

        $combination = new Combination();
        $combination->name = $validated['name'];
        $combination->price = $validated['price'];
        $combination->description = $validated['description'];
        $combination->category_id = $validated['category_id'];

        $combination->save();

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
