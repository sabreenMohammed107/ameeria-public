
 <form  action="{{ route('searchClient.fetch') }}" method="GET">
 <div class="row">
    <div class="col-sm-3">
<div class="form-group">
    <input type="text" class="form-control" value="{{request()->get('search_name','')}}" name="search_name"  id="search_name"
        placeholder="ابحث هنا">
</div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">


<input type="submit"  class="btn btn-primary"  value="بحث">

        </div>
    </div>
 </div>

</form>
<table id="" class="table table-bordered table-striped arabic">
    <thead class="bg-info">
        <tr>
            {{-- <th>#</th> --}}
            <th>اسم العميل</th>
            <th>حساب عام</th>

            <th>حساب مساعد </th>
            <th>سجل تجارى</th>
            <th> التسجيل الضريبي</th>
            <th>موبايل</th>

            <th>خيارات</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
            <tr>
                {{-- <th>{{ $index + 1 }}</th> --}}
                <th>{{ $row->name }} </th>
                <th>{{ $row->general_account }}</th>
                <th>{{ $row->help_account }}</th>

                <th>{{ $row->commercial_register }}</th>
                <th>{{ $row->tax_registration }}</th>
                <th>{{ $row->phone }}</th>
                <th>
                    @can('clients-edit')
                        <a href="{{ route('clients.edit', $row->id) }}" class="btn btn-info"><i
                                class="fas fa-edit text-white"></i></a>
                    @endcan
                    @can('clients-delete')
                        <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#del{{ $row->id }}"><i class="fas fa-trash-alt"></i></button>

                     <!--Delete-->
		 <div id="del{{$row->id}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-danger">
                        <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>                        <div class="modal-close-area modal-close-df">
                            <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                        </div>
                    </div>
                    <div class="modal-body text-center">
                        <h3><i class="fas fa-fire text-danger"></i></h3>
                        <h4 class="text-danger">حذف جميع البيانات ؟</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">إلغاء</button>
                        		<form id="delete" style="display: inline;" action="{{route('clients.destroy', $row->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">حذف</button>
                                </form>
                    </div>
                </div>
            </div>
        </div>
		<!--/Delete-->
                    @endcan
                </th>

            </tr>
        @endforeach
    </tbody>
</table>
{{-- {{ $data->render() }} --}}
<div id="categoryAll" class="pagination justify-content-center"  >

    {{ $data->appends(request()->input())->links()}}
    </div>

