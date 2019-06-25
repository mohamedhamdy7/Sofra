@extends('layouts.app')


@section('content')
    <!-- Main content -->
    <section class="content">

        <div class="box-body">



            @include('flash::message')
            @if(count($record))
                <div class="table-responsive">
                    <table class="table table-bordered danger">

                        <thead style="text-align: center">
                        <tr>
                            <td>#</td>
                            <td>الاسم</td>

                            <td>الايميل</td>
                            <td>رقم التليفون</td>


                            <td>الملاخظات</td>

                            <td>الحاله</td>


                            <td>حذف</td>



                        </tr>
                        </thead>
                        <tbody style="text-align: center">
                        @foreach($record as $record)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$record->	name}}</td>

                                <td>{{$record->	email}}</td>
                                <td>{{$record->	phone}}</td>


                                <td>{{$record->notes}}</td>

                                <td>{{$record->status}}</td>

                                <td class="text-center">
                                    {!!Form::open([
                                    'action' =>['ContactController@destroy',$record->id],
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
    <!-- /.content -->
@endsection