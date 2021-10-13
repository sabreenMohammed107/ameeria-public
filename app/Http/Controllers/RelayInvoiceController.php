<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceType;
use App\Models\Item;
use App\Models\Setting;
use App\Models\Unit;
use Illuminate\Http\Request;

class RelayInvoiceController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;
    function __construct(Invoice $object)
    {
        $this->middleware('auth');
        $this->middleware('permission:invoices-list|invoices-create|invoices-edit|invoices-delete', ['only' => ['index','store']]);
        $this->middleware('permission:invoices-create', ['only' => ['create','store']]);
        $this->middleware('permission:invoices-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:invoices-delete', ['only' => ['destroy']]);
        $this->object = $object;
        $this->viewName = 'admin.relay.';
        $this->routeName = 'relay.';
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
        $data = Invoice::where('status','=',0)->orderBy('id', 'DESC')->paginate(200);
        $relaydata= Invoice::where('status','=',1)->orderBy('id', 'DESC')->paginate(200);
        return view($this->viewName .'index', compact('data','relaydata'))
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
       return view($this->viewName .'showInvoice', compact('invItems','inv','invoiceType','tax',  'items', 'exchanges'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
