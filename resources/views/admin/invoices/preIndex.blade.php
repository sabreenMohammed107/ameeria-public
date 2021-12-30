<table id="example1" class="table table-bordered table-striped arabic">
    <thead>
        <tr>
            <th>#</th>
            <th>رقم الفاتورة </th>
            <th>التاريخ </th>
            <th>نوع الفاتورة</th>
            <th>الحالة</th>

            <th>اسم العميل</th>
            <th>إجمالى صافى </th>
            <th>تعديل</th>
            {{-- <th>تقرير</th> --}}
            <th>حذف</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
            <tr>
                <th>{{ $index + 1 }}</th>
                <th>{{ $row->invoice_no }}</th>
                <th>{{ date('Y-m-d', strtotime($row->date)) }} </th>
                <th>{{ $row->type->name ?? '' }}</th>
                <td>@if($row->status==1) تم الترحيل @elseif ($row->status==0) لم يتم الترحيل
                    @elseif ($row->status==2)تم إلغاء الترحيل
                @endif</td>
                <th> {{ $row->client->name ?? '' }}</th>
                <th>{{ $row->total }}</th>
                <th>
                    @can('invoices-edit')
                    <a href="{{ route('invoices.edit', $row->id) }}" class="btn btn-success"><i
                            class="fas fa-edit text-white"></i></a>

                            @endcan
                </th>
                {{-- <th>
                    @can('invoices-edit')
                    <a href="{{ route('invoices.show', $row->id) }}" class="btn btn-success"><i
                            class="fas fa-book"></i></a>

                            @endcan
                </th> --}}
                <th>
                    @can('invoices-delete')
                    <button type="button" @if($row->status==1) disabled @endif class="btn btn-danger" data-toggle="modal"
                        data-target="#del{{ $row->id }}"><i class="fas fa-trash-alt"></i></button>
                        @endcan
                </th>
            </tr>
            <!-- Delete Modal -->
            <div class="modal fade dir-rtl" id="del{{ $row->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('invoices.destroy', $row->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header bg-gradient-danger">
                                <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>
                                <button type="button" class="close m-0 p-0 text-white"
                                    data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <h3><i class="fas fa-fire text-danger"></i></h3>
                                <h4 class="text-danger">حذف جميع البيانات ؟</h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">إلغاء</button>
                                <button type="submit" class="btn btn-danger">تأكيد</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </tbody>
</table>
