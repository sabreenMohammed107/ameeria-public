<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceType;
use App\Models\Item;
use App\Models\Setting;
use App\Models\Unit;
use Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Meneses\LaravelMpdf\Facades\LaravelMpdf as PDF;

class InvoiceController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;
    public function __construct(Invoice $object)
    {
        $this->middleware('auth');
        // $this->middleware('permission:invoices-list|invoices-create|invoices-edit|invoices-delete', ['only' => ['index','store']]);
        // $this->middleware('permission:invoices-create', ['only' => ['create','store']]);
        // $this->middleware('permission:invoices-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:invoices-delete', ['only' => ['destroy']]);
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
        $data = Invoice::orderBy('date', 'DESC')->paginate(200);
        $invoiceType = InvoiceType::all();
        return view($this->viewName . 'index', compact('data', 'invoiceType'))
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
        $tax = Setting::where('key_name', 'tax_value')->first();
        return view($this->viewName . 'add', compact('invoiceType', 'tax', 'rowCount', 'items', 'exchanges'));
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
                // 'price' => $request->get('itemprice' . $i),
                'note' => $request->get('detNote' . $i),
                // 'op_permission_no'=>$request->get('opPermission' . $i),
                'total' => $request->get('total' . $i),
                'note' => $request->get('notes' . $i),

            ];

            if ($request->get('type_id') == 1 || $request->get('type_id') == 2) {
                // ini_set('precision', 7);

                if (($request->get('total' . $i) / $request->get('qty' . $i)) > 1) {
                    $detail['price'] = (($request->get('total' . $i) / $request->get('qty' . $i)));
                } else {
                    $detail['price'] = ($request->get('total' . $i) / $request->get('qty' . $i));
                }

                // dd($request->get('total' . $i) / $request->get('qty' . $i));

            } else {
                if (!empty($request->get('itemprice' . $i))) {
                    // if (!empty($request->get('itemprice' . $i))) {
                    $detail['price'] = $request->get('itemprice' . $i);

                } else {
                    $detail['price'] = 0;

                }
            }
            if (!empty($request->get('opPermission' . $i))) {
                $detail['op_permission_no'] = $request->get('opPermission' . $i);
            } else {
                $detail['op_permission_no'] = null;
            }
            if ($items) {
                $detail['item_id'] = $items->id;
            }
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
        }

        //master
//         $now = new DateTime();
// $curYear = $now->format("Y");

        $data = [
            // 'invoice_no' => ($curYear."-".$request->get('invoice_no')),
            'invoice_no' => $request->get('invoice_no'),
            'e_invoice_type' => $request->get('e_invoice_type'),
            'date' => Carbon::parse($request->get('date')),

            'type_id' => $request->get('type_id'),

            'subtotal' => $request->get('subtotal'),
            'tax' => $request->get('tax'),
            'total' => $request->get('total'),
            'status' => 0,
            'notes' => $request->get('notes'),
            'user_type' => 1,
            'created_at'=> Carbon::parse($request->get('date')),

        ];

        if ($request->get('tab') == 'igotnone') {

            $data['person_type'] = 1;
            $data['client_id'] = $request->get('client_id');

        } else {

            $data['person_type'] = 0;

            $data['person_nid'] = $request->get('person_nid');
            $data['person_name'] = $request->get('person_name');
        }
        if ($request->has('taxable')) {
            $data['taxable'] = 1;
        }

        $this->validate($request, [

            'invoice_no' => 'required',
            'date' => 'required',
            'type_id' => 'required',

        ], [
            'invoice_no.required' => 'حقل رقم الفاتورة مطلوب',
            'date.required' => 'حقل تاريخ الفاتورة مطلوب',
            'type_id.required' => 'حقل نوع الفاتورة مطلوب',

        ]);
        $now = new DateTime();
        $curYear = $now->format("Y");
        // $date = Carbon::createFromFormat('m/d/Y',$request->get('date'))->format('Y');
       if(Carbon::parse($request->get('date'))->format('m') >= '07'){
        $currentYear = Carbon::parse($request->get('date'))->format('Y');
        $nextYear = $currentYear + 1;
       } else{
        $nextYear =  Carbon::parse($request->get('date'))->format('Y');
        $currentYear =$nextYear - 1;
       }

        $startDate = Carbon::createFromFormat('d/m/Y', '01/07/' . $currentYear);

        $endDate = Carbon::createFromFormat('d/m/Y', '30/06/' . $nextYear);
