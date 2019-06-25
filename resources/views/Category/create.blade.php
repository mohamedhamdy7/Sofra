@extends('layouts.app')
@inject('model','App\Category')
@section('content')
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">انشاء التصنيفات</h3>
                <div class="box-body">

                    @include('partials.validation_errors')

                    {!! Form::open([
                    'action'=>'CategoryController@store',
                    'method'=>'post'
                    ]) !!}

                    <div class="form-group">

                        <label for="name">Name</label>
                        {!! form::text('name',null,[
                        'class'=>'form-control'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary">ADD</button>
                    </div>

                    {!! form::close() !!}


                </div>


            </div>

        </div>

    </section>

@endsection