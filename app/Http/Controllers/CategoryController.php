<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

     public function admin_index()
    {
        $items = Category::all();
                 
        return view('admin.category.index', ['items' => $items]);
    }
    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $products = Product::Where('category_id', '=', $category->id)->paginate(8);

        $categories = Category::paginate(10, ['*'], 'categoryPage')
                          ->withQueryString();

        // 返回一个视图，只包含服装数据列表
        if (Auth::check()) {
            $layout = 'layouts.app';
            return view('home', compact('categories','products','layout'));
        }
        else{
            $layout = 'layouts.guest';
            return view('GuestHome', compact('categories','products','layout'));
        }
    
    }

    public function admin_show($categoryID)
    {
        $categories = Category::all();

        $products = Product::where('category_id', $categoryID)->paginate(10);

        return view('admin.product.index', compact('categories','products'));       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
