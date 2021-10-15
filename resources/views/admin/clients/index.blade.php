@extends('layout.web')

@section('title', 'العملاء')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">سجل العملاء</h3>
                @can('clients-create')
                <h3 class="card-title float-sm-left"><a href="{{route('clients.create')}}" class="btn btn-success">إضافة</a></h3>
           @endcan
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped arabic">
                    <thead class="bg-info">
                        <tr>
                            <th>#</th>
                            <th>اسم العميل</th>
                            <th>حساب عام</th>

                            <th>حساب مساعد </th>
                            <th>سجل تجارى</th>
                            <th>بطاقة ضريبية</th>
                            <th>موبايل</th>

                            <th>خيارات</th>
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
                            <th>
                                @can('clients-edit')
                                <a href="{{route('clients.edit',$row->id)}}" class="btn btn-info"><i class="fas fa-edit text-white"></i></a>
                               @endcan
                                @can('clients-delete')
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#del{{$row->id}}"><i class="fas fa-trash-alt"></i></button>
                                @endcan
                            </th>
                             <!-- Delete Modal -->
<div class="modal fade dir-rtl" id="del{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('clients.destroy', $row->id) }}"  method="POST" >
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

@endsection
@section('scripts')
<script>


$('#example1').DataTable( {
    destroy: true,
    paging: false
} );

</script>
@endsection
