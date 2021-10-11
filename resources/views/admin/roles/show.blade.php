@extends('layout.web')

@section('title', 'الأدوار')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> عرض بيانات الدور</h3>
                <h3 class="card-title float-sm-left">
                    <a class="btn btn-info" href="{{ route('roles.index') }}">رجوع</a>
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>الاسم:</strong>
                    {{ $data->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>الصلاحيات:</strong>
                    @if(!empty($rolePermissions))
                    <div class="row">
                        @foreach($rolePermissions as $value)
                        <div class="col-sm-3">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    {{ Form::checkbox('permission[]', $value->id, true, ['disabled']) }}
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>{{ $value->name }}</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
