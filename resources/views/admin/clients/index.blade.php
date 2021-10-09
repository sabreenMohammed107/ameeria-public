@extends('layout.web')


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">سجل العملاء</h3>
                <h3 class="card-title float-sm-left"><a href="{{route('clients.create')}}" class="btn btn-success">إضافة</a></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="bg-info">
                        <tr>
                            <th>#</th>
                            <th>اسم العميل</th>
                            <th>حساب عام</th>

                            <th>حساب مساعد </th>
                            <th>سجل تجارى</th>
                            <th>بطاقة ضريبية</th>
                            <th>موبايل</th>

                            <th>تعديل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index=>$row)
                        <tr>
                            <th>{{ $index + 1 }}</th>
                            <th>{{ $row->name}} </th>
                            <th>{{ $row->general_account}}</th>
                            <th>{{ $row->help_account}}</th>

                            <th>{{ $row->commercial_register}}</th>
                            <th>{{ $row->tax_card_id}}</th>
                            <th>{{ $row->phone}}</th>
                            <th><a href="{{route('clients.edit',$row->id)}}" class="btn btn-info"><i class="fas fa-edit text-white"></i></a></th>
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

@endsection
