@extends('layout.web')


@section('content')
<div class="row dir-rtl">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> إضافه بيانات العميل</h3>
            </div>
            <div class="card-body">
                <!-- form start -->
                <form role="form" action="{{route('clients.store')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <label for=""> حساب عام</label>
                                            <input type="text" name="general_account" class="form-control">
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <label for=""> حساب مساعد</label>
                                            <input type="text" name="help_account" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">اسم العميل</label>
                                    <input type="text" name="name" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">السجل التجاري</label>
                                    <input type="text" name="commercial_register" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">البطاقة الضريبية</label>
                                    <input type="text" name="tax_card_id" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for=""> المحافظة</label>
                                    <select class="custom-select" name="city_id">
                                        <option value="">اختر</option>
                                        @foreach($cities as $data)
                                        <option value="{{$data->id}}">{{$data->name}} </option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for=""> العنوان</label>
                                    <input type="text" name="address" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">الموبايل </label>
                                    <input type="text" name="phone" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for=""> البريد الإلكترونى </label>
                                    <input type="text" name="email" class="form-control" id="">
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">  ملاحظات </label>
                                    <input type="text" name="notes" class="form-control" id="">
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
