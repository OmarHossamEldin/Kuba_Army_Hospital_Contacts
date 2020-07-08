<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

          if(Auth::attempt(['username' => $validatedData['username'],'password' => $validatedData['password'] ])){
                $user = Auth::user();
                return redirect(route('User.dashboard'));
           }
           else{
               return back();
           }
    }

    public function dashboard()
    {
        return Inertia::render('User/Dashboard');
    }

    public function create()
    {
        return Inertia::render('User/create');
    }
    public function store(Request $request)
    {
        $validatedData=$request->validate([
                            'User'=>'required'
                        ]);
        foreach($request->User as $key=> $value ){
            if($value){
                continue;
            }
            else{
                return response()->json(['status'=>false,'result'=>'برجاء ادخال جميع البيانات',204 ]);
            }
        }
        User::create([
           'name' =>$validatedData['User']['name'],
           'username' =>$validatedData['User']['username'],
           'password' =>bcrypt($validatedData['User']['password']),
           'role'=>$validatedData['User']['type']
        ]);
        return response()->json(['status'=>true,'result'=>'تم انشاء المستخدم بنجاح',202  ]);
    }
}
