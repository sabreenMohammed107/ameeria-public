<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;
    public function __construct(Client $object)
    {
        $this->middleware('auth');
        // $this->middleware('permission:clients-list|clients-create|clients-edit|clients-delete', ['only' => ['index','store']]);
        // $this->middleware('permission:clients-create', ['only' => ['create','store']]);
        // $this->middleware('permission:clients-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:clients-delete', ['only' => ['destroy']]);
        $this->object = $object;
        $this->viewName = 'admin.clients.';
        $this->routeName = 'clients.';
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
        // $data = Client::orderBy('id','DESC')->paginate(200);
        $data = Client::orderByRaw('CONVERT(general_account, SIGNED) asc')->paginate(200);
        return view($this->viewName . 'index', compact('data'))
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::orderBy('code', 'asc')->get();

        return view($this->viewName . 'add', compact('cities'));
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
            'general_account' => 'required',
            'help_account' => 'required',
            'tax_registration' => 'required',
            'name' => 'required',
            'city_id' => 'required',
            'city' => 'required',
            'street' => 'required',
            'build' => 'required',
            // 'email' => 'required',
        ], [
            'name.required' => 'حقل الاسم مطلوب',
            'general_account.required' => 'حقل الحساب العام مطلوب',
            'help_account.required' => 'حقل الحساب المساعد مطلوب',
            'tax_registration.required' => 'حقل التسجيل الضريبي مطلوب',
            'city_id.required' => 'حقل المحافظه مطلوب',
            'city.required' => 'حقل المنطقة مطلوب',
            'street.required' => 'حقل اسم الشارع مطلوب',
            'build.required' => 'حقل رقم المبنى مطلوب',
            // 'email.required' => 'حقل البريد الالكتروني مطلوب',
            // 'help_account.unique' => 'حقل الحساب المساعد موجود بالفعل',
            // 'general_account.unique' => 'حقل الحساب العام موجود بالفعل',
        ]);

        $testUnique = Client::where([['general_account', '=', $request->get('general_account')], ['help_account', '=', $request->get('help_account')]])->first();
        if ($testUnique != null) {
            return redirect()->back()->withInput()->with('flash_danger', 'حقل الحساب العام والمساعد موجود بالفعل');
        }
        try
        {
            $this->object::create($request->except('_token'));
            return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);

        } catch (\Exception$e) {
            // return redirect()->back()->withInput()->with('flash_danger', 'حدث خطأ الرجاء معاودة المحاولة في وقت لاحق');

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
        $row = Client::where('id', $id)->first();
        $cities = City::orderBy('code', 'asc')->get();

        return view($this->viewName . 'edit', compact('cities', 'row'));
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
        $this->validate($request, [
            'general_account' => 'required',
            'help_account' => 'required',
            'tax_registration' => 'required',
            'name' => 'required',
            'city_id' => 'required',
            'city' => 'required',
            'street' => 'required',
            'build' => 'required',
        ], [
            'name.required' => 'حقل الاسم مطلوب',
            'general_account.required' => 'حقل الحساب العام مطلوب',
            'help_account.required' => 'حقل الحساب المساعد مطلوب',
            'tax_registration.required' => 'حقل التسجيل الضريبي مطلوب',
            'city_id.required' => 'حقل المحافظه مطلوب',
            'city.required' => 'حقل المنطقة مطلوب',
            'street.required' => 'حقل اسم الشارع مطلوب',
            'build.required' => 'حقل رقم المبنى مطلوب',
            // 'email.required' => 'حقل البريد الالكتروني مطلوب',
            // 'help_account.unique' => 'حقل الحساب المساعد موجود بالفعل',
            // 'general_account.unique' => 'حقل الحساب العام موجود بالفعل',
        ]);

        if ($request->get('general_account') !== $this->object::findOrFail($id)->general_account && $request->get('help_account') !== $this->object::findOrFail($id)->help_account) {
            $testUnique = Client::where([['general_account', '=', $request->get('general_account')], ['help_account', '=', $request->get('help_account')]])->first();
            if ($testUnique != null) {
                return redirect()->back()->withInput()->with('flash_danger', 'حقل الحساب العام والمساعد موجود بالفعل');
            }
        }

        try
        {
            $this->object::findOrFail($id)->update($request->except('_token'));
            return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);

        } catch (\Exception$e) {
            return redirect()->back()->withInput()->with('flash_danger', 'حدث خطأ الرجاء معاودة المحاولة في وقت لاحق');
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

        \Log::info("message");
        $row = Client::where('id', $id)->first();
        // Delete File ..

        try {

            $row->delete();
            return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');

        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'هذه القيمه مربوطه بجدول اخر ..لا يمكن المسح');
        }
    }

    public function search(Request $request)
    {

        $search = $request->get('search_name');
        $data = Client::where('name', 'LIKE', "%$search%")
            ->orWhere('general_account', 'LIKE', "%$search%")
            ->orWhere('help_account', 'LIKE', "%$search%")
            ->orWhere('commercial_register', 'LIKE', "%$search%")
            ->orWhere('tax_card_id', 'LIKE', "%$search%")
            ->orWhere('phone', 'LIKE', "%$search%")
            ->orWhere('tax_registration', 'LIKE', "%$search%")


            ->orderByRaw('CONVERT(general_account, SIGNED) asc')->paginate(200);

        $search = $request->get('search_name');

        return view($this->viewName . 'index', compact('data', 'search'));

    }

}
