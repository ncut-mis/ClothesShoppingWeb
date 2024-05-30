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
            'FirstName' => ['required', 'string', 'max:255'],
            'LastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', Rules\Password::defaults()],
        ], $this->messages());
    
        $admin = new admin(); 
        $admin->FirstName = $request->FirstName;
        $admin->LastName = $request->LastName;
        $admin->title = $request->title;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->is_blocked = 0;
        $admin->save();
        
        session()->flash('message', '新增人員成功');
        return redirect(route('admin.adminlist.index'));
    }

    public function destroy(Request $request)
    {
        $adminID = $request['adminID'];
        $admin = admin::find($adminID);
        $admin->delete();

        session()->flash('message', '刪除成功');
        return redirect(route('admin.adminlist.index'));
    }

    protected function messages()
    {
        return [
            'FirstName.required' => '請填寫名字。',
            'LastName.required' => '請填寫姓氏。',
            'email.required' => '請填寫電子郵件。',
            'email.email' => '請輸入有效的電子郵件地址。',
            'email.unique' => '該電子郵件已被使用。',
            'password.required' => '請填寫密碼。',
        ];
    }
}
