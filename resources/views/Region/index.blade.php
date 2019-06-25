@extends('layouts.app')

@section('content')
<section class="content">

    <div class="box-body">
        <a href="{{url(route('region.create'))}}" class="btn btn-danger"><i class="fa fa-plus"> &nbsp New Region</i></a>


        @include('flash::message')
        @if(count($record))
            <div class="table-responsive">
                <table class="table table-bordered danger">

                    <thead style="text-align: center">
                    <tr>
                        <td>#</td>
                        <td>اسم المدينه</td>
                        <td>اسم المنطقه</td>
                        <td>تعديل</td>
                        <td>حذف</td>

                    </tr>
                    </thead>
                    <tbody style="text-align: center">
                    @foreach($record as $record)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{optional($record->city)->name}}</td>
                            <td>{{$record->name}}</td>
                            <td ><a href="{{url(route('region.edit',$record->id))}}" class="btn btn-danger"><i class="fa fa-edit"></i></a></td>
                            <td class="text-center">
                                {!!Form::open([
                                'action' =>['RegionController@destroy',$record->id],
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