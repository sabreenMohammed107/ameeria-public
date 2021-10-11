@extends('layout.web')

@section('title', 'الأدوار')

@section('content')
<div class="row dir-rtl">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> إضافه بيانات الدور</h3>
            </div>
            <div class="card-body">

                {{ Form::model($data, array('route' => array('roles.update', $data->id), 'method' => 'PUT')) }}
                
                <div class="form-group">
                    {{ Form::label('name', 'الاسم') }}
                    {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'الاسم']) !!}
                </div>
                <div class="form-group row">
                    <label for="name" class="col-form-label required">الصلاحيات</label>
                    <div class="col-sm-12">
                        <div class="row">
                            @foreach($permission as $value)
                            <div class="col-sm-3">
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false) }}
                                        <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                        </span>
                                        <span>{{ $value->name }}</span>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <br>
                    {!! Form::submit('حفظ ', ['class'=>'btn btn-primary']) !!}
                </div>

                {!! Form::close() !!}
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.col -->
@endsection
