@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header with-border">

                <h3 class="box-title">List of cities</h3>
                <div class="box-body">

                    @include('partials.validation_errors')

                    {!! Form::model($model,[
                    'action'=>['CityController@update',$model->id],
                    'method' => 'put',
                    'files' =>true
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