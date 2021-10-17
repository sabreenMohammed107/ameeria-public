<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Meneses\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Auth;
class ReportsController extends Controller
{

    protected $viewName;

    public function __construct()
    {
        $this->middleware('auth');

        $this->viewName = 'admin.reports.';

    }

    public function invoice()
    {
        $invoices = Invoice::orderBy('id', 'DESC')->get();
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
}
