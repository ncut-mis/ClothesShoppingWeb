<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;

class AdminController extends Controller
{
    public function index(){
        $admins = admin::all();
        return view('admin.adminlist.index',['admins' => $admins]);
    }    
}
