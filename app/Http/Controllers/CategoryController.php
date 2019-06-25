<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $record=Category::all();

        return view('Category.index',compact('record'));
    }


    public function create()
    {
        return view('Category.create');
    }


    public function store(Request $request)
    {
        $this->validate($request,['name'=>'required'],['name.required'=>'من فضلك ادخل التصنيف']);

        Category::create($request->all());

        flash()->success('success');

        return redirect(route('category.index'));
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
        $model=Category::findOrFail($id);

        return view('Category.edit',compact('model'));
    }


    public function update(Request $request, $id)
    {
        $record=Category::findOrFail($id);
        $record->update($request->all());
        return redirect(route('category.index'));
    }


    public function destroy($id)
    {
        $record=Category::findOrFail($id);
        $record->delete();
        return back();
    }
}
