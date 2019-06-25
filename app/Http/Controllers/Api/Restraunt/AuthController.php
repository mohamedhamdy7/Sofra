<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Mail\ResetPassword;

use App\Restaurant;
use App\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    public function register(Request $request){
        $validation=validator()->make($request->all(),[
            'name'=>'required',
            'email'=>'required|unique:restaurants',
            'password'=>'required|confirmed',
            'phone'=>'required|unique:restaurants',
            'whatsapp'=>'required|unique:restaurants',
            'min_price'=>'required',
            'delivery_cost'=>'required',
            'region_id'=>'required|exists:regions,id',
            'categories'=>'required|array|exists:categories,id',
            'image'=>'required|mimes:jpg,png',
            'status'=>'required|in:open,close',
            'delivery_way'=>'required'
        ]);
        if ($validation->fails()){
            return responseJson(0,$validation->errors()->first());
        }

       // $request->merge(['password'=>bcrypt($request->password)]);
        //$request->merge(['api_token'=> str_random(60)]);
        $request->merge(['password'=>bcrypt($request->password)]);
        $restaurant=Restaurant::create($request->all());

        $restaurant->categories()->sync($request->categories);

        if ($request->hasFile('image')){

            $path = public_path();
            $destinationPath = $path . '/uploads/restaurants/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $restaurant->update(['image' => 'uploads/restaurants/' . $name]);

        }
        $restaurant->api_token=str_random(60);
        $restaurant->save();
        $data=[
            'api_token'=>$restaurant->api_token,
            'restaurant'=>$restaurant->load('region','categories')
        ];
        return responseJson(1,'تم الاضافه بنجاح',$data);

    }

    public function login(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'password' => 'required',
            'email' => 'required',
        ]);
        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first());
        }

        $restraunt=Restaurant::where('email',$request->email)->first();

        if ($restraunt){
            if (Hash::check($request->password,$restraunt->password)){
                return responseJson(1,'تم التسجيل بنجاح',['api_token'=>$restraunt->api_token]);
            }
            else{
                return responseJson(0, 'يوجد خطأ فى كلمه السر');
            }
        }
        else{

            return responseJson(0, 'يوجد خطأ فى الايميل');

        }

    }

    public function update(Request $request){

        $validation=validator()->make($request->all(),[
            'password'=>'confirmed',

            'categories'=>'array|exists:categories,id',

            'region_id'=>'exists:regions,id',

            'email'=>Rule::unique('restaurants')->ignore($request->user()->id),

            'phone'=>Rule::unique('restaurants')->ignore($request->user()->id),

            //'whatsapp'=>Rule::unique('restaurants')->ignore('$request->user()->id'),
        ]);
        if ($validation->fails()){
            return responseJson(0,$validation->errors()->first());
        }

        $loginUser = $request->user();

        $loginUser->update($request->except('image'));

        if ($request->has('password')){

            $loginUser->password = bcrypt($request->password);
        }

        if ($request->has('categories')){

            $loginUser->sync($request->categories);

        }

        if ($request->hasFile('image')) {

            if (file_exists($loginUser->image)) {
                unlink($loginUser->image);
            }

            $path = public_path();
            $destinationPath = $path . '/uploads/restaurants/'; // upload path
            $logo = $request->file('image');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path

            $loginUser->update(['image' => 'uploads/restaurants/' . $name]);
        }

            $loginUser->save();

        $data=[
            'restraunt'=>$loginUser->fresh()->load('region','categories')
        ];

        return responseJson('1','success UPDATE',$data);
    }




    public function forgetPass(Request $request)
    {

        $validation = validator()->make($request->all(), [
            'email' => 'required',
        ]);
        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first());
        }

        $restraunt = Restaurant::where('email', $request->email)->first();

        if ($restraunt) {

            $code = str_random(40);

            $update = $restraunt->update(['pin_code' => $code]);


            if ($update) {
                Mail::to($restraunt->email)
                    ->bcc("ahmedrakha10000@gmail.com")
                    ->send(new ResetPassword($code));
                return responseJson(1, 'برجاء فحص ايميلك', ['pin_code' => $code]);
            } else {

                return responseJson(0, 'error');
            }
        }else{
                return responseJson(0, ' email is error ,plz sure your email');
            }

    }




    public function newpass(Request $request){

        $validation=validator()->make($request->all(),[

            'pin_code'=>'required',

            'password'=>'confirmed',
        ]);

        if ($validation->fails()){
            return responseJson(0,$validation->errors()->first());
        }

        $restraunt=Restaurant::where('pin_code',$request->pin_code)->where('pin_code','!=','')->first();

        if ($restraunt){

            $update=$restraunt->update(['password'=>bcrypt($request->password),'pin_code'=>null]);

            if ($update){

                return responseJson(1,'تم تغيير الكلمه بنجاح');
            }
            else{
                return responseJson(0,'يوجد مشكله فى تغيير كلمه السر ');
            }
        }
        else{
            return responseJson(0,'تاكد من الكود ');
        }
    }






    public function registerToken(Request $request){

        $validation = validator()->make($request->all(), [
            'type'  => 'required|in:android,ios',
            'token' => 'required',
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        Token::where('token',$request->token)->delete();

        $data= $request->user()->tokens()->create($request->all());

        return responseJson(1,'success token',$data);



    }

    public function removeToken(Request $request){

        $validation=validator()->make($request->all(),[

            'token'=>'required',
        ]);

        if ($validation->fails()){

            return responseJson(0,$validation->errors()->first());

        }

        Token::where('token',$request->token)->delete();

        return responseJson(1,'Token Deleted');
    }


}
