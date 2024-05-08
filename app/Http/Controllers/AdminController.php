<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function index(){
        $admins = admin::all();
        return view('admin.adminlist.index',['admins' => $admins]);
    }    

    public function create(){
        return view('admin.adminlist.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        $admin = new admin(); 
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        
        $admin->save();

        session()->flash('message', '新增人員成功');
        $admins = admin::all();
        return view('admin.adminlist.index',['admins' => $admins]);
    }
}
