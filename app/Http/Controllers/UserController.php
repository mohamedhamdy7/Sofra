<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function changePassword(){

        return view('User.changePassword');
    }

    public function changePasswordSave(Request $request){

        $messages = [
            'old-password' => 'required',
            'password' => 'required|confirmed',
        ];
        $rules = [
            'old-password.required' => 'كلمة السر الحالية مطلوبة',
            'password.required' => 'كلمة السر مطلوبة',
        ];

        $this->validate($request,$messages,$rules);

        $user =Auth::user();

        if (Hash::check($request->input('old-password'),$user->password)){

            $user->password=bcrypt($request->password);

            $user->save();
            flash()->success('تم تحديث كلمة المرور');

            return redirect(route('home'));        }
        else{
            flash()->error('كلمة المرور غير صحيحة');
            return view('User.changePassword');
        }

    }
}