// // $exist = Post::whereBetween('created_at', [$startDate, $endDate])->get();
        $exist = Invoice::where('invoice_no', '=', $request->get('invoice_no'))
            ->whereBetween('created_at' , [Carbon::parse($startDate), Carbon::parse($endDate)])->first();
//$testUnique = Invoice::where('invoice_no', '=', ($curYear."-".$request->get('invoice_no')))->first();
        // dd($exist);
if ($exist != null) {
            return redirect()->back()->withInput()->with('flash_danger', 'حقل رقم الفاتورة موجود بالفعل');
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

            // return redirect()->back()->withInput()->with('flash_danger', 'حدث خطأ فى ادخال البيانات قم بمراجعتها مرة اخرى');
        }
    }
    public function testValidte(Request $request)
    {
        \Log::info(['validate msg...']);
        $this->validate($request, [

            'code' => 'required',

        ], [
            'code.required' => 'حقل رقم الفاتورة مطلوب',

        ]);
        $message = '';
        // $currentYear = date('Y');
        $currentYear = Carbon::parse($request->get('date'))->format('Y');
        $nextYear = $currentYear + 1;

        $startDate = Carbon::createFromFormat('d/m/Y', '01/07/' . $currentYear);

        $endDate = Carbon::createFromFormat('d/m/Y', '30/06/' . $nextYear);

        $exist = Invoice::where('invoice_no', '=', $request->get('code'))
            ->whereBetween('created_at', [Carbon::parse($startDate), Carbon::parse($endDate)])->first();
        if ($exist != null) {
            $message = 'حقل رقم الفاتورة موجود بالفعل';
        }

        try {

            return $message;

        } catch (QueryException $q) {

            return $message;
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
        $data = Invoice::orderBy('id', 'DESC')->paginate(200);
        $inv = Invoice::where('id', '=', $id)->first();
        $invoiceType = InvoiceType::all();

        $items = Item::all();
        $exchanges = Unit::all();
        $tax = Setting::where('key_name', 'tax_value')->first();
        $invItems = InvoiceItem::where('invoice_id', '=', $id)->get();

        $invoice = Invoice::orderBy('id', 'DESC');
        // if (!empty($request->get("from"))) {
        //     $invoice->where('date', '>=', Carbon::parse($request->get("from")));
        // }
        // if (!empty($request->get("to"))) {
        //     $invoice->where('date', '<=', Carbon::parse($request->get("to")));
        // }
        // if (!empty($request->get("type_id"))) {
        //     $invoice->where('type_id', '=', $request->get("type_id"));
        // }
        $invoices = $invoice->get();
        // $qrcode = base64_encode(QrCode::size(200)->errorCorrection('H')->generate('hello'));
        $data = [
            'Title' => 'كل الفواتير',
            'invoices' => $invoices,

            'from_date' => '15/10/2021',
            'to_date' => '15/10/2021',
            'Today' => date('Y-m-d'),
            'Logo' => 'logo',
            'Company' => 'مطابع الأميرية',
            'User' => Auth::user(),
            'clients' => 'عميل',
            'invItems' => $invItems,
            'inv' => $inv,
            'invoiceType' => $invoiceType,
            'tax' => $tax,
            'items' => $items,
            'exchanges' => $exchanges,
            // 'qrcode' =>$qrcode,

        ];
        $pdf = PDF::loadView('admin.invoices.report', $data);
        return $pdf->stream('document.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inv = Invoice::where('id', '=', $id)->first();
        $invoiceType = InvoiceType::all();

        $items = Item::all();
        $exchanges = Unit::all();
        $tax = Setting::where('key_name', 'tax_value')->first();
        $invItems = InvoiceItem::where('invoice_id', '=', $id)->get();
        return view($this->viewName . 'edit', compact('invItems', 'inv', 'invoiceType', 'tax', 'items', 'exchanges'));
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
                // 'price' => $request->get('itemprice' . $i),
                'note' => $request->get('detNote' . $i),
                // 'op_permission_no'=>$request->get('opPermission' . $i),
                'total' => $request->get('total' . $i),
                'note' => $request->get('notes' . $i),

            ];
            if (!empty($request->get('opPermission' . $i))) {
                $detail['op_permission_no'] = $request->get('opPermission' . $i);
            } else {
                $detail['op_permission_no'] = null;
            }
            if ($this->object::findOrFail($id)->type_id == 1 || $this->object::findOrFail($id)->type_id == 2) {

                ini_set('precision', 7);

                if (($request->get('total' . $i) / $request->get('qty' . $i)) > 1) {
                    $detail['price'] = (($request->get('total' . $i) / $request->get('qty' . $i)) + 0.00001);
                } else {
                    $detail['price'] = ($request->get('total' . $i) / $request->get('qty' . $i));
                }

            } else {
                if (!empty($request->get('itemprice' . $i))) {
                    // if (!empty($request->get('itemprice' . $i))) {
                    $detail['price'] = $request->get('itemprice' . $i);
                } else {
                    $detail['price'] = 0;
                }
            }
            if ($items) {
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
                // 'price' => $request->get('upitemprice' . $i),
                'note' => $request->get('updetNote' . $i),
                // 'op_permission_no'=>$request->get('upopPermission' . $i),
                'total' => $request->get('uptotal' . $i),
                'note' => $request->get('detNote' . $i),
            ];
            if ($this->object::findOrFail($id)->type_id == 1 || $this->object::findOrFail($id)->type_id == 2) {
                $detailUpdate['price'] = $request->get('uptotal' . $i) / $request->get('upqty' . $i);

            } else {
                if (!empty($request->get('upitemprice' . $i))) {
                    // if (!empty($request->get('itemprice' . $i))) {
                    $detailUpdate['price'] = $request->get('upitemprice' . $i);
                } else {
                    $detailUpdate['price'] = 0;
                }
            }

            if (!empty($request->get('upopPermission' . $i))) {
                $detailUpdate['op_permission_no'] = $request->get('upopPermission' . $i);
            } else {
                $detailUpdate['op_permission_no'] = null;
            }
            array_push($detailsUpdate, $detailUpdate);
        }
        // Master
        $now = new DateTime();
        $curYear = $now->format("Y");

        $data = [
            'invoice_no' => $request->get('invoice_no'),
            'e_invoice_type' => $request->get('e_invoice_type'),
            'date' => Carbon::parse($request->get('date')),
            // 'client_id' => $request->get('client_id'),

            // 'person_nid' =>  $request->get('person_nid'),
            // 'person_name' =>  $request->get('person_name'),
            'subtotal' => $request->get('subtotal'),
            'tax' => $request->get('tax'),
            'total' => $request->get('total'),
            'status' => $request->get('status'),
            'notes' => $request->get('notes'),
            'user_type' => 1,

        ];
        // if($request->get('tab') == 'igotnone'){

        //     $data['person_type'] = 1;

        // }
        // else{

        //     $data['person_type'] = 0;

        // }
        if ($request->has('taxable')) {
            $data['taxable'] = 1;
        }
        $this->validate($request, [

            'invoice_no' => 'required',
            'date' => 'required',

        ], [
            'invoice_no.required' => 'حقل رقم الفاتورة مطلوب',
            'date.required' => 'حقل تاريخ الفاتورة مطلوب',

        ]);
// $now = new DateTime();
//         $curYear = $now->format("Y");
// if (($curYear."-".$request->get('invoice_no')) !== $this->object::findOrFail($id)->invoice_no) {
//     $testUnique = Invoice::where('invoice_no', '=', ($curYear."-".$request->get('invoice_no')))->first();
//     if ($testUnique != null) {
//         return redirect()->back()->withInput()->with('flash_danger', 'حقل رقم الفاتورة موجود بالفعل');
//     }
// }
        // $currentYear = date('Y');
        $currentYear = Carbon::parse($request->get('date'))->format('Y');
        $nextYear = $currentYear + 1;
        $startDate = Carbon::createFromFormat('d/m/Y', '01/07/' . $currentYear);

        $endDate = Carbon::createFromFormat('d/m/Y', '30/06/' . $nextYear);
// // $exist = Post::whereBetween('created_at', [$startDate, $endDate])->get();
        if ($request->get('invoice_no') !== $this->object::findOrFail($id)->invoice_no) {
            $exist = Invoice::where('invoice_no', '=', $request->get('invoice_no'))
                ->whereBetween('date', [Carbon::parse($startDate), Carbon::parse($endDate)])->first();
//$testUnique = Invoice::where('invoice_no', '=', ($curYear."-".$request->get('invoice_no')))->first();
            if ($exist != null) {
                return redirect()->back()->withInput()->with('flash_danger', 'حقل رقم الفاتورة موجود بالفعل');
            }
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

            return redirect()->back()->withInput()->with('flash_danger', 'حدث خطأ فى ادخال البيانات قم بمراجعتها مرة اخرى');
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
            $row->items()->forceDelete();
            $row->forceDelete();
            return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');

        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'هذه القيمه مربوطه بجدول اخر ..لا يمكن المسح');
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
            $ajaxComponent = view($this->viewName . 'ajaxAdd', [
                'rowCount' => $rowCount,
                'items' => $items,
                'exchanges' => $exchanges,

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
            $result3 = 0;
            if ($items->exchange->code == 12) {
                $result3 = $items->selling_price / 1000;
            } else {
                $result3 = $items->selling_price;

            }

            echo json_encode(array($items->code, $items->name ?? '', $items->exchange->code ?? '', $result3));
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
            echo json_encode(array($client->name, $client->commercial_register ?? '', $client->address, $client->id, $client->tax_registration ?? ''));
        }
    }
    public function DeleteOrderItem(Request $req)
    {
        if ($req->ajax()) {

            $obo = InvoiceItem::where('id', $req->id)->first();

            $invoiceData = Invoice::where('id', $obo->invoice_id)->first();
            $tax = Setting::where('key_name', 'tax_value')->first();
            $ss = [
                'subtotal' => $invoiceData->subtotal - $obo->total,
                'tax' => ($invoiceData->subtotal - $obo->total) * $tax->value,
                'total' => ($invoiceData->subtotal - $obo->total) + (($invoiceData->subtotal - $obo->total) * $tax->value),
            ];

            Invoice::where('id', $obo->invoice_id)->update($ss);

            InvoiceItem::where('id', $req->id)->forceDelete();
        }
    }

    public function search(Request $request)
    {

        $invoice = Invoice::orderBy('id', 'DESC');
        if (!empty($request->get("from"))) {
            $invoice->where('date', '>=', Carbon::parse($request->get("from")));
        }
        if (!empty($request->get("to"))) {
            $invoice->where('date', '<=', Carbon::parse($request->get("to")));
        }
        if (!empty($request->get("type"))) {
            $invoice->where('type_id', '=', $request->get("type"));
        }
        if (!empty($request->get("invoice_no"))) {

            $invoice->where('invoice_no', '=', $request->get("invoice_no"));
        }

        $data = $invoice->get();

        return view($this->viewName . 'preIndex', compact('data'))->render();
    }

    public function depitInvoices($id)
    {
        $row = Invoice::where('id', '=', $id)->first();
        $invoiceType = InvoiceType::all();
        $rowCount = 1;
        $items = Item::all();
        $exchanges = Unit::all();
        $tax = Setting::where('key_name', 'tax_value')->first();
        return view($this->viewName . 'depitInvoices', compact('row', 'invoiceType', 'tax', 'rowCount', 'items', 'exchanges'));
    }
    public function storeDepitInvoices(Request $request)
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
                // 'price' => $request->get('itemprice' . $i),
                'note' => $request->get('detNote' . $i),
                // 'op_permission_no'=>$request->get('opPermission' . $i),
                'total' => $request->get('total' . $i),
                'note' => $request->get('notes' . $i),

            ];

            if ($request->get('type_id') == 1 || $request->get('type_id') == 2) {
                // ini_set('precision', 7);

                if (($request->get('total' . $i) / $request->get('qty' . $i)) > 1) {
                    $detail['price'] = (($request->get('total' . $i) / $request->get('qty' . $i)));
                } else {
                    $detail['price'] = ($request->get('total' . $i) / $request->get('qty' . $i));
                }

                // dd($request->get('total' . $i) / $request->get('qty' . $i));

            } else {
                if (!empty($request->get('itemprice' . $i))) {
                    // if (!empty($request->get('itemprice' . $i))) {
                    $detail['price'] = $request->get('itemprice' . $i);

                } else {
                    $detail['price'] = 0;

                }
            }
            if (!empty($request->get('opPermission' . $i))) {
                $detail['op_permission_no'] = $request->get('opPermission' . $i);
            } else {
                $detail['op_permission_no'] = null;
            }
            if ($items) {
                $detail['item_id'] = $items->id;
            }
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
        }

