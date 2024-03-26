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

Route::get('/', function () {
    $products = Product::paginate(8); // 示例中随机取5件服装

    return view('GuestHome', compact('products'));
})->name('/');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', function () {
    // $cateGory = new Category();
    // $cateGory->name = '外套';
    // $cateGory->save();

    $products = Product::paginate(8); // 示例中随机取5件服装
    return view('home', compact('products'));


    // $cateGory = Category::find(11);
    // $cateGory->update([
    //     'name' => '卡其褲',
    // ]);
    // $cateGory->save();
    
})->middleware(['auth', 'verified'])->name('/home');


Route::get('Categorys/{category}', [CategoryController::class, 'show'])->name('Categorys.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('ProductSearch', [ProductController::class, 'search'])->name('Products.search');
Route::get('Products/{product}', [ProductController::class, 'show'])->name('Products.show');

Route::middleware('auth')->group(function () {   
    Route::post('Products', [ProductController::class, 'store'])->name('Products.store');    
});

Route::middleware('auth')->group(function () {
    Route::post('/TrackedItem', [TrackedItemController::class, 'store'])->name('trackeditem.store');
    Route::get('/TrackedItem', [TrackedItemController::class, 'index'])->name('trackeditem.index');
    Route::delete('/TrackedItem', [TrackedItemController::class, 'destroy'])->name('trackeditem.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/CartItem', [CartItemController::class, 'store'])->name('cartitem.store');
    Route::get('/CartItem', [CartItemController::class, 'index'])->name('cartitem.index');
    Route::patch('/CartItem', [CartItemController::class, 'update'])->name('cartitem.update');
    Route::delete('/CartItem', [CartItemController::class, 'destroy'])->name('cartitem.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/Order', [OrderController::class, 'index'])->name('order.index'); 
    Route::get('/OrderCreate', [OrderController::class, 'create'])->name('order.create'); 
    Route::post('/OrderStore', [OrderController::class, 'store'])->name('order.store');   
    Route::patch('/OrderCancel', [OrderController::class, 'cancel'])->name('order.cancel');  
});


require __DIR__ . '/auth.php';
