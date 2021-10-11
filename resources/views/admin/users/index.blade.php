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
                                    <a data-target="#confirm-delete" href="javascript:;" data-href="{{ route('users.destroy', $row->id) }}"  class="btn btn-danger btn-sm" data-placement="top" title="حذف بيانات السجل" data-toggle="modal">
                                        حذف
                                    </a>
                                    @endcan
                                </div>
                            </td>
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
