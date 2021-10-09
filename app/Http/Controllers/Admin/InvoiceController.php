<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceType;
use App\Models\Item;
use App\Models\Setting;
use App\Models\Unit;
use DB;
use Illuminate\Http\Request;
use Log;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
class InvoiceController extends Controller
{

    public function __construct(Invoice $object)
    {
        $this->middleware('auth');
        // $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        // $this->middleware('permission:role-create', ['only' => ['create','store']]);
        // $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        $this->object = $object;
        $this->viewName = 'admin.invoices.';
        $this->routeName = 'invoices.';
        $this->message = 'تم حفظ البيانات';
        $this->errormessage = 'راجع البيانات هناك خطأ';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Invoice::orderBy('id', 'DESC')->get();
        return view('admin.invoices.index', compact('data'))
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoiceType = InvoiceType::all();
        $rowCount = 1;
        $items = Item::all();
        $exchanges = Unit::all();
        $tax=Setting::where('key','tax_value')->first();
        return view('admin.invoices.add', compact('invoiceType','tax', 'rowCount', 'items', 'exchanges'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //invoice items
        $count = $request->rowCount;

        $details = [];
        $price = 1;
        $qunty = 1;
        $disc = 0;
        for ($i = 1; $i <= $count; $i++) {
            $items = Item::where('code', $request->get('select' . $i))->first();
            $detail = [
                // 'exchange_unit_id' => $request->get('exchange_unit_id' . $i),
                'quantity' => $request->get('qty' . $i),
                'price' => $request->get('itemprice' . $i),
                'note' => $request->get('detNote' . $i),
                'op_permission_no'=>$request->get('opPermission' . $i),
                'total' => $request->get('total' . $i),
                'note' => $request->get('notes'. $i),


            ];
            if ( $items) {
                $detail['item_id'] = $items->id;
            }
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
        }

        //master
        $data = [
            'invoice_no' =>  $request->get('invoice_no'),
            'date' =>Carbon::parse($request->get('date')),
            'client_id' => $request->get('client_id'),
            'type_id' =>  $request->get('type_id'),
            'person_nid' =>  $request->get('person_nid'),
            'person_name' =>  $request->get('person_name'),
            'subtotal' => $request->get('subtotal'),
            'tax'=>$request->get('tax'),
            'total'=>$request->get('total'),
            'status' => 0,
            'notes' => $request->get('notes'),
            'user_type'=>1,

        ];
        if($request->get('tab') == 'igotnone'){

            $data['person_type'] = 1;


        }
        else{

            $data['person_type'] = 0;

        }
if($request->has('taxable')){
    $data['taxable'] = 1;
}
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $invoice = Invoice::create($data);
            foreach ($details as $Item) {

                $Item['invoice_id'] = $invoice->id;
                $Invoice_Item = InvoiceItem::create($Item);
            }

            DB::commit();
            // Enable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);
        } catch (\Throwable $e) {
            // throw $th;
            DB::rollback();

            return redirect()->back()->withInput()->with('flash_danger', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $inv=Invoice::where('id','=',$id)->first();
       $invoiceType = InvoiceType::all();

       $items = Item::all();
       $exchanges = Unit::all();
       $tax=Setting::where('key','tax_value')->first();
       $invItems=InvoiceItem::where('invoice_id','=',$id)->get();
       return view('admin.invoices.edit', compact('invItems','inv','invoiceType','tax',  'items', 'exchanges'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $count = $request->rowCount;

        $details = [];

        for ($i = 1; $i <= $count; $i++) {
            $items = Item::where('code', $request->get('select' . $i))->first();
            $detail = [
                // 'exchange_unit_id' => $request->get('exchange_unit_id' . $i),
                'quantity' => $request->get('qty' . $i),
                'price' => $request->get('itemprice' . $i),
                'note' => $request->get('detNote' . $i),
                'op_permission_no'=>$request->get('opPermission' . $i),
                'total' => $request->get('total' . $i),
                'note' => $request->get('notes'. $i),

            ];
            if ( $items) {
                $detail['item_id'] = $items->id;
            }
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
        }


        //update Details
        $counterrrr = $request->get('qqq');

        $detailsUpdate = [];

        for ($i = 1; $i <= $counterrrr; $i++) {


            $detailUpdate = [
                'id' => $request->get('item_invoice_id' . $i),
                'quantity' => $request->get('upqty' . $i),
                'price' => $request->get('upitemprice' . $i),
                'note' => $request->get('updetNote' . $i),
                'op_permission_no'=>$request->get('upopPermission' . $i),
                'total' => $request->get('uptotal' . $i),
                'note' => $request->get('detNote'. $i),
            ];
            array_push($detailsUpdate, $detailUpdate);
        }
        // Master

        $data = [
            'invoice_no' =>  $request->get('invoice_no'),
            'date' =>Carbon::parse($request->get('date')),
            // 'client_id' => $request->get('client_id'),

            // 'person_nid' =>  $request->get('person_nid'),
            // 'person_name' =>  $request->get('person_name'),
            'subtotal' => $request->get('subtotal'),
            'tax'=>$request->get('tax'),
            'total'=>$request->get('total'),

            'notes' => $request->get('notes'),
            'user_type'=>1,

        ];
        // if($request->get('tab') == 'igotnone'){

        //     $data['person_type'] = 1;


        // }
        // else{

        //     $data['person_type'] = 0;

        // }
if($request->has('taxable')){
    $data['taxable'] = 1;
}
        DB::beginTransaction();
        try {

            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Invoice::where('id', $id)->update($data);
            foreach ($details as $Item) {

                $Item['invoice_id'] = $id;
                $Invoice_Item = InvoiceItem::create($Item);
            }
            foreach ($detailsUpdate as $updates) {


                InvoiceItem::where('id', $updates['id'])->update($updates);
            }
            DB::commit();
            // Enable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);
        } catch (\Throwable $e) {
            // throw $th;
            DB::rollback();

            return redirect()->back()->withInput()->with('flash_danger', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Invoice::where('id', $id)->first();
        // Delete File ..


        try {
            $row->item()->delete();
            $row->delete();
            return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');

        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', $q->getMessage());
        }
    }

    /*
    Add Row
     */
    public function AddRow(Request $req)
    {

        if ($req->ajax()) {
            $rowCount = $req->rowcount;
            $items = Item::all();
            $exchanges = Unit::all();
            $ajaxComponent = view('admin.invoices.ajaxAdd', [
                'rowCount' => $rowCount,
                'items' => $items,
                'exchanges' =>$exchanges

            ]);

            return $ajaxComponent->render();
        }
    }

    /**
     *
     */
    public function editSelectVal(Request $req)
    {

        if ($req->ajax()) {

            $select_value = $req->select_value;
            $out = [];

            $items = Item::where('code', $select_value)->first();
            \Log::info($items);
            echo json_encode(array($items->code, $items->name ?? '',$items->exchange->code ?? ''));
        }
    }

    /**
     *
     */
    public function selectClient(Request $req)
    {

        if ($req->ajax()) {

            $general_value = $req->general_value;
            $help_value = $req->help_value;
            $client = Client::where('general_account', $general_value)->where('help_account', $help_value)->first();
            echo json_encode(array($client->name, $client->commercial_register ?? '', $client->address,$client->id));
        }
    }
    public function DeleteOrderItem(Request $req){
        if ($req->ajax()) {

            $obo = InvoiceItem::where('id', $req->id)->first();

            $invoiceData = Invoice::where('id', $obo->invoice_id)->first();
            $tax=Setting::where('key','tax_value')->first();
            $ss = [
                'subtotal' => $invoiceData->subtotal - $obo->total,
                'tax' =>($invoiceData->subtotal - $obo->total) * $tax->value,
                'total' =>  ($invoiceData->subtotal - $obo->total)+(($invoiceData->subtotal - $obo->total) * $tax->value),
            ];
\Log::info("message Del");
            Invoice::where('id', $obo->invoice_id)->update($ss);

            InvoiceItem::where('id', $req->id)->delete();
        }
    }
}
