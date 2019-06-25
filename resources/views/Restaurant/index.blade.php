@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="box-body">
            <a href="{{url(route('restaurant.create'))}}" class="btn btn-danger"><i class="fa fa-plus"> &nbsp انشاء مطعم جديد</i></a>

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

                            <td>status</td>
                            <td>min_price</td>
                            <td>delivery_cost</td>
                            <td>phone</td>
                            <td>whatsapp</td>
                            <td>delivery_way</td>
                            <td>Activate/Deactivated</td>

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
                        <td>{{$record->status}}</td>
                        <td>{{$record->min_price}}</td>
                        <td>{{$record->delivery_cost}}</td>
                        <td>{{$record->phone}}</td>
                        <td>{{$record->whatsapp}}</td>
                        <td>{{$record->delivery_way}}</td>

                                <td class="text-center">
                                    @if($record->activated)
                                        <a href="restaurant/{{$record->id}}/de-activate" class="btn btn-xs btn-danger"><i class="fa fa-close"></i> إيقاف</a>
                                    @else
                                        <a href="restaurant/{{$record->id}}/activate" class="btn btn-xs btn-success"><i class="fa fa-check"></i> تفعيل</a>
                                    @endif
                                </td>


                        <td>
                            {!!Form::open([
                                    'action' =>['RestaurantController@destroy',$record->id],
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