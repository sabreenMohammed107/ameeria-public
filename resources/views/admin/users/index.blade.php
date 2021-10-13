@extends('layout.web')

@section('title', 'المستخدمين')

@section('content')




<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">جميع بيانات المستخدمين</h3>
                <h3 class="card-title float-sm-left">
                    @can('users-create')
                    <a href="{{ route('users.create') }}" class="btn btn-success">إضافة</a>
                    @endcan
                </h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم كامل</th>
                            <th>اسم المستخدم</th>
                            <th>البريد الالكتروني </th>
                            <th>التليفون </th>
                            <th>الحالة</th>
                            <th>الدور</th>
                            <th>الاجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->f_name.' '.$row->l_name }}</td>
                            <td>{{ $row->username }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>
                                @if(!empty($row->getRoleNames()))
                                    @foreach($row->getRoleNames() as $v)
                                        <label class="badge badge-primary">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if($row->status == 1)
                                <span class="badge badge-success">نشط</span>
                                @else
                                <span class="badge badge-danger">غير نشظ</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    @can('users-edit')
                                    <a class="btn btn-success btn-sm" href="{{ route('users.edit', $row->id) }}" data-title="tooltip" data-placement="top" title="تعديل بيانات السجل">
                                        تعديل
                                    </a>
                                    @endcan
                                    @can('users-delete')

                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#del{{$row->id}}" > حذف</button>

                                    @endcan
                                </div>
                            </td>
                        </tr>
                        <!--/Edit Customer-->
                         <!-- Delete Modal -->
                         <div class="modal fade dir-rtl" id="del{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="{{ route('users.destroy', $row->id) }}"  method="POST" >
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
