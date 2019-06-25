@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="box-body">
            <a href="{{url(route('client.create'))}}" class="btn btn-danger"><i class="fa fa-plus"> &nbsp انشاء مطعم جديد</i></a>

            @include('flash::message')

            @if(count($record))
                <div class="table-responsive">
                    <table class="table table-bordered danger">

                        <thead style="text-align: center">
                        <tr>
                            <td>#</td>
                            <td>name</td>
                            <td>region</td>
                            <td>email</td>
                            <td>phone</td>
                            <td>description</td>
                            <td> image</td>
                            <td>Activate/Deactivated</td>
                            <td>Edit</td>
                            <td>Delete</td>

                        </tr>
                        </thead>

                        <tbody style="text-align: center">

                        @foreach($record as $record)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$record->name}}</td>
                                <td>{{optional($record->region)->name}}</td>
                                <td>{{$record->email}}</td>
                                {{--<td>{{Hash::make($record->password)}}</td>--}}
                                <td>{{$record->phone}}</td>
                                <td>{{$record->description}}</td>
                                <td><img src="{{asset($record->image)}}" style="width: 200px; height: 200px"></td>


                                <td class="text-center">
                                    @if($record->activated)
                                        <a href="client/{{$record->id}}/de-activate" class="btn btn-xs btn-danger"><i class="fa fa-close"></i> إيقاف</a>
                                    @else
                                        <a href="client/{{$record->id}}/activate" class="btn btn-xs btn-success"><i class="fa fa-check"></i> تفعيل</a>
                                    @endif
                                </td>

                                <td><a href="{{url(route('client.edit',$record->id))}}" class="btn btn-danger"><i class="fa fa-edit"></i></a></td>
                                <td>
                                    {!!Form::open([
                                            'action' =>['ClientController@destroy',$record->id],
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