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
                <div id="preIndex" class="card-body ">
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

    // $('.myform').append('{{ csrf_field() }}');
    // $('.myform').append('{{ method_field('DELETE') }}');

        $('#example1').DataTable({
            destroy: true,
            paging: false
        });

        function search() {

            var search = $('#search_name').val();
            $.ajax({
                type: 'GET',
                data: {

                    search_name: search,

                },
                url: "{{ route('searchClient.fetch') }}",

                success: function(data) {

                    $('#preIndex').html(data);
                    $("#search_name").val(search);
                    $('body').persianNum({
              numberType: 'arabic'
          });
        //   $('#example1').DataTable({
        //     destroy: true,
        //     paging: false
        // });
        $('#example1').DataTable().ajax.reload();
                },
                error: function(request, status, error) {

                    $("#search_name").val(search);



                }
            });
            $('body').persianNum({
              numberType: 'arabic'
          });

        }
    </script>
@endsection
