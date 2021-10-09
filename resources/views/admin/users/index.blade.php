@extends('layout.web')


@section('content')




<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">المستخدمين</h3>
                <h3 class="card-title float-sm-left"><a href="{{route('users.create')}}" class="btn btn-success">إضافة</a></h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المستخدم</th>
                            <th>الصلاحية</th>
                            <th>تليفون </th>
                            <th>الاجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index=>$user)
                        <tr>
                            <th>{{ $index + 1 }}</th>
                            <th>{{ $user->username}}</th>
                            <th>أدمن</th>
                            <th>{{ $user->phone }}</th>
                            <th><a href="{{route('users.edit',$user->id)}}" class="btn btn-info"><i class="fas fa-edit text-white"></i></a></th>

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
