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
                            <th>خيارات</th>
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
                            <th><a href="{{route('items.edit',$row->id)}}" class="btn btn-info"><i class="fas fa-edit text-white"></i></a>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#del{{$row->id}}"><i class="fas fa-trash-alt"></i></button>

                            </th>
                      <!-- Delete Modal -->
<div class="modal fade dir-rtl" id="del{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('items.destroy', $row->id) }}"  method="POST" >
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
                {{$data->render()}}
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


$('#example1').DataTable( {
    destroy: true,
    paging: false
} );

</script>
@endsection

