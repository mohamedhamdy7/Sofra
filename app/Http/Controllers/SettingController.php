<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {
        $record=Setting::all();

        return view('Setting.index',compact('record'));
    }


    public function create()
    {
        //
    }


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
        $record=Setting::findOrFail($id);
        return view('setting.edit',compact('record'));
    }


    public function update(Request $request, $id)
    {

        if (Setting::all()->count()>0)
        {
            $record=Setting::findOrFail($id);
            $record->update($request->all());
        }
        else{
            Setting::create($request->all());
        }
        flash()->success('تم التعديل بنجاح');
        return redirect(route('setting.index'));

    }


    public function destroy($id)
    {
        //
    }
}
