@extends('layout.web')


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">سجل الأصناف</h3>
                <h3 class="card-title float-sm-left"><a href="{{route('items.create')}}" class="btn btn-success">إضافة</a></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="bg-info">
                        <tr>
                            <th>#</th>
                            <th>كود الصنف</th>
                            <th>اسم الصنف </th>
                            <th>وحده الصرف </th>

                            <th>سعر التكلفة </th>
                            <th>سعر البيع </th>
                            <th>تعديل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index=>$row)
                        <tr>
                            <th>{{ $index + 1 }}</th>
                            <th>{{ $row->code}}</th>
                            <th>{{ $row->name}}</th>
                            <th>{{ $row->exchange_unit_id}}</th>

                            <th>{{ $row->cost_price}}</th>
                            <th>{{ $row->selling_price}}</th>
                            <th><a href="{{route('items.edit',$row->id)}}" class="btn btn-info"><i class="fas fa-edit text-white"></i></a></th>
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
@section('scripts')
<script>
    $(function() {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });
</script>
@endsection

