@extends('layout.web')

@section('title', 'العملاء')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">سجل العملاء</h3>
                    @can('clients-create')
                        <h3 class="card-title float-sm-left"><a href="{{ route('clients.create') }}"
                                class="btn btn-success">إضافة</a></h3>
                    @endcan
                </div>
                <!-- /.card-header -->
                <div id="preIndex" class="card-body">
                    @include('admin.clients.preIndex')

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


    </script>
@endsection
