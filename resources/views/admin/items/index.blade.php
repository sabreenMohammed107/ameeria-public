@extends('layout.web')

@section('title', 'الأصناف')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">سجل الأصناف</h3>
                    @can('items-create')
                        <h3 class="card-title float-sm-left"><a href="{{ route('items.create') }}"
                                class="btn btn-success">إضافة</a></h3>
                    @endcan
                </div>
                <!-- /.card-header -->
                <div id="preIndex" class="card-body ">
                    @include('admin.items.preIndex')

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
            String.prototype.toArabicDigits = function() {
                var id = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
                return this.replace(/[0-9]/g, function(w) {
                    return id[+w];
                });
            };

        });
        $('#example1').DataTable({
            destroy: true,
            paging: false,
            search: false,
        });


        function search() {

            var search = $('#search_name').val();
            $.ajax({
                type: 'GET',
                data: {

                    search_name: search,

                },
                url: "{{ route('searchItem.fetch') }}",

                success: function(data) {

                    $('#preIndex').html(data);
                    $("#search_name").val(search);
                    $('body').persianNum({
              numberType: 'arabic'
          });
                },
                error: function(request, status, error) {

                    $("#search_name").val(search);



                }
            });
            $('body').persianNum({
              numberType: 'arabic'
          });        }
    </script>
@endsection
