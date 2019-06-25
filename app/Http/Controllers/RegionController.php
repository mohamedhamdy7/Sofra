<?php

namespace App\Http\Controllers;

use App\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{

    public function index()
    {
       $record=Region::all();

       return view('Region.index',compact('record'));
    }


    public function create()
    {
       return view('Region.create');
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'city_id'=>'required|exists:cities,id',
        ],[
            'name.required'=>'Name is required',
            'city_id.required'=>'city is required',
            'city_id.exists'=>'city must exists',
        ]);

        $record=Region::create($request->all());
        flash()->success("success");
        return redirect(route('region.index'));
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
        $model=Region::findOrFail($id);
        return view('Region.edit',compact('model'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required',
            'city_id'=>'required|exists:cities,id',
        ],[
            'name.required'=>'Name is required',
            'city_id.required'=>'city is required',
            'city_id.exists'=>'city must exists',
        ]);

        $record=Region::findOrFail($id);
        $record->update($request->all());
        flash()->success("success");

        return redirect(route('region.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record=Region::findOrFail($id);
        $record->delete();
        flash()->error('تم الحذف بنجاح');
        return back();
    }
}
