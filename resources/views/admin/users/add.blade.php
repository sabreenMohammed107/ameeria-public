@extends('layout.web')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>إنشاء مستخدم</h2>
        </div>

    </div>
</div>






{!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
<div class="row arabic">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>الاسم الاول:</strong>
            {!! Form::text('f_name', null, array('class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>الاسم الأخير:</strong>
            {!! Form::text('l_name', null, array('class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>إسم المستخدم:</strong>
            {!! Form::text('username', null, array('class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>البريد الإلكترونى:</strong>
            {!! Form::text('email', null, array('class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>رقم التليفون:</strong>
            {!! Form::text('phone', null, array('class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>كلمه السر:</strong>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>تأكيد كلمه السر :</strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>الأدوار:</strong>
            {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
</div>
{!! Form::close() !!}


@endsection
