@extends('layout.web')


@section('content')
<div class="row dir-rtl">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> تعديل بيانات العميل</h3>
            </div>
            <div class="card-body">
                <!-- form start -->
                <form role="form" action="{{route('clients.update',$row->id)}}" method="post">
                    @method('PUT')

                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <label for=""> حساب عام<span style="color: red">*</span></label>
                                            <input type="text" name="general_account" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->general_account)}}" class="form-control">
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <label for=""> حساب مساعد<span style="color: red">*</span></label>
                                            <input type="text" name="help_account" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->help_account)}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">اسم العميل<span style="color: red">*</span></label>
                                    <input type="text" name="name" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->name)}}" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">السجل التجاري</label>
                                    <input type="text" name="commercial_register" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->commercial_register)}}" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">البطاقة الضريبية</label>
                                    <input type="text" name="tax_card_id" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->tax_card_id)}}" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for=""> المحافظة</label>
                                    <select class="custom-select" id="city_id" name="city_id">
                                        <option value="">اختر</option>
                                        @foreach($cities as $data)
                                        <option value="{{$data->id}}" {{ ( $data->id == $row->city_id) ? 'selected' : '' }}>{{$data->name}} </option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for=""> العنوان</label>
                                    <input type="text" name="address" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->address)}}" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">الموبايل </label>
                                    <input type="text" name="phone" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->phone)}}" class="form-control" id="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for=""> البريد الإلكترونى </label>
                                    <input type="text" name="email" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->email)}}" class="form-control" id="">
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">  ملاحظات </label>
                                    <input type="text" name="notes" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->notes)}}" class="form-control" id="">
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
