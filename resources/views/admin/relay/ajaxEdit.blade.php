<?php


$counter = 1;

?>
<?php
$counterrrr = 1;
?>

@foreach($invItems as $i=> $itemo)
<tr data-id="{{$counter}}">
    <input type="hidden" name="counter" value="{{$counter}}">
    <td> <input style="width: 30px;" type="number" readonly id="firstTT{{$counter}}" value="{{$counter}}"></td>
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
        <input type="number" id="itemCode{{$counter}}" readonly value="{{$itemo->item->code ?? 'vv'}}"  name="select{{$counter}}" onchange="editSelectVal({{$counter}})"  class="form-control " placeholder="">
    </div>
    </td>
    {{-- <td id="ar_name{{$counter}}" style='width: 200px;'></td> --}}
    <td id="desc{{$counter}}" style='width: 200px;'>{{$itemo->item->name ?? ''}}</td>

    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" readonly   id="opPermission{{$counter}}" value="{{$itemo->op_permission_no}}" name="upopPermission{{$counter}}" oninput="opPermission({{$counter}})"  class="form-control oppermission" placeholder="">
        </div>
    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" readonly  class="form-control" value="{{$itemo->quantity}}" oninput="itemQty({{$counter}})" name="upqty{{$counter}}" id="qty{{$counter}}"  placeholder="">
        </div>
    </td>

    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number" readonly id="itemprice{{$counter}}" value="{{$itemo->price}}" name="upitemprice{{$counter}}" oninput="itemPrice({{$counter}})" class="form-control" placeholder="">
        </div>
    </td>

    <td  class="total_item_price" style='width: 160px;'>

    <div class="input-mark-inner mg-b-22">
        <input type="number"  readonly id="total{{$counter}}" value="{{$itemo->total}}"  name="uptotal{{$counter}}" oninput="totaly({{$counter}})" class="form-control" placeholder="">
    </div>
    </td>

    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="text" readonly name="detNote{{$counter}}" value="{{$itemo->note}}" onkeydown="enterForRow(event,{{$counter}})" class="form-control" placeholder="">
        </div>
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

