<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Store;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ItemsController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;
    function __construct(Item $object)
    {
        $this->middleware('auth');
        $this->middleware('permission:items-list|items-create|items-edit|items-delete', ['only' => ['index','store']]);
        $this->middleware('permission:items-create', ['only' => ['create','store']]);
        $this->middleware('permission:items-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:items-delete', ['only' => ['destroy']]);
        $this->object = $object;
        $this->viewName = 'admin.items.';
        $this->routeName = 'items.';
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
        $data = Item::orderBy('id','DESC')->paginate(200);
        return view($this->viewName.'index',compact('data'))
           ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stores = Store::orderBy('id','DESC')->get();
        $storages=Unit::orderBy('id','DESC')->get();
        $exchanges=Unit::orderBy('id','DESC')->get();
        return view($this->viewName.'add',compact('stores','storages','exchanges'))
           ;
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
            'code' => 'required',
            'name' => 'required',
            'general_account'=>'required',
            'help_account'=>'required',
            'exchange_unit_id'=>'required',
            'selling_price'=>'required',
        ],[
            'name.required' => 'حقل الاسم مطلوب',

            'code.required' => 'حقل الكود مطلوب',
            'general_account.required' => 'حقل الحساب العام مطلوب',

            'help_account.required' => 'حقل الحساب المساعد مطلوب',
            'exchange_unit_id.required' => 'حقل وحده الصرف مطلوب',

            'selling_price.required' => 'حقل سعر البيع مطلوب',
        ]);

        try
        {
            $this->object::create($request->except('_token'));
        return redirect()->route($this->routeName.'index')->with('flash_success', $this->message);

        } catch (\Exception $e){
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
        $row=Item::where('id',$id)->first();
        $stores = Store::orderBy('id','DESC')->get();
        $storages=Unit::orderBy('id','DESC')->get();
        $exchanges=Unit::orderBy('id','DESC')->get();
        return view($this->viewName.'edit',compact('stores','storages','exchanges','row'))
           ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { $this->validate($request, [
        'code' => 'required',
        'name' => 'required',
        'general_account'=>'required',
        'help_account'=>'required',
        'exchange_unit_id'=>'required',
        'selling_price'=>'required',
    ],[
        'name.required' => 'حقل الاسم مطلوب',

        'code.required' => 'حقل الكود مطلوب',
        'general_account.required' => 'حقل الحساب العام مطلوب',

        'help_account.required' => 'حقل الحساب المساعد مطلوب',
        'exchange_unit_id.required' => 'حقل وحده الصرف مطلوب',

        'selling_price.required' => 'حقل سعر البيع مطلوب',
    ]);

    try
    {
        $this->object::findOrFail($id)->update($request->except('_token'));
        return redirect()->route($this->routeName . 'index')->with('flash_success', $this->message);

    } catch (\Exception $e){
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
        $row = Item::where('id', $id)->first();
        // Delete File ..


        try {

            $row->delete();
            return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');

        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'هذه القيمه مربوطه بجدول اخر ..لا يمكن المسح');
        }
    }
}
