@extends('layouts.app')


@section('content')
    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header with-border">

                <h3 class="box-title">SEETINGS</h3>
                <div class="box-body">

                    @include('partials.validation_errors')
                    @include('flash::message')
                    {!! Form::model($record,[
                        'action' => ['SettingController@update',$record->id],
                        'method' => 'put'
                    ]) !!}

                    <div class="form-group">
                        <label for="about_app">about_app</label>
                        {!! Form::text('about_app',null,[
                            'class' => 'form-control'
                        ]) !!}
                    </div>


                    <div class="form-group">
                        <label for="android_app_url">android_app_url</label>
                        {!! Form::text('android_app_url',null,[
                            'class' => 'form-control'
                        ]) !!}
                    </div> <div class="form-group">
                        <label for="facebook_url">facebook_url</label>
                        {!! Form::text('facebook_url',null,[
                            'class' => 'form-control'
                        ]) !!}
                    </div>
                     <div class="form-group">
                        <label for="instagram_url">instgram_url</label>
                        {!! Form::text('instagram_url',null,[
                            'class' => 'form-control'
                        ]) !!}
                    </div> <div class="form-group">
                        <label for="twitter_url">twitter_url</label>
                        {!! Form::text('twitter_url',null,[
                            'class' => 'form-control'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        <label for="comission">comission</label>
                        {!! Form::number('comission',null,[
                            'class' => 'form-control'
                        ]) !!}
                    </div>




                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </section>
    <!-- /.content -->
@endsection