<?php

use App\Models\Product;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TrackedItemController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;

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
    return view('welcome');
});

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



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('Products', [ProductController::class, 'store'])->name('Products.store');
    Route::get('Products/{product}', [ProductController::class, 'show'])->name('Products.show');
    Route::get('Categorys/{category}', [CategoryController::class, 'show'])->name('Categorys.show');
    
});
Route::middleware('auth')->group(function () {
    Route::post('TrackedItem', [TrackedItemController::class, 'store'])->name('trackeditem.store');  
    Route::get('TrackedItem', [TrackedItemController::class, 'index'])->name('trackeditem.index');  
});


require __DIR__ . '/auth.php';
