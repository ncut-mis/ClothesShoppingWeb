<?php

use App\Models\Product;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TrackedItemController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Combination;
use App\Models\combinations_detail;

use App\Http\Controllers\CombinationController;

use App\Models\Order;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//訪客首頁
Route::get('/', function () {
    $categories = Category::paginate(10, ['*'], 'categoryPage')
                          ->withQueryString();
    $products = Product::paginate(8); // 示例中随机取5件服装

    return view('GuestHome', compact('products','categories'));

})->name('/');

//測試用
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//會員首頁
Route::get('/home', function () {   
     $categories = Category::paginate(10, ['*'], 'categoryPage')
                          ->withQueryString();
     $products = Product::with('firstPhoto')->paginate(8);
     return view('home', compact('products','categories'));
})->middleware(['auth', 'verified'])->name('/home');

//平台人員首頁
Route::get('/adminHome',function(){
    return view('adminHome');
})->middleware(['auth', 'verified', 'is_admin'])->name('/adminHome');

//選擇服裝類別
Route::get('Categorys/{category}', [CategoryController::class, 'show'])->name('Categorys.show');

//會員中心
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//商品
Route::middleware('auth')->group(function () {
    Route::post('products', [ProductController::class, 'store'])->name('Products.store');
});

//追蹤清單
Route::middleware('auth')->group(function () {
    Route::post('/TrackedItem', [TrackedItemController::class, 'store'])->name('trackeditem.store');
    Route::get('/TrackedItem', [TrackedItemController::class, 'index'])->name('trackeditem.index');
    Route::delete('/TrackedItem', [TrackedItemController::class, 'destroy'])->name('trackeditem.destroy');
});

//購物車
Route::middleware('auth')->group(function () {
    Route::post('/CartItem', [CartItemController::class, 'store'])->name('cartitem.store');
    Route::get('/CartItem', [CartItemController::class, 'index'])->name('cartitem.index');
    Route::patch('/CartItem', [CartItemController::class, 'update'])->name('cartitem.update');
    Route::delete('/CartItem', [CartItemController::class, 'destroy'])->name('cartitem.destroy');
});

//訂單
Route::middleware('auth')->group(function () {
    Route::get('/Order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/OrderCreate', [OrderController::class, 'create'])->name('order.create');
    Route::post('/OrderStore', [OrderController::class, 'store'])->name('order.store');
    Route::patch('/OrderCancel', [OrderController::class, 'cancel'])->name('order.cancel');
});

//搭配組合
Route::middleware('auth')->group(function (){
    Route::get('/combinations',[CombinationController::class,'index'])->name('combinations.index');
    Route::get('/combinations/create',[CombinationController::class,'create'])->name('combinations.create');
    Route::get('/combinations/search',[CombinationController::class,'search'])->name('combinations.search');
    Route::post('/combinations',[CombinationController::class,'store'])->name('combinations.store');
    Route::get('/combinations/{combination}/edit',[CombinationController::class,'edit'])->name('combinations.edit');
    Route::patch('/combinations/{combination}',[CombinationController::class,'update'])->name('combinations.update');
    Route::delete('/combinations/destroy',[CombinationController::class,'destroy'])->name('combinations.destroy');

});

//商品
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('productSearch', [ProductController::class, 'search'])->name('Products.search');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');
Route::get('products/{product}', [ProductController::class, 'show'])->name('Products.show');
Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{product}/update', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

require __DIR__ . '/auth.php';
