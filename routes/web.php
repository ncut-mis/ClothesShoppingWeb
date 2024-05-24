<?php

use App\Models\Product;
use App\Http\Controllers\Admin\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TrackedItemController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TrialItemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SpecificationController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Combination;
use App\Models\combinations_detail;

use App\Http\Controllers\CombinationController;

use App\Models\Order;
use App\Models\admin;
use App\Models\stock;


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
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        $categories = Category::all();
        $products = Product::paginate(8); // 示例中随机取5件服装
        $layout = 'layouts.guest';

        return view('GuestHome', compact('products','categories', 'layout'));

    })->name('/');
});

//訪客或會員皆可拜訪
    //選擇服裝類別
    Route::get('Categorys/{category}', [CategoryController::class, 'show'])->name('Categorys.show');
    //商品
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/productSearch', [ProductController::class, 'search'])->name('Products.search');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('Products.show');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

//測試用
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//會員首頁
Route::get('/home', function () {
     $categories = Category::all();
     $products = Product::with('firstPhoto')->paginate(8);
     $layout = 'layouts.app';

     return view('home', compact('products','categories', 'layout'));
})->middleware(['auth', 'verified'])->name('/home');



//會員
Route::middleware('auth')->group(function () {
    //會員中心
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //商品
    Route::post('products', [ProductController::class, 'store'])->name('Products.store');

    //追蹤清單
    Route::post('/TrackedItem', [TrackedItemController::class, 'store'])->name('trackeditem.store');
    Route::get('/TrackedItem', [TrackedItemController::class, 'index'])->name('trackeditem.index');
    Route::delete('/TrackedItem', [TrackedItemController::class, 'destroy'])->name('trackeditem.destroy');

    //購物車
    Route::post('/CartItem', [CartItemController::class, 'store'])->name('cartitem.store');
    Route::get('/CartItem', [CartItemController::class, 'index'])->name('cartitem.index');
    Route::patch('/CartItem', [CartItemController::class, 'update'])->name('cartitem.update');
    Route::delete('/CartItem', [CartItemController::class, 'destroy'])->name('cartitem.destroy');

    //訂單
    Route::get('/Order/{status}', [OrderController::class, 'index'])->name('order.index');
    Route::get('/OrderShow/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/OrderCreate', [OrderController::class, 'create'])->name('order.create');
    Route::post('/OrderStore', [OrderController::class, 'store'])->name('order.store');
    Route::patch('/OrderUpdate', [OrderController::class, 'update'])->name('order.update');
    Route::patch('/OrderComment', [OrderController::class, 'comment'])->name('order.comment');

    //搭配組合
    Route::get('/combination/{combination}',[CombinationController::class,'show'])->name('combination.show');
});


Route::middleware('auth')->group(function (){
    
    // 請放到管理員的group
    Route::get('/combination/{combination}',[CombinationController::class,'show'])->name('combination.show');

    Route::get('/admin/combination/search',[CombinationController::class,'search'])->name('combination.search');
    
    Route::get('/admin/combination/{combination}/edit',[CombinationController::class,'edit'])->name('combination.edit');
    Route::patch('/admin/combination/{combination}',[CombinationController::class,'update'])->name('combination.update');
    Route::delete('/admin/combination/destroy',[CombinationController::class,'destroy'])->name('combination.destroy');

});

//管理員登入
Route::name('admin.')->namespace('Admin')->prefix('admin')->group(function(){
    Route::namespace('Auth')->middleware('guest:admin')->group(function(){
        //login route
        Route::get('/login',[LoginController::class,'login'])->name('login');
        Route::post('/login',[LoginController::class,'processLogin']);
    });
    Route::namespace('Auth')->middleware('auth:admin')->group(function(){
        Route::post('/logout',function(Request $request){
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->action([
                LoginController::class,
                'login'
            ]);
        })->name('logout');
    });
});

//管理員
Route::middleware('auth:admin')->name('admin.')->prefix('admin')->group(function(){
    Route::get('/home', function () {
        return view('admin.home');
    })->name('home');
    //商品
    Route::get('/Product', [ProductController::class, 'admin_index'])->name('product.adminIndex');
    Route::get('/Product/{product}', [ProductController::class, 'admin_show'])->name('product.adminShow');
    Route::get('/ProductSearch', [ProductController::class, 'admin_search'])->name('product.adminSearch');
    Route::get('/AllProduct/{productID}' , [ProductController::class, 'AllData'])->name('product.allData');
    Route::get('/Photo/{productID}' , [ProductController::class, 'photo'])->name('product.photo');
    Route::patch('/StockUpdate', [StockController::class, 'update'])->name('stock.update');
    Route::get('/Combination', [CombinationController::class, 'admin_index'])->name('combination.adminIndex');
    Route::get('/CombinationSearch', [CombinationController::class, 'admin_search'])->name('combination.adminSearch');

    //訂單
    Route::get('/Orderlist/{status}', [OrderController::class, 'admin_index'])->name('order.adminIndex');
    Route::get('/Order/{order}', [OrderController::class, 'admin_show'])->name('order.adminShow');

    //類別
    Route::get('/Category', [CategoryController::class, 'admin_index'])->name('category.adminIndex');
    Route::get('/CategoryShow/{categoryID}', [CategoryController::class, 'admin_show'])->name('category.adminShow');
    Route::get('/Category/create',[CategoryController::class,'create'])->name('category.create');
    Route::post('/Category',[CategoryController::class,'store'])->name('category.store');
    Route::get('/Category/{categoryID}',[CategoryController::class,'edit'])->name('category.edit');
    Route::patch('/Category/{categoryID}',[CategoryController::class,'update'])->name('category.update');
    Route::delete('/Category',[CategoryController::class,'destroy'])->name('category.destroy');  

    // 試搭
    Route::get('/TrialItem/{productID}',[TrialItemController::class, 'create'])->name('trialitem.create');
    Route::get('/TrialItem/{productID}/edit' , [TrialItemController::class,'edit'])->name('trialitem.edit');
    Route::patch('/TrialItem/{productID}',[TrialItemController::class,'update'])->name('trialitem.update');
    Route::post('/TrialItem',[TrialItemController::class, 'store'])->name('trialitem.store');
    Route::delete('/TrialItemDelete',[TrialItemController::class, 'destroy'])->name('trialitem.destroy');

    //試搭商品種類選擇
    Route::get('/ProductTypeSearch/{categoryType}',[ProductController::class, 'type_search'])->name('product.typesearch');
    Route::post('/TrialProuctSearch',[ProductController::class, 'TrialProuct_search'])->name('product.TrialProuctSearch');
    
    //規格管理
    Route::post('/Specification',[SpecificationController::class, 'store'])->name('specification.store');
    Route::delete('/Specification',[SpecificationController::class, 'destroy'])->name('specification.destroy');
    

    //人員管理
    Route::get('/Adminlist',[AdminController::class, 'index'])->name('adminlist.index');
    Route::get('/AdminCreate',[AdminController::class, 'create'])->name('admin.create');
    Route::post('/Admin',[AdminController::class, 'store'])->name('admin.store');
    Route::delete('/Admin',[AdminController::class, 'destroy'])->name('admin.destroy');

    // 搭配組合
    Route::get('/Combination/create/{product}',[CombinationController::class,'create'])->name('combination.create');
    Route::post('/combination',[CombinationController::class,'store'])->name('combination.store');
});




require __DIR__ . '/auth.php';