//master
//         $now = new DateTime();
// $curYear = $now->format("Y");

        $data = [
            // 'invoice_no' => ($curYear."-".$request->get('invoice_no')),
            'invoice_no' => $request->get('invoice_no'),
            'e_invoice_type' => 'D',
            'date' => Carbon::parse($request->get('date')),
            'client_id' => $request->get('client_id'),
            'type_id' => $request->get('type_id'),
            'person_nid' => $request->get('person_nid'),
            'person_name' => $request->get('person_name'),
            'subtotal' => $request->get('subtotal'),
            'tax' => $request->get('tax'),
            'total' => $request->get('total'),
            'status' => 0,
            'notes' => $request->get('notes'),
            'user_type' => 1,
            'inv_id' => $request->get('inv_id'),

        ];

        if ($request->get('tab') == 'igotnone') {

            $data['person_type'] = 1;

        } else {

            $data['person_type'] = 0;

        }
        if ($request->has('taxable')) {
            $data['taxable'] = 1;
        }

        $this->validate($request, [

            'invoice_no' => 'required',
            'date' => 'required',
            'type_id' => 'required',

        ], [
            'invoice_no.required' => 'حقل رقم الفاتورة مطلوب',
            'date.required' => 'حقل تاريخ الفاتورة مطلوب',
            'type_id.required' => 'حقل نوع الفاتورة مطلوب',

        ]);
        $now = new DateTime();
        $curYear = $now->format("Y");
        // $currentYear = date('Y');
        $currentYear = Carbon::parse($request->get('date'))->format('Y');
        $nextYear = $currentYear + 1;
        $startDate = Carbon::createFromFormat('d/m/Y', '01/07/' . $currentYear);

        $endDate = Carbon::createFromFormat('d/m/Y', '30/06/' . $nextYear);
