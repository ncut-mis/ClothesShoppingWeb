<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
//use Facades\App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login()
    {
        if(View::exists('admin.auth.login'))
        {
            return view('admin.auth.login');
        }
        abort(Response::HTTP_NOT_FOUND);
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->except(['_token']);   //去除_token，只留email & password

        if($this->isAdminActive($request->email))    //先用isAdminActive()檢查帳號是否有作用
        {
            if(Auth::guard('admin')->attempt($credentials))
            {

                $request->session()->regenerate();

             
                return redirect(RouteServiceProvider::ADMIN);

            }
            // 若admin使用者身分驗證失敗，則重新進入本控制器的login()方法，並給帳號資料錯誤訊息
            return redirect()->action([
                LoginController::class,
                'login'
            ])->with('message','Credentials not matched in our records!');
        }
        // 若admin使用者身帳號失效，則重新進入本控制器的login()方法，並給帳號失效訊息
        return redirect()->action([
            LoginController::class,
            'login'
        ])->with('message','You are not an active admin!');
    }

    function isAdminActive($email) : bool
    {
        $admin= Admin::whereEmail($email)->isActive()->exists();

        return $admin ? true : false;
    }
}