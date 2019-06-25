<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
       $record=Order::all();

       return view('Order.index',compact('record'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        $record=Order::find($id);

        if($record->status==null){

            $record->delete();

            flash()->error('تم الحذف بنجاح');
            return back();
        }
        else{
            flash()->error('لايمكن الحذف لان تم الرد على الطلب');

            return back();
        }
    }
}
