@extends('layout.web')

@section('title', 'الفواتير')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">الفواتير</h3>

                </div>
                <div class="card-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <form  method="POST" target="_blank" action="{{route('invoice-report')}}" class="dropzone dropzone-custom needsclick addcourse"
                            id="send_data">
@csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label class=""> التاريخ من</label>
                                        <input name="from" id="from" value="" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label class=""> التاريخ الى</label>
                                        <input name="to" id="to" value="" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>نوع الفاتورة</label>
                                        <select class="custom-select"  id="invoice_type"
                                            name="type_id">
                                            <option value="">اختر</option>
                                            @foreach ($invoiceType as $type)
                                                <option {{old('type_id') ==$type->id ? 'selected' : ""}} value="{{ $type->id }}">
                                                    {{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mt-4">
                                        <button id="send_form" name="action" value="search"  class="btn btn-primary">بحث</button>
                                        {{-- <button id="report_form" name="action" type="submit" value="report"  class="btn btn-primary">تقرير</button> --}}

                                    </div>
                                </div>
                                <hr>

                            </div>

                        </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body" id="preIndex">
                    @include('admin.reports.preIndex')
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

$(document).ready(function() {

$( '#send_form' ).on( 'click', function(e) {
e.preventDefault();

var token = $("#subCatToken").val();
let from = $('#from').val();
let to = $('#to').val();
let type =  $('#invoice_type option:selected').val();
$.ajax({
        url:"{{route('invoicesReport.search')}}",
        method: "get",
        data:
{
_token:token,
from:from,
    to:to,
    type:type,
},
        success: function(result) {


            $('#preIndex').html(result);
            $('#example1').DataTable()


        },

    });


});




});

</script>
@endsection