// // $exist = Post::whereBetween('created_at', [$startDate, $endDate])->get();
        $exist = Invoice::where('invoice_no', '=', $request->get('invoice_no'))
            ->whereBetween('created_at', [Carbon::parse($startDate), Carbon::parse($endDate)])->first();
//$testUnique = Invoice::where('invoice_no', '=', ($curYear."-".$request->get('invoice_no')))->first();
        if ($exist != null) {
            return redirect()->back()->withInput()->with('flash_danger', 'حقل رقم الفاتورة موجود بالفعل');
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

            return redirect()->back()->withInput()->with('flash_danger', 'حدث خطأ فى ادخال البيانات قم بمراجعتها مرة اخرى');
        }
    }




    public function creditInvoices($id)
    {
        $row = Invoice::where('id', '=', $id)->first();
        $invoiceType = InvoiceType::all();
        $rowCount = 1;
        $items = Item::all();
        $exchanges = Unit::all();
        $tax = Setting::where('key_name', 'tax_value')->first();
        return view($this->viewName . 'creditInvoices', compact('row', 'invoiceType', 'tax', 'rowCount', 'items', 'exchanges'));
    }
    public function storeCreditInvoices(Request $request)
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
                // 'price' => $request->get('itemprice' . $i),
                'note' => $request->get('detNote' . $i),
                // 'op_permission_no'=>$request->get('opPermission' . $i),
                'total' => $request->get('total' . $i),
                'note' => $request->get('notes' . $i),

            ];

            if ($request->get('type_id') == 1 || $request->get('type_id') == 2) {
                // ini_set('precision', 7);

                if (($request->get('total' . $i) / $request->get('qty' . $i)) > 1) {
                    $detail['price'] = (($request->get('total' . $i) / $request->get('qty' . $i)));
                } else {
                    $detail['price'] = ($request->get('total' . $i) / $request->get('qty' . $i));
                }

                // dd($request->get('total' . $i) / $request->get('qty' . $i));

            } else {
                if (!empty($request->get('itemprice' . $i))) {
                    // if (!empty($request->get('itemprice' . $i))) {
                    $detail['price'] = $request->get('itemprice' . $i);

                } else {
                    $detail['price'] = 0;

                }
            }
            if (!empty($request->get('opPermission' . $i))) {
                $detail['op_permission_no'] = $request->get('opPermission' . $i);
            } else {
                $detail['op_permission_no'] = null;
            }
            if ($items) {
                $detail['item_id'] = $items->id;
            }
            if ($request->get('qty' . $i)) {
                array_push($details, $detail);
            }
        }

