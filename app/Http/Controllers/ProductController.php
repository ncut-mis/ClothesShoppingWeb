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
        $products = Product::Where('is_shelf', '=', 1) - get();
        return view('product.index', ['products' => $products]);
    }

    public function admin_index()
    {
        $products = Product::paginate(10);
        $categories = Category::all();
        return view('admin.product.index', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function admin_create()
    {
        $categories = Category::all();

        return view('admin.product.create', [
            'categories' => $categories
        ]);
        //return view('admin.product.create');
    }

    public function admin_storestore(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photos'      => 'nullable|array|max:5',
            'photos.*'    => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $product = Product::create([
            'name'        => $validated['name'],
            'stock'       => 0,
            'price'       => $validated['price'],
            'description' => $validated['description'],
            'is_shelf'    => 1, // 預設上架
            'category_id' => $validated['category_id'],
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $timestamp = now()->format('YmdHisv');
                    $extension = $photo->getClientOriginalExtension();
                    $newFileName = $timestamp . '.' . $extension;

                    // 將圖片儲存到 storage/app/public/product_photos/
                    $destinationPath = public_path('images');
                    $photo->move($destinationPath, $newFileName);

                    // 建立照片紀錄
                    \App\Models\ProductPhoto::create([
                        'product_id'   => $product->id,
                        'file_address' => $newFileName,
                    ]);
                }
            }
        }
        return redirect('/admin/product/list')->with('success', '商品新增成功！');
    }

    public function adminSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        $categoryId = $request->input('category_id');

        $query = Product::with(['firstPhoto', 'Category']);

        // 關鍵字搜尋（針對名稱與描述）
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // 類別篩選（若有選擇）
        if (!empty($categoryId) && intval($categoryId) !== 0) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->paginate(8)->appends([
            'keyword' => $keyword,
            'category_id' => $categoryId,
        ]);

        // 把所有類別抓來讓篩選可以保留原選項
        $categories = \App\Models\Category::all();

        return view('admin.product.index', compact('products', 'categories'));
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


        foreach ($request->file('images') as $image) {
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

    public function admin_store(Request $request)
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


        foreach ($request->file('images') as $image) {
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
        $product->load('productPhoto');
        //image可修改成取亂數隨機顯示商品圖片，也可取出所有圖片，也可在Model去定義圖片顯示方法
        $image = ProductPhoto::Where('product_id', '=', $product->id)->first();
        $combinations = Combination::Where('product_id', '=', $product->id)
            ->where('is_shelf', '=', 1)
            ->get();

        // 回傳跟目前所在商品有關連的訂單而且已完成的訂單
        $orders = Order::with('details')
            ->whereHas('details', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->where('status', 4)
            ->get();

        if (Auth::check()) {
            // 用戶已登入，使用 auth layout
            return view('product.show', ['product' => $product, 'combinations' => $combinations, 'orders' => $orders, 'layout' => 'layouts.app']);
        } else {
            // 用戶未登入，使用 guest layout
            return view('product.show', ['product' => $product, 'combinations' => $combinations, 'orders' => $orders, 'layout' => 'layouts.guest']);
        }
    }

    public function admin_show(Product $product)
    {
        //image可修改成取亂數隨機顯示商品圖片，也可取出所有圖片，也可在Model去定義圖片顯示方法
        $image = ProductPhoto::Where('product_id', '=', $product->id)->first();
        $combinations = Combination::Where('product_id', '=', $product->id)->paginate(10);
        $TrialItems = TrialItem::Where('product_id', '=', $product->id)->paginate(10);
        $stocks = stock::Where('product_id', '=', $product->id)->get();
        $specifications = specification::Where('product_id', '=', $product->id)->get();
        $photos = ProductPhoto::where('product_id', $product->id)->get(); // ✅ 加這行


        return view('admin.product.show', [
            'product' => $product,
            'combinations' => $combinations,
            'stocks' => $stocks,
            'TrialItems' => $TrialItems,
            'specifications' => $specifications,
            'photos' => $photos,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $photos = $product->productPhotos;

        return view('admin.product.edit', [
            'product' => $product,
            'categories' => $categories,
            'photos' => $photos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //die('in update');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ]);

        $product->update($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $timestamp = now()->format('YmdHisv'); // 例如 20240526230015999（包含毫秒）
                    $extension = $photo->getClientOriginalExtension(); // 取得副檔名
                    $newFileName = $timestamp . '.' . $extension;

                    // 將圖片儲存到 storage/app/public/product_photos/
                    $destinationPath = public_path('images');
                    $photo->move($destinationPath, $newFileName);

                    // 寫入資料庫
                    \App\Models\ProductPhoto::create([
                        'product_id'   => $product->id,
                        'file_address' => $newFileName, // 儲存相對於 storage 的路徑
                    ]);
                }
            }
        }

        return redirect()->route('admin.product.edit', ['product' => $product->id])->with('success', '商品更新成功');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.product.adminIndex')->with('success', 'Product Deleted Successfully');

    }

    public function photoDestroy($id)
    {
        $photo = ProductPhoto::findOrFail($id);
        $filePath = public_path('images/' . $photo->file_address);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        // 刪除資料表紀錄
        $photo->delete();
        return response()->json(['status' => 'success']);
    }

    public function search(Request $request)
    {
        $exists = Product::Where('name', 'like', '%' . $request['keyword'] . '%')->exists();
        $products = Product::Where('name', 'like', '%' . $request['keyword'] . '%')->paginate(8);
        $categories = Category::paginate(10, ['*'], 'categoryPage')
            ->withQueryString();
        if ($exists) {
            if (Auth::check()) {
                $layout = 'layouts.app';
                return view('home', compact('categories', 'products', 'layout'));
            } else {
                $layout = 'layouts.guest';
                return view('GuestHome', compact('categories', 'products', 'layout'));
            }
        } else {
            session()->flash('message', '查無商品');
            if (Auth::check()) {
                $layout = 'layouts.app';
                return view('home', compact('categories', 'products', 'layout'));
            } else {
                $layout = 'layouts.guest';
                return view('GuestHome', compact('categories', 'products', 'layout'));
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
            return view('admin.product.index', compact('categories', 'products'));
        } else {
            session()->flash('message', '查無商品');
            return view('admin.product.index', compact('categories', 'products'));
        }
    }

    public function type_search($categoryType)
    {
        $products = Product::whereHas('Category', function ($query) use ($categoryType) {
            $query->where('category_id', '=', $categoryType + 1);
        })->get();

        return response()->json($products);
    }

    public function TrialProuct_search(Request $request)
    {
        $exists = Product::Where('name', '=', $request['keyword'])->exists();
        $products = Product::Where('name', 'like', '%' . $request['keyword'] . '%')->get();

        return response()->json($products);
    }

    public function launch(Request $request)
    {
        $productID = $request['productID'];
        $product = Product::find($productID);
        $product->is_shelf = 1;
        $product->save();

        session()->flash('message', '上架成功');
        return back();
    }

    public function stop(Request $request)
    {
        $productID = $request['productID'];
        $product = Product::find($productID);
        $product->is_shelf = 0;
        $product->save();

        session()->flash('message', '下架成功');
        return back();
    }
}
