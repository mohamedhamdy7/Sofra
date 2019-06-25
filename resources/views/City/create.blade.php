@extends('layouts.app')
@inject('model','App\City')
@section('content')
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List of City</h3>
                <div class="box-body">

                    @include('partials.validation_errors')

                    {!! Form::open([
                    'action'=>'CityController@store',
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