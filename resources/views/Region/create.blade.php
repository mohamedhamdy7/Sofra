@extends('layouts.app')
@inject('model','App\city')
@section('content')
<!-- Main content -->
<section class="content">

    <div class="box">
        <div class="box-header with-border">

            <h3 class="box-title">CREATE Region</h3>
            <div class="box-body">

                @include('partials.validation_errors')

                {!! Form::model($model,[
                'action'=>'RegionController@store',
                'method'=>'post'
                ]) !!}
                <div class="form-group">

                    <label for="name">Region</label>
                    {!! form::text('name',null,[
                    'class'=>'form-control'
                    ]) !!}
                </div>

                <div class="form-group">

                    @inject('cities','App\City')
                    <label for="city_id">Cities</label>
                    {!! form::select('city_id',$cities->pluck('name','id'),null,[
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
<!-- /.content -->
@endsection