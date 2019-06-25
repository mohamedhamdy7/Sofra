@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">انشاء العروض</h3>
                <div class="box-body">

                    @include('partials.validation_errors')

                    {!! Form::open([
                    'action'=>'OfferController@store',
                    'files'=>true,
                    'method'=>'post'
                    ]) !!}

                    <div class="form-group">

                        <label for="name">Name</label>
                        {!! form::text('name',null,[
                        'class'=>'form-control'
                        ]) !!}
                    </div>
                    <div class="form-group">

                        @inject('restaurant','App\Restaurant')
                        <label for="restaurant_id">restaurant</label>
                        {!! form::select('restaurant_id',$restaurant->pluck('name','id'),null,[
                        'class'=>'form-control'
                        ]) !!}
                    </div>

                    <div class="form-group">

                        <label for="price">price</label>
                        {!! form::number('price',null,[
                        'class'=>'form-control'
                        ]) !!}
                    </div>
                    <div class="form-group">

                        <label for="description">description</label>
                        {!! form::textarea('description',null,[
                        'class'=>'form-control'
                        ]) !!}
                    </div>
                    <div class="form-group">

                        <label for="image">image</label>
                        {!! form::file('image',[
                        'class'=>'form-control'
                        ]) !!}
                    </div>
                    <div class="form-group">

                        <label for="start_from">start_from</label>
                        {!! form::date('start_from',null,[
                        'class'=>'form-control'
                        ]) !!}
                    </div>

                    <div class="form-group">

                        <label for="end_at">end_at</label>
                        {!! form::date('end_at',null,[
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