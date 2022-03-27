
 <div class="row">
    <div class="col-sm-3">
<div class="form-group">
    <input type="text" class="form-control"  name="search-name" id="search_name"
        placeholder="ابحث هنا">
</div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
<input type="button" class="btn btn-primary" onclick="search()" value="بحث">
        </div>
    </div>
 </div>



<table id="" class="table table-bordered table-striped arabic">
    <thead class="bg-info">
        <tr>
            {{-- <th>#</th> --}}
            <th>كود الصنف</th>
            <th>اسم الصنف </th>
            <th>وحده الصرف </th>

            <th>سعر التكلفة </th>
            <th>سعر البيع </th>
            <th>خيارات</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $index => $row)
            <tr>
                {{-- Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($row->code) --}}
                {{-- <th>{{ $index + 1 }}</th> --}}
                <th>{{ $row->code }}</th>
                <th>{{ $row->name }}</th>
                <th>{{ $row->exchange->name ?? '' }}</th>

                <th>{{ $row->cost_price }}</th>
                <th>{{ $row->selling_price }}</th>
                @can('items-edit')
                    <th><a href="{{ route('items.edit', $row->id) }}" class="btn btn-info"><i
                                class="fas fa-edit text-white"></i></a>
                    @endcan
                    @can('items-delete')
                        <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#del{{ $row->id }}"><i class="fas fa-trash-alt"></i></button>
                    @endcan
                     <!-- Delete Modal -->
                <div class="modal fade dir-rtl" id="del{{ $row->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('items.destroy', $row->id) }}" method="POST">
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
                </th>



            </tr>
        @endforeach
    </tbody>
</table>
{{ $data->render() }}
