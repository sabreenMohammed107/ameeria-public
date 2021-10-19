@extends('layout.web')
@section('title', 'الأصناف')

@section('content')
<div class="row dir-rtl">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> إضافه صنف</h3>
            </div>
            <div class="card-body">
                <!-- form start -->
                <form role="form" action="{{route('items.store')}}" method="post">
                    @csrf
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">إختر المخزن</label>
                                    <select class="custom-select" id="store_id" name="store_id">
                                        <option value="">اختر</option>
                                        @foreach($stores as $data)
                                        <option {{old('store_id') ==$data->id ? 'selected' : ""}} value="{{$data->id}}">{{$data->name}} </option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">كود الصنف <span style="color: red">*</span></label>
                                    <input name="code" type="text" value="{{old('code') }}" class="form-control" id="codeItem">
                                </div>
                                <div style="color: red" id="dataMsg"></div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">اسم الصنف<span style="color: red">*</span></label>
                                    <input name="name" type="text" value="{{old('name') }}" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <label for=""> حساب عام<span style="color: red">*</span></label>
                                            <input name="general_account" value="{{old('general_account') }}" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <label for=""> حساب مساعد<span style="color: red">*</span></label>
                                            <input name="help_account" value="{{old('help_account') }}" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for=""> وحدة التخزين</label>
                                    <select class="js-example-basic-single" id="storage_unit_id" style="width: 100%"  name="storage_unit_id">
                                        <option value="">اختر</option>
                                        @foreach($storages as $data)
                                        <option {{old('storage_unit_id') ==$data->id ? 'selected' : ""}} value="{{$data->id}}">{{$data->name}}
                                       </option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">وحده الصرف <span style="color: red">*</span></label>
                                    <select class="w-100 js-example-basic-single" id="exchange_unit_id" name="exchange_unit_id">
                                        <option value="">اختر</option>
                                        @foreach($exchanges as $data)
                                        <option {{old('exchange_unit_id') ==$data->id ? 'selected' : ""}} value="{{$data->id}}" >{{$data->name}} </option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">سعر التكلفة</label>
                                    <input name="cost_price" value="{{old('cost_price') }}" type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">سعر البيع <span style="color: red">*</span></label>
                                    <input name="selling_price" value="{{old('selling_price') }}" type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">حد الطلب</label>
                                    <input name="request_limit" value="{{old('request_limit') }}" type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">الحد الأدنى</label>
                                    <input name="minimum"  value="{{old('minimum') }}" type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">الحد الأقصى</label>
                                    <input name="maximum" value="{{old('maximum') }}" type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">عدد الملفات</label>
                                    <input name="files_count" value="{{old('files_count') }}" type="text" class="form-control" id="">
                                </div>
                            </div>




                        </div>
                        <div class="card-body shadow mg-b-15">

                            <div class="card-header ">
                                <h3 class="card-title">
                                    <i class="fas fa-edit"></i> الأرصدة</h3>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for=""> تاريخ اول المده</label>
                                        <input name="balance_start_date" type="date" value="{{ old('balance_start_date', date('Y-m-d')) }}" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">رصيد اول المده كمية</label>
                                        <input name="balance_start_qty" value="{{old('balance_start_qty') }}" type="text" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">رصيد اول المده قيمة</label>
                                        <input name="balance_start_value" value="{{old('balance_start_value') }}" type="text" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">الرصيد الحالى كمية</label>
                                        <input name="balance_qty" value="{{old('balance_qty') }}" type="text" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">الرصيد الحالى قيمة</label>
                                        <input name="balance_value" value="{{old('balance_value') }}" type="text" class="form-control" id="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <a href="{{route('items.index')}}" class="btn btn-danger">إلغاء</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.col -->
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#store_id').select2();
    $('#storage_unit_id').select2();
    $('#exchange_unit_id').select2();
    $('#codeItem').on('blur', function() {

var codeItem = $('#codeItem').val();

    $.ajax({
       url:"{{route('check.code')}}",
      method: 'get',
      data: {
        code: codeItem
      },
      success: function(data) {

        $('#dataMsg').html('');
      },
      error: function(response){

        $('#dataMsg').html("الكود موجود مسبقا");
      }
});
    });



});
</script>

@endsection
