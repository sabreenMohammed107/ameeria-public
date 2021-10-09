@extends('layout.web')


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> المدن</h3>
                <h3 class="card-title float-sm-left">
                    <button class="btn btn-success" data-toggle="modal" data-target="#add">إضافة</button></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="bg-info">
                        <tr>
                            <th>#</th>
                            <th>الكود</th>
                            <th> الاسم</th>

                            <th>تعديل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index=>$row)
                        <tr>
                            <th>{{ $index + 1 }}</th>

                            <th>{{ $row->code}} </th>
                            <th>{{ $row->name}}</th>

                            <th><button class="btn btn-info" data-toggle="modal" data-target="#add{{$row->id}}"><i class="fas fa-edit text-white"></i></button></th>
                         <!--Edit Customer-->
 <div class="modal" id="add{{$row->id}}" tabindex="-1">
    <div class="modal-dialog dir-rtl">
        <div class="modal-content dir-rtl">
            <div class="modal-header dir-rtl">
                <h5 class="modal-title"> المدن / المحافظات</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">


                <div class="message-content" style="text-align:right;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <form action="{{route('cities.update',$row->id)}}" method="post" class="dropzone dropzone-custom needsclick addcourse" id="demo1-upload">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="direction:rtl">

                                    <div class="form-group">
                                        <label class=""> الكود</label>
                                        <input name="code" value="{{$row->code}}" type="text" class="form-control" placeholder="الكود">
                                    </div>
                                    <div class="form-group">
                                        <label class="">اسم المدينة</label>
                                        <input name="name" value="{{$row->name}}" type="text" class="form-control" placeholder="الاسم">
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
<!--/Edit Customer-->


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


 <!--Add Customer-->
 <div class="modal" id="add" tabindex="-1">
    <div class="modal-dialog dir-rtl">
        <div class="modal-content dir-rtl">
            <div class="modal-header dir-rtl">
                <h5 class="modal-title"> المدن / المحافظات</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">


                <div class="message-content" style="text-align:right;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <form action="{{route('cities.store')}}" method="post" class="dropzone dropzone-custom needsclick addcourse" id="demo1-upload">
                           @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="direction:rtl">

                                    <div class="form-group">
                                        <label class=""> الكود</label>
                                        <input name="code" type="text" class="form-control" placeholder="الكود">
                                    </div>
                                    <div class="form-group">
                                        <label class="">اسم المدينة</label>
                                        <input name="name" type="text" class="form-control" placeholder="الاسم">
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
@endsection
