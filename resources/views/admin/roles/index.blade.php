@extends('layout.web')

@section('title', 'الأدوار')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> بيانات أدوار المستخدمين</h3>
                <h3 class="card-title float-sm-left">
                    @can('roles-create')
                    <a class="btn btn-success" href="{{ route('roles.create') }}">إضافة</a>
                    @endcan
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="bg-info">
                        <tr>
                            <th>#</th>
                            <th> الاسم</th>
                            <th>الاجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->name}}</td>
                            <td>
                                <div class="btn-group">
                                    @can('roles-list')
                                    <a class="btn btn-info btn-sm" href="{{ route('roles.show', $row->id) }}" data-title="tooltip" data-placement="top" title="عرض بيانات السجل">
                                        عرض
                                    </a>
                                    @endcan
                                    @can('roles-edit')
                                    <a class="btn btn-success btn-sm" href="{{ route('roles.edit', $row->id) }}" data-title="tooltip" data-placement="top" title="تعديل بيانات السجل">
                                        تعديل
                                    </a>
                                    @endcan
                                    @can('roles-delete')
                                    <a data-target="#confirm-delete" href="javascript:;" data-href="{{ route('roles.destroy', $row->id) }}"  class="btn btn-danger btn-sm" data-placement="top" title="حذف بيانات السجل" data-toggle="modal">
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
