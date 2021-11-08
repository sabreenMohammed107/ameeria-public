<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceType;
use App\Models\Item;
use App\Models\Setting;
use App\Models\Unit;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Traits\EInvoicingTrait;

class RelayInvoiceController extends Controller
{
    use EInvoicingTrait;

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
        $this->validate($request, [
            'invoices' => 'required',
        ],[
            'required' => 'الرجاء تحديد الفواتير المراد ترحيلها',
        ]);

        $invoices_ids = $request->input('invoices');
        
        $documents["documents"] = [];
        foreach ($invoices_ids as $key => $invoice_id)
        {
            $invoice = Invoice::find($invoice_id);
            if($invoice == null || $invoice->items == null)
                continue;

            if($invoice->client_id != null)
            {
                $client = Client::find($invoice->client_id);
                if($client == null){
                    continue;
                }else{
                    $receiverType = "B";
                    $receiverId = $client->commercial_register;
                    $receiverName = $client->name;
                    $receiverAddressCountry = "EG";
                    $receiverAddressGovernate = "Cairo";
                    $receiverAddressCity = "Nasr City";
                    $receiverAddressStreet = "580 Clementina Key";
                    $receiverAddressBuild = "Bldg. 0";
                }
            }else{
                if($invoice->person_name == null){
                    continue;
                }else{
                    $receiverType = "P";
                    $receiverId = $invoice->person_nid;
                    $receiverName = $invoice->person_name;
                    $receiverAddressCountry = "";
                    $receiverAddressGovernate = "";
                    $receiverAddressCity = "";
                    $receiverAddressStreet = "";
                    $receiverAddressBuild = "";
                }
            }
            

            // Get all Invoice Items..
            $invoiceLines = $totalTaxArray = [];
            $totalSalesAmount = $totalNetAmount = $totalAmount =  0;

            foreach ($invoice->items as $item_key => $rowItem)
            {
                $discount = 0;
                $salesTotal = $rowItem->quantity * $rowItem->price;
                $netTotal = $salesTotal - $discount;
                $tax_fees = ($salesTotal / 100) * 14;
                $total = $netTotal + $tax_fees;

                array_push($totalTaxArray, $tax_fees);
                $totalSalesAmount += $salesTotal;
                $totalNetAmount += $netTotal;
                $totalAmount += $total;

                $invoiceLines[$item_key] = [
                    "description" => $rowItem->item->name,
                    "itemType" => "EGS",
                    "itemCode" =>  "EG-100304559-".$rowItem->item->code,
                    "unitType" => $rowItem->item->exchange->standard_code,
                    "quantity" => $rowItem->quantity,
                    "internalCode" => $rowItem->id,
                    "salesTotal" => $salesTotal,
                    "total" => $total,
                    "valueDifference" => 0.00,
                    "totalTaxableFees" => 0,
                    "netTotal" => $netTotal,
                    "itemsDiscount" => 0,
                    "unitValue" => [
                        "currencySold" => "EGP",
                        "amountEGP" => $rowItem->price
                    ],
                    "discount" => [
                        "rate" => 0,
                        "amount" => 0
                    ],
                ];

                $invoiceLines[$item_key]["taxableItems"][] = [
                    "taxType" => "T1",
                    "amount" => $tax_fees,
                    "subType" => "V009",
                    "rate" => 14
                ];
            }
            
            // Make Tax Array.
            $taxTotals[] = [
                "taxType" => "T1",
                "amount"  => array_sum($totalTaxArray),
            ];

            // Init the request raw..
            $documents["documents"][$key] = [
                "issuer" => [
                    "address" => [
                        "branchID" => "0",
                        "country" => "EG",
                        "governate" => "Giza",
                        "regionCity" => "Imbabah",
                        "street" => "Konrnish El-Nile",
                        "buildingNumber" => "22",
                    ],
                    "type" => "B",
                    "id" => "100304559",
                    "name" => "الهيئة العامة لشؤون المطابع الاميرية",
                ],
                "receiver" => [
                    "address" => [
                        "country" => $receiverAddressCountry,
                        "governate" => $receiverAddressGovernate,
                        "regionCity" => $receiverAddressCity,
                        "street" => $receiverAddressStreet,
                        "buildingNumber" => $receiverAddressBuild,
                    ],
                    "type" => $receiverType,
                    "id" => $receiverId,
                    "name" => $receiverName,
                ],
                "documentType" => "I",
                "documentTypeVersion" => "1.0",
                "dateTimeIssued" => date('Y-m-d', strtotime($invoice->date)).'T'.date('H:i:s').'Z',
                "taxpayerActivityCode" => "1811",
                "internalID" => 'P'.$invoice->invoice_no,
                "invoiceLines" => $invoiceLines,
                "totalSalesAmount" => $totalSalesAmount,
                "totalDiscountAmount" => 0,
                "netAmount" => $totalNetAmount,
                "taxTotals" => $taxTotals,
                "extraDiscountAmount" => 0,
                "totalItemsDiscountAmount" => 0,
                "totalAmount" => $totalAmount,
            ];

            $documents["documents"][$key] = $singleDocument;
        }
        
        $token = $this->getAccessToken();
        if($token['status'] != 200){
            return redirect()->route('relay.index')->with('flash_danger', 'حدث خطأ أثناء تنفيذ الاستعلام للحصول على رمز وصول!');
        }

        $submission = $this->getFullDocumentSignatures($token['data']['access_token'], $documents);
        if($submission['status'] != 202){
            return redirect()->route('relay.index')->with('flash_danger', 'حدث خطأ .. تعذر الوصول إلى السيرفر الخاص بالفاتورة الإلكترونية!');
        }
        elseif ($submission['status'] == 202 && $submission['data']['submissionId'] != null)
        {
            // Save Response data.
        }

        return redirect()->route('relay.index')->with('flash_success', 'تم ترحيل بيانات الفواتير إلي نظام الفاتورة الإلكترونية بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inv=Invoice::where('id','=',$id)->first();
        $invoiceType = InvoiceType::all();

        $items = Item::all();
        $exchanges = Unit::all();
        $tax=Setting::where('key_name','tax_value')->first();
        $invItems=InvoiceItem::where('invoice_id','=',$id)->get();

        return view($this->viewName .'showInvoice', compact('invItems','inv','invoiceType','tax',  'items', 'exchanges'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $documentUUID = $invoice->invoice_document_id;
    
        $token = $this->getAccessToken();
        if($token['status'] != 200){
            return redirect()->route('relay.index')->with('flash_danger', 'حدث خطأ أثناء تنفيذ الاستعلام للحصول على رمز وصول!');
        }

        $result =  $this->cancelDocument($token['data']['access_token'], $documentUUID);
        if($result['status'] != 200){
            return redirect()->route('relay.index')->with('flash_danger', 'حدث خطأ أثناء تنفيذ الغاء الفاتورة... الرجاء المحاولة مرة أخرى!');
        }else{
            return redirect()->route('relay.index')->with('flash_success', 'تم الغاء الفاتورة من  نظام الفاتورة الإلكترونية بنجاح');
        }

    }
}
