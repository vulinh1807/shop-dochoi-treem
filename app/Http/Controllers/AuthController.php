<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin;
use App\User;
use App\Roles;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\PseudoTypes\True_;

class AuthController extends Controller
{
    public function register_auth()
    {
    	return view('admin.custom_auth.register');
    }
    public function login_auth(){
        return view('admin.custom_auth.login_auth');
    }
    public function logout_auth(){
        Auth::logout();
        Session::forget('admin_name');
        Session::forget('admin_id');
        Session::forget('login_normal');
        return redirect('/admin')->with('message','Đăng xuất thành công');
    }
    public function login(Request $request){
        $this->validate($request,[
            'admin_name' => 'required', 
            'admin_password' => 'required'
        ]);
         $data = $request->all();
         if(Auth::attempt(array('name'=>$request->get('admin_name'),
         'password'=>$request->get('admin_password')))){
             return redirect('/dashboard');
        }else{
             //Session::flash('message',"Lỗi đăng nhập!");
             return redirect('/admin')->with('message',"Lỗi đăng nhập!");
        }
        // if(Auth::attempt(['name'=>$request->post('admin_name'),
        // 'password'=>$request->post('admin_password')])){
        //     return redirect('/dashboard');
        // }else{
        //     return redirect('/admin')->with('message','Loi dang nhap!');
        // }
    }
    public function register(Request $request)
    {
		$this->validation($request);
		$data = $request->all();
		$admin = new User();
		$admin->name = $data['admin_name'];
		$admin->email = $data['admin_email'];
		$admin->password = Hash::make($data['admin_password']);
        //$admin->password= $data['admin_password'];
		$admin->save();
		return redirect('/admin')->with('message','Đăng ký thành công');
    }
    public function validation($request){
    	return $this->validate($request,[
    		'admin_name' => 'required|max:255', 
    		'admin_phone' => 'required|max:255', 
    		'admin_email' => 'required|max:255', 
    		'admin_password' => 'required|max:255', 
    	]);
    }
}
