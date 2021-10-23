<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceType;
use Illuminate\Http\Request;
use Meneses\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Auth;
use Carbon\Carbon;
class ReportsController extends Controller
{

    protected $viewName;

    public function __construct()
    {
        $this->middleware('auth');

        $this->viewName = 'admin.reports.';

    }
public function showinvoice(){
    $data = Invoice::orderBy('id', 'DESC')->paginate(200);
    $invoiceType = InvoiceType::all();
    return view( 'admin.reports.createInvoice',compact('invoiceType','data'))
    ;
}
    public function invoice(Request $request)
    {
        $invoice = Invoice::orderBy('id', 'DESC');
        if (!empty($request->get("from"))) {
            $invoice->where('date', '>=', Carbon::parse($request->get("from")));
        }
        if (!empty($request->get("to"))) {
            $invoice->where('date', '<=', Carbon::parse($request->get("to")));
        }
        if (!empty($request->get("type_id"))) {
            $invoice->where('type_id', '=', $request->get("type_id"));
        }
        $invoices = $invoice->get();

        $data = [
            'Title' =>'كل الفواتير',
            'invoices' => $invoices,

            'from_date' => '15/10/2021',
            'to_date' => '15/10/2021',
            'Today' => date('Y-m-d'),
            'Logo'  =>  'logo',
            'Company' => 'مطابع الأميرية',
            'User'  =>  Auth::user(),
            'clients' => 'عميل',

        ];
        $pdf = PDF::loadView('admin.reports.doc', $data);
		return $pdf->stream('document.pdf');
    }


    public function search(Request $request){


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
        $data = $invoice->get();
        return view($this->viewName . 'preIndex',compact('data'))->render();
    }
}
