<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class UnitsController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName;
    protected $message;
    protected $errormessage;
    function __construct(Unit $object)
    {
        $this->middleware('auth');
        $this->middleware('permission:units-list|units-create|units-edit|units-delete', ['only' => ['index','store']]);
        $this->middleware('permission:units-create', ['only' => ['create','store']]);
        $this->middleware('permission:units-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:units-delete', ['only' => ['destroy']]);
        $this->object = $object;
        $this->viewName = 'admin.units.';
        $this->routeName = 'units.';
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
        $data = Unit::orderBy('id','DESC')->get();
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
        ],[
            'name.required' => 'حقل الاسم مطلوب',

            'code.required' => 'حقل الكود مطلوب',
        ]);

        try
        {
            $this->object::create($request->except('_token'));
        return redirect()->route($this->routeName.'index')->with('flash_success', $this->message);

        } catch (\Exception $e){
            return redirect()->back()->withInput()->with('flash_danger', 'حدث خطأ الرجاء معاودة المحاولة في وقت لاحق');
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
        //
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
            'code' => 'required',
            'name' => 'required',
        ],[
            'name.required' => 'حقل الاسم مطلوب',

            'code.required' => 'حقل الكود مطلوب',
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
        $row = Unit::where('id', $id)->first();
        // Delete File ..


        try {

            $row->delete();
            return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحذف بنجاح !');

        } catch (QueryException $q) {

            return redirect()->back()->with('flash_danger', 'هذه القيمه مربوطه بجدول اخر ..لا يمكن المسح');
        }
    }
}
