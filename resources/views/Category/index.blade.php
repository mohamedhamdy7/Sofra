@extends('layouts.app',[
								'page_header'		=> 'التصنيفات',
								'page_description'	=> 'تصنيفات المطاعم'
								])

@section('content')

    <section class="content">
        <div class="box-header">
            <div class="pull-left">
                <a href="{{url(route('category.create'))}}" class="btn btn-danger"><i class="fa fa-plus"> &nbsp تصنيف جديد</i></a>
            </div>

        </div>
        @include('flash::message')

        @if(count($record))

            <div class="table-responsive">
                <table class="table table-bordered danger">

                    <thead style="text-align: center">
                    <th>#</th>
                    <th>اسم القسم</th>
                    <th class="text-center">تعديل</th>
                    <th class="text-center">حذف</th>
                    </thead>
                    @foreach($record as $record)
                        <tr style="text-align: center;color: #9e0505;font-size: 20px">
                             <td>{{$loop->iteration}}</td>
                              <td>{{$record->name}}</td>
                               <td><a href="{{url(route('category.edit',$record->id))}}" class="btn btn-danger"><i class="fa fa-edit"></i></a></td>
                                <td>
                                    {!! Form::open([
                                    'action'=>['CategoryController@destroy',$record->id],
                                    'method'=>'delete'
                                    ]) !!}

                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    {!! Form::close() !!}
                                </td>
                        </tr>
                    @endforeach
                </table>
            </div>

        @endif
    </section>
@endsection