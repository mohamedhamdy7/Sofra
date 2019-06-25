<?php

namespace App\Http\Controllers;

use App\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{

    public function index()
    {
       $record=Offer::all();
       return view('Offer.index',compact('record'));
    }


    public function create()
    {
        return view('Offer.create');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'restaurant_id'=>'required|exists:restaurants,id',
            'price'=>'required',
            'description'=>'required',
            'start_from'=>'required',
            'end_at'=>'required',
        ],[

            'name.required'=>'plz enter the name',
            'restaurant_id.required'=>'plz enter the id',
            'price.required'=>'plz enter the price',
            'description.required'=>'plz enter the description',
            'start_from.required'=>'plz enter the start_from ',
            'end_at.required'=>'plz enter the end_at',
        ]);



        $offer=Offer::create($request->all());

        if ($request->hasFile('image')){

            $path=public_path();
            $destination_path=$path.'/uploads/offers/';
            $image=$request->file('image');
            $extention=$image->getClientOriginalExtension();
            $name=time().''.rand(1111,9999).'.'.$extention;
            $image->move($destination_path,$name);
            $offer->update(['image'=>'/uploads/offers/'.$name]);
        }

        flash()->success("تم اضافه العرض بنجاح");

        return redirect(route('offer.index'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        $record=Offer::findOrFail($id);

        $record->delete();

        flash()->error('تم حذف العنصر');
        return redirect(route('offer.index'));
    }
}
