@extends('layout.web')


@section('content')

    <div class="row dir-rtl">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i> إضافه فاتورة
                    </h3>
                </div>
                <div class="card card-primary">

                    <form class="form-group" action="{{ route('invoices.update',$inv->id) }}" id="form-id" method="post">
                        @method('PUT')

                        @csrf
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 shadow mg-b-15">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label> رقم الفاتورة</label>
                                                <input type="number" name="invoice_no" value="{{$inv->invoice_no}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>تاريخ الفاتورة</label>
                                                <input type="date" name="date" value="{{date('Y-m-d', strtotime($inv->date))}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>نوع الفاتورة</label>
                                                {{-- <select class="custom-select"  onchange="editSelectType()" id="invoice_type"
                                                    name="type_id">
                                                    <option value="">اختر</option>
                                                    @foreach ($invoiceType as $type)
                                                        <option value="{{ $type->id }}" {{ ( $type->id == $inv->type_id) ? 'selected' : '' }} >
                                                            {{ $type->name }}</option>
                                                    @endforeach
                                                </select> --}}
                                                <input type="hidden" value="{{$inv->type->id ?? ''}}" id="invoice_type"  readonly class="form-control">

                                                <input type="text" value="{{$inv->type->name ?? ''}}"  readonly name="invoice_type" readonly class="form-control">

                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>الحالة</label>
                                                <input type="text" value="@if($inv->status==1) تم الترحيل @else لم يتم الترحيل @endif" name="status" readonly class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label> ملاحظات </label>
                                                <input name="notes" value="{{$inv->notes}}" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">

                                            <div class="form-group mt-4">
                                                <label> </label>
                                                <input type="checkbox" class="" name="taxable" id=" taxable" @if($inv->taxable==1) checked @endif  >
                                                خاضع للضريبة

                                            </div>
                                        </div>
                                        <div class="col-sm-2 ">
                                            <div class="form-group mt-4">

                                                <input type="radio" name="tab" value="igotnone" readonly @if($inv->person_type==1) checked @endif
                                                    onclick="show1();" /> مؤسسة
                                                <input type="radio" name="tab" value="igottwo" readonly onclick="show2();" @if($inv->person_type==0) checked @endif /> شخص
                                            </div>
                                        </div>

                                        <div id="div1" class="col-sm-10  @if($inv->person_type==0) hide @endif">
                                            <div class="row">
                                                <div class="col-md-2 col-sm-6">
                                                    <div class="form-group">
                                                        <label> حساب عام / مساعد</label>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6">
                                                                <input type="text" id="general" readonly value="{{$inv->client->general_account ?? ''}}" name=""
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-6 col-sm-6">
                                                                <input type="text" id="help"  readonly value="{{$inv->client->help_account ?? ''}}" name=""
                                                                    class="form-control">
                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>
                                                <input type="hidden" name="client_id" id="client_id">
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="form-group">
                                                        <label>اسم العميل </label>
                                                        <input readonly value="{{$inv->client->name ?? ''}}" id="clientName" type="text"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="form-group">
                                                        <label>سجل تجاري </label>
                                                        <input readonly value="{{$inv->client->commercial_register ?? ''}}" id="clientcommerical" type="text"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="form-group">
                                                        <label>العنوان </label>
                                                        <input readonly value="{{$inv->client->address ?? ''}}" id="clientAddress" type="text"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <style>
                                            .hide {
                                                display: none;
                                            }

                                        </style>
                                        <div id="div2" class=" @if($inv->person_type==1) hide @endif">
                                            <div class="row">
                                                <div class="col-md-5 col-sm-6">
                                                    <div class="form-group">
                                                        <label>اسم الشخص </label>
                                                        <input type="text" readonly value="{{$inv->person_name}}" name="person_name" class="form-control">
                                                    </div>
                                                    </div>
                                                <div class="col-md-5 col-sm-6">
                                            <div class="form-group">
                                                <label>الرقم القومى </label>
                                                <input type="text" readonly name="person_nid" {{$inv->person_nid}} class="form-control">
                                            </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="card-body">
                            <button id="btntbl" type="button" class="btn btn-primary waves-effect waves-light mb-1">إضافة
                                صنف</button>

                            <table id="example5" class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>#</th>
                                        <th>الكود</th>
                                        <th>اسم الصنف</th>

                                        {{-- <th>الوصف</th> --}}



                                        <th data-name="operation">رقم اذن التشغيل</th>
                                        <th>الكمية</th>

                                        <th data-name=price>سعر الصنف</th>
                                        <th>اجمالى</th>
                                        <th>ملاحظات</th>

                                        <th>حذف</th>
                                    </tr>
                                </thead>
                                <tbody id="rows">

                                    @include('admin.invoices.ajaxEdit')
                                </tbody>
                            </table>

                            <!-- Static Table End -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
                                        <div class="card-body">
                                            <div class="row">



                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 shadow mg-b-15">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label> اجمالى</label>
                                                        <input readonly id="total_items_price" value="{{$inv->subtotal}}" name="subtotal" type="number"
                                                            class="form-control">
                                                    </div>
                                                </div>



                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label> اجمالى ضريبه القيمه المضافه</label>
                                                        <input readonly type="text" value="{{$inv->tax}}" id="total_tax" name="tax"
                                                            class="form-control">
                                                    </div>
                                                </div>


                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label> اجمالى العام </label>
                                                        <input readonly type="text" value="{{$inv->total}}" id="total_all" name="total"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="taxVal" value="{{ $tax->value }}" style="">
                            <!-- End -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                                <a href="" class="btn btn-secondary">رجوع</a>
                            </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.col -->
    @endsection
    @section('scripts')
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>        <script type="text/javascript">


            $(document).ready(function() {



                editSelectType();

                    $('input[type=checkbox][name=taxable]').change(function() {
                        $taxVal = $('#taxVal').val();
                        var tax = parseFloat($('#total_items_price').val()) * $taxVal;
                        if (this.checked) {


                            $('#total_tax').val(tax.toFixed(2));
                            $('#total_all').val(parseFloat($('#total_items_price').val()) + parseFloat(tax));
                        } else {
                            $('#total_tax').val(0.00);
                            $('#total_all').val($('#total_items_price').val());
                        }
                    });

                    //Enter Key
                    $('body').on('keypress', 'input, select', function(e) {
                        if (e.key === "Enter") {
                            event.preventDefault();
                            var self = $(this),
                                form = self.parents('form:eq(0)'),
                                focusable, next;
                            focusable = form.find('input,a,select,button,textarea,object').filter(':visible');
                            if (e.shiftKey) {
                                next = focusable.eq(focusable.index(this) - 1);

                            } else {
                                next = focusable.eq(focusable.index(this) + 1);

                            }
                            if (next.length) {
                                next.focus();
                            } else {
                                form.submit();
                            }
                            return false;
                        }

                    });
                    bsCustomFileInput.init();

                });



                $('#btntbl').on('click', function(e) {

                    var rowCount = 0;

                    if ($('#example5 > tbody  > tr').attr('data-id')) {
                        rowCount = $('#example5 > tbody  > tr:last').attr('data-id');

                    }


                    var rowSS = parseFloat(rowCount) + 1;



                    $.ajax({
                        type: 'GET',
                        async: false,
                        data: {
                            rowcount: parseFloat(rowCount) + 1,


                        },
                        url: "{{ url('addInvoiceRow/fetch') }}",

                        success: function(data) {

                            $('#rows').append(data);
                            // $("#select" + rowSS).select2();
                            // $('#selCode' + rowSS).select2();

                            $('#firstTT' + rowSS).focus();

                            console.log(rowSS);
                            editSelectType();


                        },

                        error: function(request, status, error) {


                        }
                    });
                });



                function addRow(url) {
                    var rowCount = 0;

                    if ($('#example5 > tbody  > tr').attr('data-id')) {
                        rowCount = $('#example5 > tbody  > tr:last').attr('data-id');

                    }


                    var rowSS = parseFloat(rowCount) + 1;



                    $.ajax({
                        type: 'GET',
                        async: false,
                        data: {
                            rowcount: parseFloat(rowCount) + 1,


                        },
                        url: "{{ url('addInvoiceRow/fetch') }}",

                        success: function(data) {

                            $('#rows').append(data);
                            // $("#select" + rowSS).select2();
                            // $('#selCode' + rowSS).select2();

                            $('#firstTT' + rowSS).focus();

                            console.log(rowSS);
                            editSelectType();
                        },

                        error: function(request, status, error) {


                        }
                    });
                }
                //on notes



                function show1() {

                    document.getElementById('div1').style.display = 'inline-flex';
                    document.getElementById('div2').style.display = 'none';
                }

                function show2() {
                    document.getElementById('div1').style.display = 'none';
                    document.getElementById('div2').style.display = 'inline-flex';
                }


                //in table
                function editSelectVal(index) {
                    debugger;

                    // var select_value = $('#select' + index + ' option:selected').val();
                    // var text = $('#select' + index + ' option:selected').text();

    var select_value = $('#itemCode' + index).val();
                    $.ajax({
                        type: 'GET',
                        data: {

                            select_value: select_value,

                        },
                        url: "{{ route('editSelectVal.fetch') }}",

                        success: function(data) {
                            var result = $.parseJSON(data);

                            $("#ar_name" + index + "").text(result[0]);
                            $("#desc" + index + "").text(result[1]);
                            $("#ex_code" + index + "").val(result[2]);

                            var price = $("#itemprice" + index + "").val();
                    var qty = $("#qty" + index + "").val();
                    if ($("#ex_code" + index + "").val() == 12) {
                        $("#total" + index + "").attr('value', (((price * qty) / 1000).toFixed(2)));

                    } else {
                        $("#total" + index + "").attr('value', (((price * qty)).toFixed(2)));

                    }
                    headCalculations(index);

                        },
                        error: function(request, status, error) {

                            $("#desc" + index + "").text('لا يوجد اسم ');
                            $("#ar_name" + index + "").text(' ');
                            $("#ex_code" + index + "").val(' ');

                        }
                    });





                }

                function itemPrice(index) {
                    var price = $("#itemprice" + index + "").val();
                    var qty = $("#qty" + index + "").val();
                    if ($("#ex_code" + index + "").val() == 12) {
                        $("#total" + index + "").attr('value', (((price * qty) / 1000).toFixed(2)));

                    } else {
                        $("#total" + index + "").attr('value', (((price * qty)).toFixed(2)));

                    }

                    headCalculations(index);
                    $("#itemprice" + index).attr('value', price);
                }

                function itemQty(index) {

                    var price = $("#itemprice" + index + "").val();
                    var qty = $("#qty" + index + "").val();
                    if ($("#ex_code" + index + "").val() == 12) {
                        $("#total" + index + "").attr('value', (((price * qty) / 1000).toFixed(2)));

                    } else {
                        $("#total" + index + "").attr('value', (((price * qty)).toFixed(2)));

                    }


                    headCalculations(index);
                    $("#qty" + index).attr('value', qty);




                }

                function totaly(index) {
                    var tot = $("#total" + index + "").val();

                    $("#total" + index + "").attr('value', tot);



                    headCalculations(index);
                    $("#total" + index).attr('value', tot);




                }

                function deleteRow(index) {
                    //delete Row

                    $('tr[data-id=' + index + ']').remove();

                    headCalculations(index);
                }
                // headCalculations(index);
                function headCalculations(index) {
                    index = $('#example5 > tbody > tr').length;
                    $taxVal = $('#taxVal').val();
                    var tax = 0;
                    var total = 0;



                    $('#example5 > tbody > tr').each(function() {
                        var row_num = $(this).attr('data-id');
                        total += parseFloat($('#total' + row_num).val());
                        tax += parseFloat($('#total' + row_num).val() * $taxVal);


                        --index;
                    })


                    $('#total_items_price').val(total.toFixed(2));
                    console.log(tax);
                    if ($('input[type=checkbox][name=taxable]').is(':checked')) {
                        console.log("checked");
                        $('#total_tax').val(tax.toFixed(2));
                        $('#total_all').val(parseFloat(total) + parseFloat(tax));
                    } else {
                        console.log("unchecked");
                        $('#total_tax').val(0.00);
                        $('#total_all').val(parseFloat(total));
                    }

                }




                function enterForRow(e, index) {
                    if (e.keyCode == 13) {
                        addRow();

                    }
                }

                //main page
                $('#general').on('change', function() {

                    var general_value = $(this).val();
                    var help_value = $('#help').val();

                    $.ajax({
                        type: 'GET',
                        data: {

                            general_value: general_value,
                            help_value: help_value,

                        },
                        url: "{{ route('selectClient.fetch') }}",

                        success: function(data) {
                            var result = $.parseJSON(data);

                            $("#clientName").val(result[0]);
                            $("#clientcommerical").val(result[1]);
                            $("#clientAddress").val(result[2]);


                        },
                        error: function(request, status, error) {
                            $("#clientName").val(' ');
                            $("#clientcommerical").val(' ');
                            $("#clientAddress").val(' ');

                        }
                    });


                });


                $('#help').on('change', function() {

                    var general_value = $('#general').val();
                    var help_value = $(this).val();

                    $.ajax({
                        type: 'GET',
                        data: {

                            general_value: general_value,
                            help_value: help_value,

                        },
                        url: "{{ route('selectClient.fetch') }}",

                        success: function(data) {
                            var result = $.parseJSON(data);

                            $("#clientName").val(result[0]);
                            $("#clientcommerical").val(result[1]);
                            $("#clientAddress").val(result[2]);
                            $("#client_id").val(result[3]);


                        },
                        error: function(request, status, error) {
                            $("#clientName").val(' ');
                            $("#clientcommerical").val(' ');
                            $("#clientAddress").val(' ');


                        }
                    });


                });

                //invoice type
                function editSelectType() {
                    debugger;

                    // var select_value = $('#invoice_type option:selected').val();
                    // var text = $('#invoice_type option:selected').text();

                     var select_value = $('#invoice_type').val();

                    if (select_value == 1) {


                        var target = $('table').find('th[data-name=operation]');
                        // Find its index among other ths
                        var index = (target).index();
                        // For each tr, remove all th and td that match the index.
                        $('table tr').find('th:eq(' + index + '),td:eq(' + index + ')').show();

                        var target2 = $('table').find('th[data-name=price]');
                        // Find its index among other ths
                        var index2 = (target2).index();
                        // For each tr, remove all th and td that match the index.
                        $('table tr').find('th:eq(' + index2 + '),td:eq(' + index2 + ')').hide();

                    } else if (select_value == 2) {
                        var target = $('table').find('th[data-name=operation]');
                        // Find its index among other ths
                        var index = (target).index();
                        $('table tr').find('th:eq(' + index + '),td:eq(' + index + ')').hide();
                        var target2 = $('table').find('th[data-name=price]');
                        // Find its index among other ths
                        var index2 = (target2).index();
                        // For each tr, remove all th and td that match the index.
                        $('table tr').find('th:eq(' + index2 + '),td:eq(' + index2 + ')').hide();
                    } else {
                        var target = $('table').find('th[data-name=operation]');
                        // Find its index among other ths
                        var index = (target).index();
                        $('table tr').find('th:eq(' + index + '),td:eq(' + index + ')').hide();
                        var target2 = $('table').find('th[data-name=price]');
                        // Find its index among other ths
                        var index2 = (target2).index();
                        // For each tr, remove all th and td that match the index.
                        $('table tr').find('th:eq(' + index2 + '),td:eq(' + index2 + ')').show();
                    }



                }
                     // Delete DB row functions
    function DeleteInvoiceItem(id, index) {
             $("#del" + index).modal('hide');
        $('.modal-backdrop.fade.in').remove();
        $('.modal-open').css('overflow-y', 'scroll');
        $.ajax({
            type: 'GET',
            url: "{{url('/invoice/Remove/Item')}}",
            data: {
                id: id,
            },
            success: function(data) {

                headCalculations(index);
                location.reload(true);
            },
            error: function(request, status, error) {
                console.log(request.responseText);
            }
        });
        // headCalculations();
    }
            </script>
        @endsection

