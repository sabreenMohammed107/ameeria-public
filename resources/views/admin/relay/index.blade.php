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
                                            <a class="nav-link active" id="custom-tabs-one-1-tab" data-toggle="pill"
                                                href="#custom-tabs-one-1" role="tab" aria-controls="custom-tabs-one-1"
                                                aria-selected="true"> الفواتير الجاهزة للترحيل</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-2-tab" data-toggle="pill"
                                                href="#custom-tabs-one-2" role="tab" aria-controls="custom-tabs-one-2"
                                                aria-selected="false">الفواتير التى تم ترحيلها</a>
                                        </li>

                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">

                                        <div class="tab-pane fade show active" id="custom-tabs-one-1" role="tabpanel"
                                            aria-labelledby="custom-tabs-one-1-tab">
                                            <form action="{{ route('relay.store') }}" method="POST">
                                                @csrf
                                                <!-- <div class="card-body">
                                                    <button type="submit" class="btn btn-primary" style="float: left;">ترحيل الى مصلحة الضرائب</button>
                                                </div> -->
                                                <div class="card card-primary">
                                                    <table id="example1" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                {{-- <th class="active">
                                                                <input type="checkbox" class="select-all checkbox" id="selectAll" name="" />
                                                            </th> --}}
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
                                                            @foreach ($data as $index => $row)
                                                                {{-- <tr>
                                                            <td class="active">
                                                                <input type="checkbox" class="select-item checkbox" name="invoices[]" value="{{ $row->id }}" />
                                                            </td> --}}
                                                                <td>{{ Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($index + 1) }}
                                                                </td>
                                                                <td>{{ Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->invoice_no) }}
                                                                </td>
                                                                <td>{{  Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits( date('d-m-Y', strtotime($row->date)) )}} </td>
                                                                <td>{{ $row->type->name ?? '' }}</td>
                                                                <td>
                                                                    @if ($row->status == 1) تم الترحيل
                                                                    @elseif ($row->status == 0) لم يتم الترحيل
                                                                    @elseif ($row->status == 2)تم إلغاء
                                                                        الترحيل
                                                                    @endif
                                                                </td>
                                                                <td> {{ $row->client->name ?? '' }}</td>
                                                                <td>{{ Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->total) }}
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('relay.show', $row->id) }}"
                                                                        title="عرض الفاتورة"
                                                                        class="btn btn-success  btn-sm"><i
                                                                            class="fas fa-eye text-white"></i></a>
                                                                </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer">
                                                    {{ $data->render() }}
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-one-2" role="tabpanel"
                                            aria-labelledby="custom-tabs-one-2-tab">
                                            <div class="card card-primary">
                                                <table id="example3" class="table table-bordered table-striped">

                                                    <thead>
                                                        <tr>
                                                            {{-- <th class="active">
                                                            <input type="checkbox" class="select-all checkbox" id="selectAll2" name="select-all2" />
                                                        </th> --}}
                                                            <th>#</th>
                                                            <th>رقم الفاتورة </th>
                                                            <th>تاريخ الترحيل </th>
                                                            <th>التاريخ </th>


                                                            <th>نوع الفاتورة</th>
                                                            <th>الحالة</th>
                                                            <th>اسم العميل</th>
                                                            <th>إجمالى صافى </th>
                                                            <th>خيارات</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($relaydata as $index => $row)
                                                            <?php
                                                            $relay = $row->relay_date;
                                                            $relay = str_replace('/', '-', $relay);
                                                            // echo date('Y-m-d', strtotime($relay));
                                                            ?>
                                                            <tr>
                                                                {{-- <td class="active">
                                                            <input type="checkbox" class="select-item checkbox" name="select-item" value="1000" />
                                                        </td> --}}
                                                                <th>{{ Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($index + 1) }}
                                                                </th>
                                                                <th>{{ Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->invoice_no) }}
                                                                </th>
                                                                <th> {{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits( date('d-m-Y', strtotime($relay)) )}}</th>
                                                                <th>{{ Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits( date('d-m-Y', strtotime($row->date))) }} </th>

                                                                <th>{{ $row->type->name ?? '' }}</th>
                                                                <td>
                                                                    @if ($row->status == 1) تم الترحيل
                                                                    @elseif ($row->status == 0) لم يتم الترحيل
                                                                    @elseif ($row->status == 2)تم إلغاء
                                                                        الترحيل
                                                                    @endif
                                                                </td>
                                                                <th> {{ $row->client->name ?? '' }}</th>
                                                                <th>{{ Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->total) }}
                                                                </th>
                                                                <th>
                                                                    <a href="{{ route('relay.show', $row->id) }}"
                                                                        title="عرض الفاتورة"
                                                                        class="btn btn-success btn-sm"><i
                                                                            class="fas fa-eye"></i></a>


                                                                    <a href="https://invoicing.eta.gov.eg/documents/{{ $row->invoice_document_id }}/share/{{ $row->invoice_long_id }}"
                                                                        target="_blank" title="الفاتورة الخارجية"
                                                                        class="btn btn-info btn-sm"><i
                                                                            class="fas fa-share"></i></a>
                                                                    {{-- <button type="button" @if ($row->relay_date && Carbon\Carbon::now()->subDays(3) > Carbon\Carbon::parse($row->relay_date)) disabled @endif class="btn btn-danger btn-sm" title="الغاء الفاتورة" data-toggle="modal" data-target="#cancelation_{{$row->id}}"><i class="fas fa-times"></i>
                                                               </button> --}}

                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        title="الغاء الفاتورة" data-toggle="modal"
                                                                        data-target="#cancelation_{{ $row->id }}"><i
                                                                            class="fas fa-times"></i>
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                            <div class="modal fade dir-rtl"
                                                                id="cancelation_{{ $row->id }}" tabindex="-1"
                                                                role="dialog" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <form action="{{ route('relay.destroy', $row->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <div class="modal-content">
                                                                            <div class="modal-header bg-gradient-danger">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">تأكيد الإلغاء
                                                                                </h5>
                                                                                <button type="button"
                                                                                    class="close m-0 p-0 text-white"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body text-center">
                                                                                <h3><i class="fas fa-fire text-danger"></i>
                                                                                </h3>
                                                                                <h4 class="text-danger">الغاء الفاتورة من
                                                                                    المصلحة؟</h4>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">إلغاء</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">تأكيد</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                                {{ $relaydata->render() }}
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
        // $('#selectAll').click(function(e) {
        //     var table = $(e.target).closest('table');
        //     $('td input:checkbox', table).prop('checked', this.checked);
        // });
        // $('#selectAll2').click(function(e) {
        //     var table = $(e.target).closest('table');
        //     $('td input:checkbox', table).prop('checked', this.checked);
        // });

        $(function() {
            $("#example1").DataTable({
                destroy: true,
                paging: false,
                searching: true,
            });
            $('body').persianNum({
                numberType: 'arabic'
            });
            $("#example3").DataTable({
                destroy: true,
                paging: false,
                searching: true,
                "order": [
                    [2, 'desc']
                ]
            });
            $('body').persianNum({
                numberType: 'arabic'
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
            $('body').persianNum({
                numberType: 'arabic'
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
            $('body').persianNum({
                numberType: 'arabic'
            });
        });
    </script>
@endsection
