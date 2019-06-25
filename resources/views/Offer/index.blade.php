@extends('layouts.app')
@inject('model','App\City')

@section('content')

    <section class="content">

        <div class="box-body">

            <a href="{{url(route('offer.create'))}}" class="btn btn-danger"><i class="fa fa-plus"> &nbsp انشاء عرض جديد</i></a>


            {{--
                        <a href="trashed" class="btn btn-danger" style="float: right">Show Trashed value</a>
            --}}
            @include('flash::message')
            @if(count($record))
                <div class="table-responsive">
                    <table class="table table-bordered danger">

                        <thead style="text-align: center;font-size: 18px;">
                        <tr>
                            <td>#</td>
                            <td>الاسم</td>
                            <td>اسم المطعم</td>
                            <td>السعر</td>
                            <td>الوصف</td>
                            <td>الصوره</td>
                            <td>تبدأ من</td>
                            <td>تنتهى فى</td>

                            <td>حذف</td>

                        </tr>
                        </thead>
                        <tbody style="text-align: center;font-size: 18px;">
                        @foreach($record as $record)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$record->name}}</td>
                                <td>{{optional($record->restaurant)->name}}</td>
                                <td>{{$record->price}}</td>
                                <td>{{$record->description}}</td>
                                <td><img src="{{asset($record->image)}}" style="width:200px; height:100px"></td>
                                <td>{{$record->start_from}}</td>
                                <td>{{$record->end_at}}</td>


                                <td class="text-center">
                                    {!!Form::open([
                                    'action' =>['OfferController@destroy',$record->id],
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