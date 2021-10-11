<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{

    // This is for General Class Variables.
    protected $model;
    protected $view = 'admin.roles.';
    protected $route = "roles.";


    /**
     * RoleController Constructor.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(Role $model)
    {
        $this->middleware('auth');
        $this->middleware('permission:roles-list|roles-create|roles-edit|roles-delete', ['only' => ['index','show']]);
        $this->middleware('permission:roles-create', ['only' => ['create','store']]);
        $this->middleware('permission:roles-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
        $this->model = $model;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->model::orderBy('id', 'DESC')->get();

        return view($this->view.'index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::all();

        return view($this->view.'create', compact('permission'));
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ],[
            'name.required' => 'حقل الاسم مطلوب',
            'name.unique' => 'اسم الدور موجود بالفعل',
            'permission.required' => 'حقل الصلاحيات مطلوب',
        ]);

        try 
        {
            $role = $this->model::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));

            return redirect()->route($this->route.'index')->with('flash_success', 'تم انشاء الدور بنجاح!');

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
        $data = $this->model::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view($this->view.'show', compact('data', 'rolePermissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->model::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view($this->view.'edit', compact('data','permission','rolePermissions'));
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
            'name' => 'required|unique:roles,name,'.$id,
            'permission' => 'required',
        ],[
            'name.required' => 'حقل الاسم مطلوب',
            'name.unique' => 'اسم الدور موجود بالفعل',
            'permission.required' => 'حقل الصلاحيات مطلوب',
        ]);

        try {

            $role = $this->model::find($id);
            $role->name = $request->input('name');
            $role->save();

            $role->syncPermissions($request->input('permission'));

            return redirect()->route($this->route.'index')->with('flash_success', 'تم تعديل الدور بنجاح!');
            
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
        try
        {
            $this->model::findOrFail($id)->delete();

            return redirect()->route($this->route.'index')->with('flash_success', 'تم حذف الدور بنجاح!');

        } catch (\Exception $e){
            return redirect()->back()->withInput()->with('flash_danger', 'حدث خطأ الرجاء معاودة المحاولة في وقت لاحق');
        }
    }

}