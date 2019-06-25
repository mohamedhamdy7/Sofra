@extends('layouts.app')
@inject('model','App\City')

@section('content')

    <section class="content">

        <div class="box-body">
            <a href="{{url(route('city.create'))}}" class="btn btn-danger"><i class="fa fa-plus"> &nbsp New City</i></a>

{{--
            <a href="trashed" class="btn btn-danger" style="float: right">Show Trashed value</a>
--}}
            @include('flash::message')
            @if(count($records))
                <div class="table-responsive">
                    <table class="table table-bordered danger">

                        <thead style="text-align: center">
                        <tr>
                            <td>#</td>
                            <td>Name</td>
                            <td>Edit</td>
                            <td>Delete</td>

                        </tr>
                        </thead>
                        <tbody style="text-align: center">
                        @foreach($records as $record)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$record->name}}</td>
                                <td ><a href="{{url(route('city.edit',$record->id))}}" class="btn btn-danger"><i class="fa fa-edit"></i></a></td>
                                <td class="text-center">
                                    {!!Form::open([
                                    'action' =>['CityController@destroy',$record->id],
                                    'method' =>'delete'
                                    ]) !!}
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </td>


                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            @else
            @endif
        </div>


    </section>
@endsection