//master
//         $now = new DateTime();
// $curYear = $now->format("Y");

        $data = [
            // 'invoice_no' => ($curYear."-".$request->get('invoice_no')),
            'invoice_no' => $request->get('invoice_no'),
            'e_invoice_type' => 'C',
            'date' => Carbon::parse($request->get('date')),
            'client_id' => $request->get('client_id'),
            'type_id' => $request->get('type_id'),
            'person_nid' => $request->get('person_nid'),
            'person_name' => $request->get('person_name'),
            'subtotal' => $request->get('subtotal'),
            'tax' => $request->get('tax'),
            'total' => $request->get('total'),
            'status' => 0,
            'notes' => $request->get('notes'),
            'user_type' => 1,
            'inv_id' => $request->get('inv_id'),

        ];

        if ($request->get('tab') == 'igotnone') {

            $data['person_type'] = 1;

        } else {

            $data['person_type'] = 0;

        }
        if ($request->has('taxable')) {
            $data['taxable'] = 1;
        }

        $this->validate($request, [

            'invoice_no' => 'required',
            'date' => 'required',
            'type_id' => 'required',

        ], [
            'invoice_no.required' => 'حقل رقم الفاتورة مطلوب',
            'date.required' => 'حقل تاريخ الفاتورة مطلوب',
            'type_id.required' => 'حقل نوع الفاتورة مطلوب',

        ]);
        $now = new DateTime();
        $curYear = $now->format("Y");
        // $currentYear = date('Y');
        $currentYear = Carbon::parse($request->get('date'))->format('Y');
        $nextYear = $currentYear + 1;
        $startDate = Carbon::createFromFormat('d/m/Y', '01/07/' . $currentYear);

        $endDate = Carbon::createFromFormat('d/m/Y', '30/06/' . $nextYear);
// // $exist = Post::whereBetween('created_at', [$startDate, $endDate])->get();
        $exist = Invoice::where('invoice_no', '=', $request->get('invoice_no'))
            ->whereBetween('created_at', [Carbon::parse($startDate), Carbon::parse($endDate)])->first();
//$testUnique = Invoice::where('invoice_no', '=', ($curYear."-".$request->get('invoice_no')))->first();
        if ($exist != null) {
            return redirect()->back()->withInput()->with('flash_danger', 'حقل رقم الفاتورة موجود بالفعل');
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

            return redirect()->back()->withInput()->with('flash_danger', 'حدث خطأ فى ادخال البيانات قم بمراجعتها مرة اخرى');
        }
    }
}
