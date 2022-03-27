@extends('layout.web')

@section('title', 'الفواتير')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">الفواتير</h3>
                    @can('invoices-create')
                    <h3 class="card-title float-sm-left"><a href="{{ route('invoices.create') }}"
                            class="btn btn-success">إضافة</a></h3>
                            @endcan
                </div>
                <div class="card-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <form  method="POST" action="javascript:void(0)" class="dropzone dropzone-custom needsclick addcourse"
                            id="send_data">
                            <input type="hidden" value="{{csrf_token()}}" id="subCatToken"/>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label class=""> التاريخ من</label>
                                        <input name="from" id="from" value="" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label class=""> التاريخ الى</label>
                                        <input name="to" id="to" value="" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label class=""> رقم الفاتورة</label>
                                        <input name="invoice_no" id="invoice_no" value="" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
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
                                        <button id="send_form" type="submit" class="btn btn-primary">بحث</button>

                                    </div>
                                </div>
                                <hr>

                            </div>

                        </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body" id="preIndex">
                    @include('admin.invoices.preIndex')
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

        $( '#send_data' ).on( 'submit', function(e) {
        e.preventDefault();
        var token = $("#subCatToken").val();
        let from = $('#from').val();
        let to = $('#to').val();
        let invoice_no=$('#invoice_no').val();
        let type =  $('#invoice_type option:selected').val();
     $.ajax({
                url:"{{route('invoices.search')}}",
                method: "POST",
                data:
	{
		_token:token,
        from:from,
            to:to,
            type:type,
            invoice_no:invoice_no,
    },
                success: function(result) {
                    // $('#example1').DataTable('destroy');

                    $('#preIndex').html(result);
                    // $('#example1').DataTable();
                    $('#exampleInv').DataTable( {
    destroy: true,
    paging: false,
    order:false,
} );
                    $('body').persianNum({
              numberType: 'arabic'
          });


                }
            });


   });


    });

    $('#exampleInv').DataTable( {
    destroy: true,
    paging: false,
    order:false,
} );
function report(){
    form.submit();
}
</script>
@endsection
