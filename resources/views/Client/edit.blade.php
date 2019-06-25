@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">انشاء مستخدم جديد </h3>
                <div class="box-body">
                    @include('partials.validation_errors')
                    {!! Form::model($model,[
                    'action'=>['ClientController@update',$model->id],
                    'method'=>'put',
                    'files'=>true
                    ]) !!}

                    <div class="form-group">

                        <label for="name">name</label>
                        {!! form::text('name',null,[
                        'class'=>'form-control'
                        ]) !!}
                    </div>
                    <div class="form-group">

                        @inject('regions','App\Region')
                        <label for="region_id">region</label>
                        {!! form::select('region_id',$regions->pluck('name','id'),[
                        'class'=>'form-control'
                        ]) !!}
                    </div>


                    <div class="form-group">

                        <label for="email">email</label>
                        {!! form::email('email',null,[
                        'class'=>'form-control'
                        ]) !!}
                    </div>

                    <div class="form-group">

                        <label for="password">password</label>
                        {!! form::text('password',null,[
                        'class'=>'form-control'
                        ]) !!}
                    </div>


                    <div class="form-group">

                        <label for="description">description</label>
                        {!! form::text('description',null,[
                        'class'=>'form-control'
                        ]) !!}
                    </div>


                    <div class="form-group">

                        <label for="phone">phone</label>
                        {!! form::number('phone',null,[
                        'class'=>'form-control'
                        ]) !!}
                    </div>

                    <div class="form-group">

                        <label for="image">image</label>
                        {!! form::file('image',null,[
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