<?php


$counter = 1;

?>
<?php
$counterrrr = 1;
?>

@foreach($invItems as $i=> $itemo)
<tr data-id="{{$counter}}">
    <input type="hidden" name="counter" value="{{$counter}}">
    <td> <input style="width: 30px;" type="text" readonly id="firstTT{{$counter}}" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($counter)}}"></td>
    <td>
        {{-- <div class="input-mark-inner mg-b-22">
            <select class="js-example-basic-single" id="select{{$counter}}" name="select{{$counter}}" onchange="editSelectVal({{$counter}})"  style='width: 150px;'>
                <option value="">اختر</option>
            @foreach ($items as $Item)
            <option value="{{$Item->id}}" {{ ( $Item->id == $itemo->item_id) ? 'selected' : '' }} >{{$Item->code}}/{{$Item->name}}</option>
            @endforeach
        </select>
     </div> --}}
     <div class="input-mark-inner mg-b-22">
        <input type="number" style="display: none;" value="{{$itemo->id}}" name="item_invoice_id{{$counter}}" id="item_invoice_id{{$counter}}" class="form-control " placeholder="">
        <input type="text" id="itemCode{{$counter}}" readonly value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($itemo->item->code ?? ' ')}}"  name="select{{$counter}}" onchange="editSelectVal({{$counter}})"  class="form-control " placeholder="">
    </div>
    </td>
    {{-- <td id="ar_name{{$counter}}" style='width: 200px;'></td> --}}
    <td id="desc{{$counter}}" style='width: 200px;'>{{$itemo->item->name ?? ''}}</td>

    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="text"    id="opPermission{{$counter}}" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($itemo->op_permission_no)}}" name="upopPermission{{$counter}}" oninput="opPermission({{$counter}})"  class="form-control oppermission" placeholder="">
        </div>
    </td>
    <td style='width: 150px;'>
        <div class="input-mark-inner mg-b-22">
            <input type="text"  class="form-control" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($itemo->quantity)}}" oninput="itemQty({{$counter}})" name="upqty{{$counter}}" id="qty{{$counter}}"  placeholder="">
        </div>
    </td>

    <td style='width: 150px;'>
        <div class="input-mark-inner mg-b-22">
            <input type="text"  id="itemprice{{$counter}}" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($itemo->price)}}" name="upitemprice{{$counter}}" oninput="itemPrice({{$counter}})" class="form-control" placeholder="">
        </div>
    </td>

    <td  class="total_item_price" style='width: 180px;'>

    <div class="input-mark-inner mg-b-22">
        <input type="text"  id="total{{$counter}}" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($itemo->total)}}"  name="uptotal{{$counter}}" oninput="totaly({{$counter}})" class="form-control" placeholder="">
    </div>
    </td>

    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="text" name="detNote{{$counter}}" value="{{Alkoumi\LaravelArabicNumbers\Numbers::ShowInArabicDigits($itemo->note)}}" onkeydown="enterForRow(event,{{$counter}})" class="form-control" placeholder="">
        </div>
    </td>
    <td>
        <div class="product-buttons">
            <button type="button"  data-toggle="modal" data-target="#del{{$counter}}" title="Trash" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
        </div>
        <!--Delete-->
        <div id="del{{$counter}}" class="modal modal-edu-general fullwidth-popup-InformationproModal fade " role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header header-color-modal bg-color-2">
                        <h4 class="modal-title" style="text-align:right">حذف بيانات الصنف</h4>
                        <div class="modal-close-area modal-close-df">
                            <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                        </div>
                    </div>
                    <div class="modal-body">
                        <span class="educate-icon educate-danger modal-check-pro information-icon-pro"> </span>
                        <h2></h2>
                        <h4>هل تريد حذف جميع بيانات الصنف ؟ </h4>
                    </div>
                    <div class="modal-footer info-md">
                        <a data-dismiss="modal" class="btn btn-secondary" href="#">إلغــاء</a>
                        <a href="#" class="btn btn-danger" onclick="DeleteInvoiceItem({{$itemo->id}},{{$counter}})">حـذف</a>
                    </div>
                </div>
            </div>
        </div>
        <!--/Delete-->
    </td>
<input type="hidden" id="ex_code{{$counter}}" >
</tr>
<?php
++$counter;

if ($counter > count($invItems)) {
?>
    @break
<?php }
$counterrrr++;
?>

@endforeach
<input type="number" style="display: none;" value="{{$counterrrr}}" name="qqq" class="form-control item_quantity" placeholder="">

