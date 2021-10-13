@extends('layout.web')

@section('title', 'وحدات القياس')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">وحدات القياس</h3>
                <h3 class="card-title float-sm-left">
                    @can('units-create')
                    <button class="btn btn-success" data-toggle="modal" data-target="#add">إضافة</button></h3>
          @endcan
                </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="bg-info">
                        <tr>
                            <th>#</th>
                            <th>الكود</th>
                            <th>وحده القياس</th>

                            <th>خيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index=>$unit)
                        <tr>
                            <th>{{ $index + 1 }}</th>

                            <th>{{ $unit->code}} </th>
                            <th>{{ $unit->name}}</th>


                            <th>
                                @can('units-edit')
                                <button class="btn btn-info" data-toggle="modal" data-target="#add{{$unit->id}}"><i class="fas fa-edit text-white"></i></button>
                                @endcan
                                @can('units-delete')
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#del{{$unit->id}}"><i class="fas fa-trash-alt"></i></button>
@endcan
                            </th>
                        <!--Edit Customer-->
<div class="modal" id="add{{$unit->id}}" tabindex="-1">
    <div class="modal-dialog dir-rtl">
        <div class="modal-content dir-rtl">
            <div class="modal-header dir-rtl">
                <h5 class="modal-title"> وحده قياس</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">


                <div class="message-content" style="text-align:right;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <form action="{{route('units.update',$unit->id)}}" method="POST" class="dropzone dropzone-custom needsclick addcourse" id="demo1-upload">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="direction:rtl">

                                    <div class="form-group">
                                        <label class=""> الكود</label>
                                        <input name="code" type="text" required value="{{$unit->code}}" class="form-control" placeholder="الكود">
                                    </div>
                                    <div class="form-group">
                                        <label class="">اسم الوحده</label>
                                        <input name="name" type="text" required value="{{$unit->name}}" class="form-control" placeholder="الاسم">
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
                         <!-- Delete Modal -->
                         <div class="modal fade dir-rtl" id="del{{$unit->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="{{ route('units.destroy', $unit->id) }}"  method="POST" >
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                    <div class="modal-header bg-gradient-danger">
                                        <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>
                                        <button type="button" class="close m-0 p-0 text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h3><i class="fas fa-fire text-danger"></i></h3>
                                        <h4 class="text-danger">حذف جميع البيانات ؟</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                        <button type="submit" class="btn btn-danger">تأكيد</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
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
                <h5 class="modal-title"> وحده قياس</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">


                <div class="message-content" style="text-align:right;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <form action="{{route('units.store')}}" method="post" class="dropzone dropzone-custom needsclick addcourse" id="demo1-upload">
                          @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="direction:rtl">

                                    <div class="form-group">
                                        <label class=""> الكود</label>
                                        <input name="code" required type="text" value="{{old('code') }}" class="form-control" placeholder="الكود">
                                    </div>
                                    <div class="form-group">
                                        <label class="">اسم الوحده</label>
                                        <input name="name" required type="text" value="{{old('name') }}" class="form-control" placeholder="الاسم">
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
