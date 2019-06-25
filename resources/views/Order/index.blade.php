@extends('layouts.app')
@inject('model','App\City')

@section('content')

    <section class="content">

        <div class="box-body">



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
                            <td>حاله الطلب</td>
                            <td>العنوان</td>
                            <td>السعر</td>
                            <td>المبلغ المطلوب </td>
                            <td>رقم العميل</td>
                            <td>اسم العميل</td>
                            <td>طلب خاص</td>
                            <td>العموله</td>
                            <td>الصافى</td>

                            <td>حذف</td>

                        </tr>
                        </thead>
                        <tbody style="text-align: center;font-size: 18px;">
                        @foreach($record as $record)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$record->name}}</td>
                                <td>{{optional($record->restaurant)->name}}</td>
                                <td>{{$record->status}}</td>
                                <td>{{$record->address}}</td>
                                <td>{{$record->price}}</td>
                                <td>{{$record->total}}</td>
                                <td>{{$record->client_phone}}</td>
                                <td>{{optional($record->client)->name}}</td>
                                <td>{{$record->privte_order}}</td>
                                <td>{{$record->comission}}</td>
                                <td>{{$record->net}}</td>


                                <td class="text-center">
                                    {!!Form::open([
                                    'action' =>['OrderController@destroy',$record->id],
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