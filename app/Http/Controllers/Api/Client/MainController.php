<?php

namespace App\Http\Controllers\Api\Client;

use App\Item;
use App\Order;
use App\Restaurant;
use App\Setting;
use App\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    /*public function newOrder(Request $request){
        $validation=validator()->make($request->all(),[
            'restaurant_id'=>'required',
            'address'=>'required',
            'items.*.item_id'=> 'required|exists:items,id',
            'items.*.quantity'=> 'required',
            'items.*.notes'=> 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first());
        }

        $restaurant=Restaurant::find($request->restaurant_id);

        $order=$request->user()->orders()->create([
            'restaurant_id'=>$request->restaurant_id,
            'address'=>$request->address,
            'order_number'=>rand(11111,99999),
            'status'=>'pending',
            'client_phone'=>$request->client_phone,

        ]);

        $cost=0;

        $delivery_cost=$restaurant->delivery_cost;

        foreach ($request->items as $i)
        {
            $y=$i[item_id];
            $item=Item::find($y);

            $readyItem=[
                $i[item_id]=>[
                    'quantity'=>$i[quantity],
                    'notes'=>isset($i[notes]) ?$i[notes] :"",
                    'price'=>$item->price,

                ]
            ];

            $order->items()->attach($readyItem);

            $cost+=($item->price*$i[quantity]);

        }

        if ($cost>$restaurant->min_price){

                $total=$cost+$delivery_cost;

                $comission=($cost*(Setting::find(1))->comission);

                $update=$order->update([
                    'total'=>$total,
                    'comission'=>$comission,

                ]);

            $restaurant->notifications()->create([
                'title'=>'لديك طلب جديد',
                'content'=>$request->user()->name."يوجد لديك طلب من ال عميل",
                'order_id'=>$order->id,
            ]);


            $tokens=$restaurant->tokens()->where('token','!=','')->pluck('token')->toArray();

            if (count($tokens)){

            }

            $data=$order->fresh()->load('items','client','restaurant.categories','restaurant.region.city');

            return responseJson(1,'تم الطلب بنجاح',$data);
            }
            else{
                $order->items()->delete();
                $order->delete();
            }










    }*/

    public function newOrder(Request $request){

        $validation = validator()->make($request->all(), [
            'restaurant_id'     => 'required|exists:restaurants,id',
           // 'items'             => 'required|array',
            'items.*'           => 'required|exists:items,id',
            'quantities'        => 'required|array',
            'notes'             => 'required|array',
            'address'           => 'required',


        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $restaurant = Restaurant::find($request->restaurant_id);

        if ($restaurant->status == 'closed') {
            return responseJson(0, 'عذرا المطعم غير متاح في الوقت الحالي');
        }

        $order =$request->user()->orders()->create([
            'restaurant_id'     => $request->restaurant_id,
            'notes'              => $request->note,
            'state'             => 'pending', // db default
            'address'           => $request->address,
            'client_phone'   =>$request->client_phone,


        ]);
        $cost = 0;

        $delivery_cost = $restaurant->delivery_cost;

        if ($request->has('items')) {
            $counter = 0;
            foreach ($request->items as $itemId) {
                $item = Item::find($itemId);
                $order->items()->attach([
                    $itemId => [
                        'quantity' => $request->quantities[$counter],
                        'price'    => $item->price,
                        'notes'     => $request->notes[$counter],
                    ]
                ]);
                $cost += ($item->price * $request->quantities[$counter]);
                $counter++;
            }
        }
        if ($cost >= $restaurant->min_price) {
            $total = $cost + $delivery_cost;
            $comission=($cost*(Setting::find(1))->comission);

            $net = $total - $comission;


            /*$update = $order->update([


                'total'         => $total,
                'comission'    => $comission,
                'net'           => $net,
            ]);*/
            $order->total=$total;

            $order->comission=$comission;

            $order->net=$net;

            $order->save();

            //$request->user()->cart()->detach();
            //Notificatios
            $notification = $restaurant->notifications()->create([
                'title' =>'لديك طلب جديد',
                'content' =>$request->user()->name .  'لديك طلب جديد من العميل ',


            ]);
            $tokens = $restaurant->tokens()->where('token', '!=' ,'')->pluck('token')->toArray();
            //info("tokens result: " . json_encode($tokens));
            if(count($tokens))
            {
                public_path();
                $title = $notification->title;
                $content = $notification->content;
                $data =[
                    'order_id' => $order->id,
                    'user_type' => 'restaurant',
                ];
                $send = notifyByFirebase($title , $content , $tokens,$data);
                info("firebase result: " . $send);
            }
            /* notification */
            $data = [
                'order' => $order->fresh()->load('items','restaurant.region','restaurant.categories','client') // $order->fresh()  ->load (lazy eager loading) ->with('items')
            ];
            return responseJson(1, 'تم الطلب بنجاح', $data);
        } else {
            $order->items()->delete();
            $order->delete();
            return responseJson(0, 'الطلب لابد أن لا يكون أقل من ' . $restaurant->minimum_charger . ' ريال');
        }
    }

    public function myOrder(Request $request){

        $orders=$request->user()->orders()->where(function ($order) use($request){
            if ($request->has('status')&& $request->status=='completed'){
                $order->where('status','!=','pending');
            }
            elseif ($request->has('status')&& $request->status=='current'){

                $order->where('status','pending');
            }

        })->with('items','client','restaurant.region')->latest()->paginate(20);


        return responseJson(1,'All My Orders',$orders);

    }
    public function showOrder(Request $request){
        $order=Order::with('items','client','restaurant.region')->find($request->order_id);

        return responseJson(1, 'تم التحميل', $order);    }


     public function latestOrder(Request $request){
         //$order=$request->user()->orders()->with('items','client','restaurant.region')->latest()->first();

         $order=Order::where('client_id',$request->user()->id)->with('items','client','restaurant.region')->latest()->first();

         if ($order){

             return responseJson(1, 'latestOrder', $order);
         }

             return responseJson(0, 'لا يوجد');

     }

     public function confirmOrder(Request $request){

        $order=$request->user()->orders()->find($request->order_id);

        if (!$order){
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }

        if ($order->status!='accepted'){

            return responseJson(0, 'لا يمكن تأكيد استلام الطلب ، لم يتم قبول الطلب');
        }
        $order->update(['status'=>'deliverd']);

        $restraunt=Restaurant::find($order->restaurant_id);

         $notification= $restraunt->notifications()->create([
            'title'=>'تم تأكيد توصيل طلبك من العميل',
            'content'=>'الطلب رقم'.$request->order_id,
        ]);
        $token=$restraunt->tokens()->where('token','!=','')->pluck('token')->toArray();

        if (count($token)){
            public_path();
            $title = $notification->title;
            $content = $notification->content;
            $data =[
                'order_id' => $order->id,
                //'user_type' => 'client',
            ];
            $send = notifyByFirebase($title , $content , $token,$data);
            info("firebase result: " . $send);

            return responseJson(1,'تم تأكيد توصيل طلبك من العميل');

        }
     }


//'canceled'
     public function declineOrder(Request $request){
        $order=$request->user()->orders()->find($request->order_id);

         if (!$order){
             return responseJson(0, 'لا يمكن الحصول على البيانات');
         }

         if ($order->status!='accepted'){

             return responseJson(0, 'لا يمكن رفض استلام الطلب ، لم يتم قبول الطلب');
         }
         $order->update(['status'=>'canceled']);

         $restraunt=Restaurant::find($order->restaurant_id);

         $notification= $restraunt->notifications()->create([
             'title'=>'تم كانسله الطلب من العميل',
             'content'=>'الطلب رقم'.$request->order_id,
         ]);

         $token=$restraunt->tokens()->where('token','!=','')->pluck('token')->toArray();

         if (count($token)){
             public_path();
             $title = $notification->title;
             $content = $notification->content;
             $data =[
                 'order_id' => $order->id,
                 //'user_type' => 'client',
             ];
             $send = notifyByFirebase($title , $content , $token,$data);
             info("firebase result: " . $send);

             return responseJson(1,'تم كانسله الطلب من العميل');

         }


     }



     public function review(Request $request){
        $validation=validator()->make($request->all(),[
            'restaurant_id'=>'required|exists:restaurants,id',
            'comment'=>'required',
            'rate'=>'required|in:1,2,3,4,5'
        ]);

         if ($validation->fails()) {
             return responseJson(0, $validation->errors()->first(), $validation->errors());
         }

         $restraunt=Restaurant::find($request->restaurant_id);

         if (!$restraunt){
             return responseJson(0, 'لا يمكن الحصول على البيانات');
         }
        // $request->merge(['client_id'=>$request->user()->id]);

         $clientOrderCount=$request->user()->orders()
                           ->where('restaurant_id',$request->restaurant_id)
                            ->where('status','accepted')->count();

         if ($clientOrderCount==0){

             return responseJson(0, 'لا يمكن التقييم الا بعد تنفيذ طلب من المطعم');
         }

        // $review = $restraunt->rates()->create($request->all());

         $review = $request->user()->rates()->create($request->all());

         return responseJson(1, 'تم التقييم بنجاح', [
             'review' => $review->load('client','restaurant')
         ]);

     }
}
