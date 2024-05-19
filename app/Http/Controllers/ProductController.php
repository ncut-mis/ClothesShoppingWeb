<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductPhoto;
use App\Models\Combination;
use App\Models\Category;
use App\Models\specification;
use App\Models\stock;
use App\Models\Order;
use App\Models\TrialItem;
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
        $products = Product::all();
        return view('product.index', ['products' =>$products]);
    }

    public function admin_index()
    {
        $products = Product::paginate(10);
        $categories = Category::all();
        return view('admin.product.index', ['products' =>$products , 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }
    
    public function photo($productID)
    {
        $product = Product::where('id', $productID)->first();
        $category_type = $product->Category->category_type;
        $photoUrl = asset('images/' . $product->firstPhoto->file_address);
        return response()->json([
            'category_type' =>  $category_type, // 或者只选取所需的产品信息
            'photoUrl' => $photoUrl
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //global $data;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);

        //$newProduct = Product::create($data);
        //return redirect(route('product.index'));

        $product = new Product();
        $product->name = $validated['name'];
        $product->stock = 0;
        $product->price = $validated['price'];
        $product->description = $validated['description'];
        $product->is_shelf = 1;
        $product->category_id = $validated['category_id'];

        $product->save();


        foreach ($request->file('images') as $image){
            $filename = $image->getClientOriginalName(); //待優化，有潛在問題
            $image->move(public_path('images'), $filename);

            $productphoto = new ProductPhoto();
            $productphoto->product_id = $product->id;
            $productphoto->file_address = $filename;
            $productphoto->save();
        }
        //$imageName = time() . '.' . $request->image->extension();
        //$request->image->move(public_path('images'), $imageName);



        return back()->with('success', 'You have successfully upload image.')->with('image', $filename);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //image可修改成取亂數隨機顯示商品圖片，也可取出所有圖片，也可在Model去定義圖片顯示方法
        $image = ProductPhoto::Where('product_id', '=', $product->id)->first();
        $combinations = Combination::Where('product_id', '=', $product->id)->paginate(2);
        $orders = Order::with('details')
            ->whereHas('details', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->where('status', 3)
            ->get();

        if (Auth::check()) {
            // 用戶已登入，使用 auth layout
            return view('product.show', ['product' => $product , 'combinations' => $combinations , 'orders'=> $orders , 'layout' => 'layouts.app']);
        } else {
            // 用戶未登入，使用 guest layout
            return view('product.show', ['product' => $product , 'combinations' => $combinations , 'orders'=> $orders , 'layout' => 'layouts.guest']);
        }
    }

    public function admin_show(Product $product)
    {
        //image可修改成取亂數隨機顯示商品圖片，也可取出所有圖片，也可在Model去定義圖片顯示方法
        $image = ProductPhoto::Where('product_id', '=', $product->id)->first();
        $combinations = Combination::Where('product_id', '=', $product->id)->paginate(10);
        $TrialItems = TrialItem::Where('product_id', '=', $product->id)->paginate(10);
        $stocks = stock::Where('product_id', '=', $product->id)->get();
        $specifications = specification::Where('product_id','=',$product->id)->get();

        return view('admin.product.show', ['product' => $product , 'combinations' => $combinations , 'stocks' => $stocks , 'TrialItems' => $TrialItems , 'specifications' => $specifications]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.edit',['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);

        $product -> update($validated);
        return redirect(route('product.index'))->with('success','Product Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product -> delete();
        return redirect(route('product.index'))->with('success','Product Deleted Successfully');
    }

    public function search(Request $request)
    {
        $exists = Product::Where('name', '=', $request['keyword'])->exists();
        $products = Product::Where('name', 'like', '%' . $request['keyword'] . '%')->paginate(8);
        $categories = Category::paginate(10, ['*'], 'categoryPage')
                          ->withQueryString();
        if ($exists) {
            if (Auth::check()){
                $layout = 'layouts.app';
                return view('home', compact('categories','products','layout'));
            }
            else{
                $layout = 'layouts.guest';
                return view('GuestHome', compact('categories','products','layout'));
            }
        } else {
            session()->flash('message', '查無商品');
            if (Auth::check()){
                $layout = 'layouts.app';
                return view('home', compact('categories','products','layout'));
            }
            else{
                $layout = 'layouts.guest';
                return view('GuestHome', compact('categories','products','layout'));
            }
        }
    }

    public function admin_search(Request $request)
    {
        $exists = Product::Where('name', '=', $request['keyword'])->exists();
        $products = Product::Where('name', 'like', '%' . $request['keyword'] . '%')->paginate(8);
        $categories = Category::paginate(10, ['*'], 'categoryPage')
                          ->withQueryString();
        if ($exists) {
            return view('admin.product.index', compact('categories','products'));
        } else {
            session()->flash('message', '查無商品');
            return view('admin.product.index', compact('categories','products'));
        }
    }

    public function type_search($categoryType)
    {
        $products = Product::whereHas('Category', function($query) use ($categoryType) {
            $query->where('category_type', '=', $categoryType);
        })->get();
        
        return response()->json($products);
    }

    public function TrialProuct_search(Request $request)
    {
        $exists = Product::Where('name', '=', $request['keyword'])->exists();
        $products = Product::Where('name', 'like', '%' . $request['keyword'] . '%')->get();

        return response()->json($products);
    }
}