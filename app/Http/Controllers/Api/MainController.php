<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\City;
use App\Contact;
use App\Item;
use App\Offer;
use App\Region;
use App\Restaurant;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{

    public function cities(Request $request){
        $cities=City::where(function ($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }

        })->paginate(20);

        return responseJson(1,'success',$cities);
    }

    public function regions(Request $request){


       /* $regions=Region::where(function ($q) use($request){
            if ($request->has('name') ){
                $q->where('name','LIKE','%'.$request->name.'%');
            }

        })->where('city_id',$request->city_id)->with('city')->paginate(20);

        return responseJson(1,'success',$regions);*/


        if ($request->has('name') || $request->has('city_id') ){
            $regions=Region::where('name','LIKE','%'.$request->name.'%')->where('city_id',$request->city_id)->paginate(20);

            return responseJson(1,'success',$regions);
        }

        else{
            return responseJson(0,'fail');
        }

       /* if ($request->has('name') || $request->has('namee') ){

            $city=city::pluck($request->namee,'id');
            $regions=Region::where('name','LIKE','%'.$request->name.'%')->where('city_id',$city->id)->paginate(20);

            return responseJson(1,'success',$regions);
        }

        else{
            return responseJson(0,'fail','fail');
        }*/

    }

    public function categories(){

        $category=Category::all();

        return responseJson(1,'success',$category);
    }

    public function settings(){

        $setting=Setting::all();

        return responseJson(1,'success',$setting);
    }

    public function contacts(Request $request){
        $validation=validator()->make(
            $request->all(),[
                'name'=>'required',
                'phone'=>'required',
                'email'=>'required',
                'notes'=>'required',
                'status'=>'required|in:Complaint,Suggestion,Enquiry'

            ]
        );

        if ($validation->fails()){
            return responseJson(0,$validation->errors()->first());
        }

        $contact=Contact::create($request->all());

        return responseJson(1,'تم الحفط فى المحتوى ',$contact);
    }

    public function restaurants(Request $request){

        /*$validation=validator()->make($request->all(),[
            'city_id'=>'exists:cities,name',
        ]);

        if ($validation->fails()){
            return responseJson(0,$validation->errors()->first());
        }*/

        $restaurants=Restaurant::where(function ($q) use($request){
           if ($request->has('name')){


               $q->where('name','like','%'.$request->name.'%');

           }

            if ($request->has('region_id')){
                // $q->region->city()->where('name','like','%'.$request->name.'%');

                $q->where('region_id',$request->region_id);

            }
            if ($request->has('city')){
                 $q->whereHas('region',function ($q2) use($request){
                     $q2->whereHas('city',function ($q3) use($request){
                         $q3->where('cities.name',$request->city);
                     });
                 });


            }


            if ($request->has('region')){

                $q->whereHas('region',function ($q2) use($request){
                    $q2->where('regions.name',$request->region);

                });

            }


            if ($request->has('category')){
                $q->whereHas('categories',function ($q2) use($request){
                   $q2->where('categories.name',$request->category);
                });
            }

        })->has('items')->with('region.city','categories')->paginate(20);


        return responseJson(1,'كل المطاعم المطابقه للبحث',$restaurants);
    }


    public function restaurant(Request $request){

        $restaurant=Restaurant::with('region.city','categories')->find($request->restaurant_id);

        if ($restaurant){
            return responseJson(1,$restaurant->name,$restaurant);
        }
        else{
            return responseJson(0,'لايوجد مطاعم بهذه المعلومات');
        }


    }

    public function items(Request $request){

        $items=Item::whereHas('restaurant',function ($q) use ($request){
            $q->where('restaurants.name',$request->name);
        })->get();


       // $items=Item::where('restaurant_id',$request->restaurant_id)->get();
        if ($items){

            return responseJson(1,'عناصر ال مطعم',$items);

            //return responseJson(1,$items->name,$items);
        }
        else{
            return responseJson(0,'لايوجد وجبات بهذه المعلومات');
        }
    }

    public function offers(Request $request){

        $offers=Offer::whereHas('restaurant',function ($q) use ($request){

            if ($request->has('restaurant_id')){
                $q->where('restaurant_id',$request->restaurant_id);
            }

        })->has('restaurant')->with('restaurant')->paginate(20);

        if ($offers){

            return responseJson(1,'',$offers);
        }
        else{

            return responseJson(0,'no data');

        }
    }


    public function offer(Request $request){

        $offers=Offer::has('restaurant')->with('restaurant')->find($request->offer_id);

        if ($offers){

            return responseJson(1,'',$offers);
        }
        else{

            return responseJson(0,'no data');

        }
    }
}
