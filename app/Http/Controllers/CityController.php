<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $records=City::paginate(26);

        return view('City.index',compact('records'));

    }


    public function create()
    {
        return view('City.create');
    }


    public function store(Request $request)
    {
       $this->validate($request,[
           'name'=>'required'
       ],[
           'name.required'=>'plz enter city'
       ]);

       $record=City::create($request->all());

       flash()->success("تم اضافه المحافظه بنجاح");

       return redirect(route('city.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }


    public function edit($id)
    {
        $model=City::find($id);

        return view('City.edit',compact('model'));
    }


    public function update(Request $request, $id)
    {
        $record=City::findOrFail($id);
        $record->update($request->all());
        return redirect(route('city.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record=City::findOrFail($id);
        $record->delete();
        return redirect(route('city.index'));
    }
}
