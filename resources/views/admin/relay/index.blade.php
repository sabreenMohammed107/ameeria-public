@extends('layout.web')


@section('content')
<div class="row dir-rtl">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> ترحيل الفواتير
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-info card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-one-1-tab" data-toggle="pill" href="#custom-tabs-one-1" role="tab" aria-controls="custom-tabs-one-1" aria-selected="true"> الفواتير الجاهزة للترحيل</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-2-tab" data-toggle="pill" href="#custom-tabs-one-2" role="tab" aria-controls="custom-tabs-one-2" aria-selected="false">الفواتير التى تم ترحيلها</a>
                                    </li>

                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">

                                    <div class="tab-pane fade show active" id="custom-tabs-one-1" role="tabpanel" aria-labelledby="custom-tabs-one-1-tab">
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary" style="float: left;">ترحيل الى مصلحة الضرائب</button>
                                        </div>
                                        <div class="card card-primary">

                                            <!-- form start -->
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="active">
                                                            <input type="checkbox" class="select-all checkbox" id="selectAll" name="select-all" />
                                                        </th>
                                                        <th>#</th>
                                                        <th>رقم الفاتورة </th>
                                                        <th>التاريخ </th>
                                                        <th>نوع الفاتورة</th>
                                                        <th>الحالة</th>

                                                        <th>اسم العميل</th>
                                                        <th>إجمالى صافى </th>
                                                        <th>عرض</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $index=>$row)
                                                    <tr>


                                                        <td class="active">
                                                            <input type="checkbox" class="select-item checkbox" name="select-item" value="1000" />
                                                        </td>
                                                        <th>{{ $index + 1 }}</th>
                                                        <th>1001</th>
                                                        <th>{{ $row->invoice_no}}</th>
                                                        <th>{{date('Y-m-d', strtotime($row->date))}} </th>
                                                        <th>{{ $row->type->name ?? ''}}</th>
                                                        <th>@if($row->status==1) تم الترحيل @else لم يتم الترحيل @endif</th>


                                                        <th> {{ $row->client->name ?? ''}}</th>
                                                        <th>{{ $row->total}}</th>
                                                        <th>
                                                            <a href="{{route('relay.edit',$row->id)}}" class="btn btn-success"><i class="fas fa-edit text-white"></i></a>
                                                        </th>
                                                    </tr>

@endforeach
                                                </tbody>
                                            </table>
                                            {{$data->render()}}
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-2" role="tabpanel" aria-labelledby="custom-tabs-one-2-tab">
                                        <div class="card card-primary">

                                            <!-- form start -->
                                            <table id="example3" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="active">
                                                            <input type="checkbox" class="select-all checkbox" id="selectAll2" name="select-all2" />
                                                        </th>
                                                        <th>#</th>
                                                        <th>رقم الفاتورة </th>
                                                        <th>التاريخ </th>
                                                        <th>نوع الفاتورة</th>
                                                        <th>الحالة</th>

                                                        <th>اسم العميل</th>
                                                        <th>إجمالى صافى </th>
                                                        <th>خيارات</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($relaydata as $index=>$row)
                                                    <tr>
                                                        <td class="active">
                                                            <input type="checkbox" class="select-item checkbox" name="select-item" value="1000" />
                                                        </td>
                                                        <th>{{ $index + 1 }}</th>
                                                        <th>1001</th>
                                                        <th>{{ $row->invoice_no}}</th>
                                                        <th>{{date('Y-m-d', strtotime($row->date))}} </th>
                                                        <th>{{ $row->type->name ?? ''}}</th>
                                                        <th>@if($row->status==1) تم الترحيل @else لم يتم الترحيل @endif</th>


                                                        <th> {{ $row->client->name ?? ''}}</th>
                                                        <th>{{ $row->total}}</th>

                                                        <th>
                                                            <a href="invoices-edit.html" title="عرض" class="btn btn-success"><i class="fas fa-edit text-white"></i></a>
                                                            <button type="button" title="الغاء" class="btn btn-danger" data-toggle="modal" data-target="#del"><i class="fas fa-trash-alt"></i></button>
                                                        </th>
                                                         <!-- Delete Modal -->
    <div class="modal fade dir-rtl" id="del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-danger">
                    <h5 class="modal-title" id="exampleModalLabel">تأكيد الإلغاء</h5>
                    <button type="button" class="close m-0 p-0 text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
                </div>
                <div class="modal-body text-center">
                    <h3><i class="fas fa-fire text-danger"></i></h3>
                    <h4 class="text-danger">الغاء ترحيل جميع البيانات ؟</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-danger">تأكيد</button>
                </div>
            </div>
        </div>
    </div>
                                                    </tr>
@endforeach

                                                </tbody>
                                            </table>
                                            {{$relaydata->render()}}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.col -->
@endsection
@section('scripts')
<script>
    //button select all or cancel
    $('#selectAll').click(function(e) {
        var table = $(e.target).closest('table');
        $('td input:checkbox', table).prop('checked', this.checked);
    });
    $('#selectAll2').click(function(e) {
        var table = $(e.target).closest('table');
        $('td input:checkbox', table).prop('checked', this.checked);
    });

    $(function() {
        $("#example1").DataTable({
    destroy: true,
    paging: false,
    searching: true,
} );
        $("#example3").DataTable({
    destroy: true,
    paging: false,
    searching: true,
} );
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });
    $(document).on("keypress", ".TabOnEnter", function(e) {
        //Only do something when the user presses enter
        if (e.keyCode == 13) {
            var nextElement = $('[tabindex="' + (this.tabIndex + 1) + '"]');
            console.log(this, nextElement);
            if (nextElement.length)
                nextElement.focus()
            else
                $('[tabindex="1"]').focus();
        }
    });
</script>
@endsection
