@extends('layout.web')

@section('title', 'إعدادات عامة')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> القيمه المضافه</h3>
                <h3 class="card-title float-sm-left">
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped arabic">
                    <thead class="bg-info">
                        <tr>
                            <th>#</th>

                            <th> ضريبه القيمه المضافة</th>
                            <th> قيمه الضريبة</th>
                            <th>تعديل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index=>$vat)
                        <tr>
                            <th>{{ $index + 1 }}</th>

                            <th>@if($vat->key_name=='tax_value')ضريبة القيمة المضافة @endif </th>
                            <th>{{ $vat->value_name}} </th>

                            @can('settings-edit')
                            <th><button class="btn btn-info" data-toggle="modal" data-target="#add{{$vat->id}}"><i class="fas fa-edit text-white"></i></button></th>
                      @endcan
                            <!--Add Customer-->
     <div class="modal" id="add{{$vat->id}}" tabindex="-1">
        <div class="modal-dialog dir-rtl">
            <div class="modal-content dir-rtl">
                <div class="modal-header dir-rtl">
                    <h5 class="modal-title"> ضريبة القيمه المضافة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">


                    <div class="message-content" style="text-align:right;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form action="{{route('settings.update',$vat->id)}}" method="POST" class="arabic dropzone dropzone-custom needsclick addcourse" id="demo1-upload">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="direction:rtl">

                                        <div class="form-group">
                                            <label class="">الاسم</label>
                                            <input name="key_name" readonly value="@if($vat->key_name=='tax_value')ضريبة القيمة المضافة @endif " type="text" class="form-control" placeholder="القيمه">
                                        </div>

                                        <div class="form-group">
                                            <label class="">القيمه</label>
                                            <input name="value_name" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($vat->value_name)}}" required type="text" class="form-control" placeholder="القيمه">
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
    <!--/Add Customer-->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
