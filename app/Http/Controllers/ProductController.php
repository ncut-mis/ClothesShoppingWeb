<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);



        $product = new Product();
        $product->name = $validated['name'];
        $product->stock = 0;
        $product->price = $validated['price'];
        $product->description = $validated['description'];
        $product->is_shelf = 1;
        $product->category_id = $validated['category_id'];

        $product->save();

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $productphoto = new ProductPhoto();
        $productphoto->product_id = $product->id;
        $productphoto->file_address = $imageName;

        $productphoto->save();

        return back()->with('success', 'You have successfully upload image.')->with('image', $imageName);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function search(Request $request)
    {
        $exists = Product::Where('name', '=', $request['keyword'])->exists();
        $products = Product::Where('name', 'like', '%' . $request['keyword'] . '%')->paginate(8);
        if ($exists) {
            if (Auth::check()){
                return view('home', compact('products'));
            }
            else{
                return view('GuestHome', compact('products'));
            }
        } else {
            session()->flash('message', '查無商品');
            if (Auth::check()){
                return view('home', compact('products'));
            }
            else{
                return view('GuestHome', compact('products'));
            }
        }


    }
}
