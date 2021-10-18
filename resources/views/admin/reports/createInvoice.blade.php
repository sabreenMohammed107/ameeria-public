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
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class=""> التاريخ من</label>
                                        <input name="from" id="from" value="" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class=""> التاريخ الى</label>
                                        <input name="to" id="to" value="" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mt-4">
                                        <button id="send_form"  type="submit" class="btn btn-primary">بحث</button>

                                    </div>
                                </div>
                                <hr>

                            </div>

                        </form>
                    </div>
                </div>
                <!-- /.card-header -->

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

    });

</script>
@endsection
