
<tr data-id="{{$rowCount}}">
    <input type="hidden" name="rowCount" value="{{$rowCount}}" >
    <td> <input style="width: 30px;" type="number" readonly id="firstTT{{$rowCount}}"  value="{{$rowCount}}" ></td>

    <td>
        {{-- <div class="input-mark-inner mg-b-22">
            <select class="js-example-basic-single" tabindex="0" id="select{{$rowCount}}" name="select{{$rowCount}}" onchange="editSelectVal({{$rowCount}})"  style='width: 150px;'>
                <option value="">اختر</option>
            @foreach ($items as $Item)
            <option value="{{$Item->id}}">{{$Item->code}}/{{$Item->name}}</option>
            @endforeach
        </select>
     </div> --}}
     <div class="input-mark-inner mg-b-22">
        <input type="number"    id="itemCode{{$rowCount}}"  name="select{{$rowCount}}" onchange="editSelectVal({{$rowCount}})"  class="form-control " placeholder="">
    </div>
    </td>
    {{-- <td id="ar_name{{$rowCount}}" style='width: 200px;'></td> --}}
    <td id="desc{{$rowCount}}" style='width: 200px;'></td>

    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number"    id="opPermission{{$rowCount}}"  name="opPermission{{$rowCount}}" oninput="opPermission({{$rowCount}})"  class="form-control oppermission" placeholder="">
        </div>
    </td>
    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number"  class="form-control" oninput="itemQty({{$rowCount}})" name="qty{{$rowCount}}" id="qty{{$rowCount}}"  placeholder="">
        </div>
    </td>

    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="number"  id="itemprice{{$rowCount}}"  name="itemprice{{$rowCount}}" oninput="itemPrice({{$rowCount}})" class="form-control" placeholder="">
        </div>
    </td>

    <td  class="total_item_price" style='width: 120px;'>

    <div class="input-mark-inner mg-b-22">
        <input type="number"  id="total{{$rowCount}}"  name="total{{$rowCount}}" oninput="totaly({{$rowCount}})" class="form-control" placeholder="">
    </div>
    </td>

    <td>
        <div class="input-mark-inner mg-b-22">
            <input type="text" name="notes{{$rowCount}}" onkeydown="enterForRow(event,{{$rowCount}})" class="form-control" placeholder="">
        </div>
    </td>
    <td>
        <div class="product-buttons">
            <button id="del{{$rowCount}}" onclick="deleteRow({{$rowCount}})" type="button" class="btn btn-danger" data-toggle="modal" data-target="#del"><i class="fas fa-trash-alt"></i></button>
        </div>
    </td>
<input type="hidden" id="ex_code{{$rowCount}}" >
</tr>

