@extends('layout.web')


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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">إختر المخزن</label>
                                    <select class="custom-select" name="store_id">
                                        <option value="">اختر</option>
                                        @foreach($stores as $data)
                                        <option value="{{$data->id}}">{{$data->name}} </option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">كود الصنف </label>
                                    <input name="code" type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">اسم الصنف</label>
                                    <input name="name" type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <label for=""> حساب عام</label>
                                            <input name="general_account" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <label for=""> حساب مساعد</label>
                                            <input name="help_account" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for=""> وحدة التخزين</label>
                                    <select class="custom-select" name="storage_unit_id">
                                        <option value="">اختر</option>
                                        @foreach($storages as $data)
                                        <option value="{{$data->id}}">{{$data->name}} </option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">وحده الصرف</label>
                                    <select class="custom-select" name="exchange_unit_id">
                                        <option value="">اختر</option>
                                        @foreach($exchanges as $data)
                                        <option value="{{$data->id}}">{{$data->name}} </option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">سعر التكلفة</label>
                                    <input name="cost_price" type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">سعر البيع </label>
                                    <input name="selling_price" type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">حد الطلب</label>
                                    <input name="request_limit" type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">الحد الأدنى</label>
                                    <input name="minimum" type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">الحد الأقصى</label>
                                    <input name="maximum" type="text" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">عدد الملفات</label>
                                    <input name="files_count" type="text" class="form-control" id="">
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
                                        <input name="balance_start_date" type="date" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">رصيد اول المده كمية</label>
                                        <input name="balance_start_qty" type="text" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">رصيد اول المده قيمة</label>
                                        <input name="balance_start_value" type="text" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">الرصيد الحالى كمية</label>
                                        <input name="balance_qty" type="text" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">الرصيد الحالى قيمة</label>
                                        <input name="balance_value" type="text" class="form-control" id="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.col -->
@endsection
