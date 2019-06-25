<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $record=Client::all();

        return view('Client.index',compact('record'));
    }


    public function create()
    {
        return view('Client.create');
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'region_id'=>'required|exists:regions,id',
            'email'=>'required|unique:clients',
            'phone'=>'required|unique:clients',
            'description'=>'required',
            'image'=>'required|mimes:jpg,png,jpeg',
        ],[

                 'name.required'=>'plz name is required',
                 'region_id.exists'=>'plz enter region exists in region table',
                 'email.required'=>'plz email is required',
                 'phone.required'=>'plz phone is required',
                 'description.required'=>'plz description is required',
                 'image.mimes'=>'plz enter extension correct',
        ]);

        $request->merge(['password'=>bcrypt($request->password),'api_token'=>str_random(40)]);

        $client=Client::create($request->all());

        if ($request->hasFile('image')){
            $path=public_path();
            $destination_path=$path.'/uploads/clients/';
            $image=$request->file('image');
            $extention=$image->getClientOriginalExtension();
            $name=time().''.rand(1111,9999).'.'.$extention;
            $image->move($destination_path,$name);
            $client->update(['image'=>'/uploads/clients/'.$name]);
        }

        flash()->success("تم اضافه المستخدم بنجاح");
        return redirect(route('client.index'));
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $model=Client::find($id);

        return view('Client.edit',compact('model'));
    }


    public function update(Request $request, $id)
    {
        $record=Client::findOrFail($id);
        $record->update($request->all());
        return redirect(route('client.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record=Client::findOrFail($id);

        $record->delete();

        flash()->clear('تم حذف المستخدم');
        return redirect(route('client.index'));
    }

    public function activate($id){
        $record=Client::find($id);
        $record->activated=1;
        $record->save();
        return back();
    }

    public function deActivate($id){
        $record=Client::find($id);
        $record->activated=0;
        $record->save();
        return back();
    }
}
