<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


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
        $categories = Category::paginate(10);

        return view('admin.category.index', ['categories' => $categories]);
    }

    public function create()
    {
        $categories = Category::where('category_id' , '=' , null)->get();
        return view('admin.category.create',['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = new Category();

        $category->name = $request['name'];
        $category->category_id  = $request['category_id'];
        $category->image_position = $request['image_position'];
        $category->is_shelf = 1;

        $category->save();

        return redirect()->route('admin.category.adminIndex');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $products = Product::Where('category_id', '=', $category->id)->paginate(8);

        $categories = Category::all();

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
    public function edit($id)
    {

        $categories = Category::find($id);
        $category = $categories;
        return view('admin.category.edit',compact('categories','category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:25',
        ]);
        $categories = Category::all();
        $categories->update($request->all());
        return redirect()->route('category.adminIndex');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $categoryID = $request['Category_ID'];
        $category = Category::find($categoryID);
        $category->delete();
        return redirect()->route('admin.category.adminIndex');
    }
}
