<?php

namespace App\Http\Controllers\Api\Restraunt;

use App\Client;
use App\Item;
use App\Offer;
use App\Order;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function AddItem(Request $request){

        $validation=validator()->make($request->all(),[
            'name'=>'required',
            'price'=>'required|numeric',
            'description'=>'required',
            'image'=>'mimes:jpg,jpeg,png',
            'prepare_time'=>'required',
        ]);

        if ($validation->fails()){
            return responseJson(0,$validation->errors()->first());
        }

        $items=$request->user()->items()->create($request->except('image'));


        if ($request->hasFile('image')){
            $path=public_path();
            $destination_path=$path.'/uploads/items/';
            $image=$request->file('image');
            $extention=$image->getClientOriginalExtension();
            $name=time().''.rand(1111,9999).'.'.$extention;
            $image->move($destination_path,$name);
            $items->image='uploads/items/' . $name;

            $items->save();
        }

        return responseJson(1,'تم الاضافة بنجاح',$items->load('restaurant'));

    }

    public function ShowItem(Request $request){

        $items=Item::where('restaurant_id',$request->user()->id)->latest()->paginate(20);
        return responseJson(1,'تم العرض بنجاح',$items);
    }

    /*public function ShowItem(Request $request)
    {
        $item = $request->user()->items()->enabled()->latest()->paginate(20);
        return responseJson(1,'تم التحميل',$item);
    }*/

    public function UpdateItem(Request $request){

        $validation=validator()->make($request->all(),[


            'price'=>'numeric',

            'image'=>'mimes:jpg,jpeg,png',

        ]);

        if ($validation->fails()){
            return responseJson(0,$validation->errors()->first());
        }

        $update=$request->user()->items()->find($request->id);

        if ($update){

            $update->update($request->except('image'));
            if ($request->hasFile('image')){

                $path=public_path();
                $destination_path=$path.'/uploads/items/';
                $image=$request->file('image');
                $extention=$image->getClientOriginalExtension();
                $name=time().''.rand(1111,9999).'.'.$extention;
                $image->move($destination_path,$name);
                $update->image='uploads/items/' . $name;

                $update->save();
            }

            return responseJson(1,'تم تعديل ال عناصر بنجاح',$update->fresh()->load('restaurant'));
        }

        else{
            return responseJson(0,'لا يمكن الحصول على البيانات');
        }




    }

    public function DeleteItem(Request $request){

        $delete=$request->user()->items()->find($request->id);

        if (!$delete){

            return responseJson(0,'NO items with this information');
        }


        $delete->delete();
        return responseJson(1,'تم الحذف بنجاح');

    }


    public function ShowInformation(Request $request){

        /*$validation=validator()->make($request->all(),[

            'restaurant_id'=>'required',
        ]);

        if ($validation->fails()){

            return responseJson(0,$validation->errors()->first());

        }*/

        $show = Restaurant::with('region.city')->find($request->restaurant_id);
        return responseJson(1,'information about Restraunt',$show);

      /* $show=Restaurant::select('id','status','min_price','delivery_cost')->where('id',$request->user()->id)->get();

        $region=$request->user()->region()->pluck('regions.name')->toArray();

        $city=$request->user()->region->city->pluck('cities.name');*/

        if ($show){

            return responseJson(1,"information about Restraunt",compact('show','region','city'));


        }
        else{

            return responseJson(0,"لا يوجد معلومات لنشرها ");

        }



    }

    public function AddOffer(Request $request){

        $validation=validator()->make($request->all(),[
            'name'=>'required',
            'price'=>'required|numeric',
            'description'=>'required',
            'image'=>'mimes:jpg,jpeg,png',
            'start_from'=>'required|date_format:Y-m-d',
            'end_at'=>'required|date_format:Y-m-d',
        ]);

        if ($validation->fails()){
            return responseJson(0,$validation->errors()->first());
        }

        $offer=$request->user()->offers()->create($request->all());

        if ($request->hasFile('image')){

            $path=public_path();
            $destination_path=$path.'/uploads/offers/';
            $image=$request->file('image');
            $extention=$image->getClientOriginalExtension();
            $name=time().''.rand(1111,9999).'.'.$extention;
            $image->move($destination_path,$name);
            $offer->update(['image'=>'/uploads/offers/'.$name]);
        }
        return responseJson(1,'تم الاضافة بنجاح',$offer->load('restaurant'));
    }



    public function ShowOffer(Request $request){

        $offers=Offer::where('restaurant_id',$request->user()->id)->with('restaurant')->get();

        //$offers=$request->user()->offers()->with('restaurant')->latest()->paginate(20);

        return responseJson(1,'my OFFERS',$offers);
    }


    public function UpdateOffer(Request $request){

        $validation=validator()->make($request->all(),[

            'price'=>'numeric',

            'image'=>'mimes:jpg,jpeg,png',

            'offer_id'=>'required|numeric'

        ]);

        if ($validation->fails()){
            return responseJson(0,$validation->errors()->first());
        }

         $offer=$request->user()->offers()->find($request->offer_id);

        //$offer=Offer::where('restaurant_id',$request->user()->id)->where('id',$request->offer_id)->first();
        if ($offer){

            $offer->update($request->except('image'));

            if ($request->hasFile('image')){

                if (file_exists($request->user()->image)) {
                    unlink($request->user()->image);
                }
                $path=public_path();
                $destinationPath=$path.'/uploads/offers/';
                $image=$request->file('image');
                $extension=$image->getClientOriginalExtension();
                $name=time().''.rand(111,999).'.'.$extension;
                $image->move($destinationPath,$name);
                $offer->update(['image'=>'/uploads/offers/'.$name]);
            }
            return responseJson(1,'تم التعديل بنجاح',$offer->load('restaurant'));
        }
        else{
            return responseJson(0,"لا يوجد عروض لهذه البيانات لتعديلها");
        }

    }

    public function DeleteOffer(Request $request){

        $offer=$request->user()->offers()->find($request->offer_id);

        if ($offer){
            $offer->delete();
            return responseJson(1,'تم الحذف بنجاح');
        }
        else{

            return responseJson(0,'لا يمكن الحصول على البيانات');
        }

    }



    public function myOrders(Request $request){
       $orders=$request->user()->orders()->where(function ($order) use($request){

           if ($request->has('status') and $request->status=='current'){

               $order->where('status','=','accepted');
           }
           elseif ($request->has('status') && $request->status=='pending'){

               $order->where('status','=','pending');
           }
           /*else{

               $order->where('status','deliverd');
           }*/
       })->with('client','items')->latest()->paginate(10);


       return responseJson(1,$request->status,$orders);

    }


    public function showOrder(Request $request){
        $order=Order::with('client','items')->find($request->order_id);

        return responseJson(1,$request->order_id,$order);
    }

    public function acceptOrder(Request $request){
       $order=$request->user()->orders()->find($request->order_id);

       if (!$order){
           return responseJson(0,'لايوجد طلبات بهذه البيانات');
       }
       elseif($order->status=='accepted'){
           return responseJson(1,'تم قبول الطلب ',$order);
       }
       else{
           $order->update(['status'=>'accepted']);

           $client=Client::find($order->client_id);

           //dd($client);
           $notification= $client->notifications()->create([
               'title'=>'تم قبول طلبك ',
               'content'=>'رقم طلبك'.$request->order_id,

           ]);



           $token=$client->tokens()->where('token', '!=' ,'')->pluck('token')->toArray();

           if (count($token)){
               public_path();
               $title = $notification->title;
               $content = $notification->content;
               $data =[
                   'order_id' => $order->id,
                   'user_type' => 'client',
               ];
               $send = notifyByFirebase($title , $content , $token,$data);
               info("firebase result: " . $send);

               return responseJson(1,'تم قبول الطلب');

           }

       }

    }


    public function rejectOrder(Request $request)
    {

        $order = $request->user()->orders()->find($request->order_id);

        if (!$order) {
            return responseJson(0, 'لايوجد طلبات بهذه البيانات');
        } elseif ($order->status == 'rejected') {

            return responseJson(1, 'تم رفض الطلب ', $order);
        } else {

            $order->update(['status' => 'rejected']);

            $client = Client::find($order->client_id);

            $notification = $client->notifications()->create([

                'title' => 'تم رفض طلبك ',
                'content' => 'رقم طلبك' . $request->order_id,

            ]);

            $token = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();

            if (count($token)) {
                //public_path();
                $title = $notification->title;
                $content = $notification->content;
                $data = [
                    'order_id' => $order->id,
                    'user_type' => 'client',
                ];
                $send = notifyByFirebase($title, $content, $token, $data);
                info("firebase result: " . $send);

                return responseJson(1, 'تم رفض الطلب');
            }

        }
    }


    public function confirmOrder(Request $request){

        $order = $request->user()->orders()->find($request->order_id);

        if (!$order) {
            return responseJson(0, 'لايوجد طلبات بهذه البيانات');
        }
        elseif ($order->status != 'accepted') {

            return responseJson(0,'لا يمكن تأكيد الطلب ، لم يتم قبول الطلب');
        }
        else {

            $order->update(['status' => 'deliverd']);

            $client = Client::find($order->client_id);

            $notification = $client->notifications()->create([

                'title' => 'تم تأكيد توصيل طلبك',
                'content' => 'رقم طلبك' . $request->order_id,

            ]);

            $token = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();

            if (count($token)) {
                //public_path();
                $title = $notification->title;
                $content = $notification->content;
                $data = [
                    'order_id' => $order->id,
                    'user_type' => 'client',
                ];
                $send = notifyByFirebase($title, $content, $token, $data);
                info("firebase result: " . $send);

                return responseJson(1, 'تم تأكيد الاستلام');
            }

        }


    }



    public function changeState(Request $request){
        $validation=validator()->make($request->all(),[
            'status'=>'required|in:open,close'
        ]);

        if ($validation->fails()){
            return responseJson(0,$validation->errors()->first());
        }

        $state=$request->user()->update(['status'=>$request->status]);

        return responseJson(1,$request->user(),$state);

    }

    public function commission(Request $request){
        $count=$request->user()->orders()->where('status','deliverd')->count();


        $total=$request->user()->orders()->where('status','deliverd')->sum('total');


        $comission=$request->user()->orders()->where('status','deliverd')->sum('comission');

        $pay_off=$request->user()->payments()->sum('pay_off');

        $remaining=$comission-$pay_off;

        return responseJson(1,'',compact('count','total','comission','pay_off','remaining'));

    }
}
