<?php

namespace App\Http\Controllers;

use App\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{

    public function index()
    {
        $record=Restaurant::all();

        return view('Restaurant.index',compact('record'));
    }


    public function create()
    {
        return view('Restaurant.create');
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|unique:restaurants',
            'phone'=>'required|unique:restaurants',
            'whatsapp'=>'required|unique:restaurants',
            'min_price'=>'required',
            'delivery_cost'=>'required',
            'region_id'=>'required|exists:regions,id',
/*            'category_id'=>'required|array|exists:categories,id',*/
            'status'=>'required|in:open,close',
            'delivery_way'=>'required'
        ]);

        $request->merge(['password'=>bcrypt($request->password),'api_token'=>str_random(30)]);
        $restaurant=Restaurant::create($request->except('category_id'));

        if ($request->has('category_id')){
            $restaurant->categories()->sync($request->category_id);
        }

        flash()->success('تم إضافة المطعم بنجاح');

        return redirect(route('restaurant.index'));
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
       $record=Restaurant::findorFail($id);
       dd($record);
       if ($record->orders()->count() || $record->categories()->count()){

           flash()->error('لايمكن حذف لوجود غمليات لهذا المطعم');
       }
           $record->delete();
           flash()->error('تم الحذف بنجاح');

       return back();


    }

    public function activate($id){

        $record=Restaurant::find($id);

        $record->activated=1;

        $record->save();

        return back();
    }

    public function deActivate($id){

        $record=Restaurant::find($id);

        $record->activated=0;

        $record->save();

        return back();
    }
}
