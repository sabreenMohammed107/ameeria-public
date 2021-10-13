<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\User;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    // This is for General Class Variables.
    protected $model;
    protected $view = 'admin.users.';
    protected $route = "users.";

    /**
     * UserController Constructor.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(User $model)
    {
        $this->middleware('auth');
        $this->middleware('permission:users-list|users-create|users-edit|users-delete', ['only' => ['index','show']]);
        $this->middleware('permission:users-create', ['only' => ['create','store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:users-delete', ['only' => ['destroy']]);
        $this->model = $model;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->model::all();

        return view($this->view.'index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();

        return view($this->view.'add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validating fields
        $this->validate($request, [
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
            'roles' => 'required',
        ],
        [
            'f_name.required' => 'حقل الاسم الاول مطلوب',
            'l_name.required' => 'حقل الاسم الاخير مطلوب',
            'username.required' => 'حقل اسم المستخدم مطلوب',
            'phone.required' => 'حقل التليفون مطلوب',
            'email.required' => 'حقل البريد الالكترونى مطلوب',
            'password.required' => 'حقل كلمه السر مطلوب',
            'roles.required' => 'حقل الادوار مطلوب',
            'email.unique' => 'البريد الالكترونى  موجود بالفعل',
            'phone.unique' => 'التليفون موجود بالفعل',
            'username.unique' => 'اسم المستخدم موجود بالفعل',
        ]);

        try {

            $input = $request->all();
            $input['password'] = \Hash::make($input['password']);

            $user = $this->model::create($input);
            $user->assignRole($request->input('roles'));

            // Display a successful message ...
            return redirect()->route($this->route.'index')->with('flash_success','تم إنشاء المستخدم بنجاح');

        } catch (\Exception $e){
            return redirect()->route($this->view.'index')->with('flash_danger','خطأ ... لا يمكن الحذف حتي لا تتأثر البيانات الأخري بعملية الحذف !!!');
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
        $data = $this->model::findOrFail($id);

        return view($this->view.'show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->model::findOrFail($id);
        $user->password = null;
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view($this->view.'edit', compact('user', 'roles', 'userRole'));
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

        // Validating fields
        $this->validate($request, [
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required|unique:users,phone,'.$id,
            'username' => 'required|string|unique:users,username,'.$id,

            'roles' => 'required',
        ],
        [
            'f_name.required' => 'حقل الاسم الاول مطلوب',
            'l_name.required' => 'حقل الاسم الاخير مطلوب',
            'username.required' => 'حقل اسم المستخدم مطلوب',
            'phone.required' => 'حقل التليفون مطلوب',
            'email.required' => 'حقل البريد الالكترونى مطلوب',

            'roles.required' => 'حقل الادوار مطلوب',
            'email.unique' => 'البريد الالكترونى  موجود بالفعل',
            'phone.unique' => 'التليفون موجود بالفعل',
            'username.unique' => 'اسم المستخدم موجود بالفعل',
        ]);
        try {

            $input = $request->all();
            if($input['password'] != null)
                $input['password'] = \Hash::make($input['password']);
            else
                unset($input['password']);

            $user = $this->model::findOrFail($id);
            $user->update($input);

            \DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->assignRole($request->input('roles'));

            // Display a successful message ...
            return redirect()->route($this->route.'index')->with('flash_success','تم تعديل بيانات المستخدم بنجاح');

        } catch (\Exception $e){
            return redirect()->route($this->route.'index')->with('flash_danger','خطأ ... لا يمكن الحذف حتي لا تتأثر البيانات الأخري بعملية الحذف !!!');
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
            $account = $this->model::findOrFail($id);
            $account->delete();

            // Display a successful message ...
            return redirect()->route($this->route.'index')->with('flash_success','تم حذف بيانات المستخدم بنجاح');
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            // Display a successful message ...
            return redirect()->route($this->route.'index')->with('flash_danger','خطأ ... لا يمكن الحذف حتي لا تتأثر البيانات الأخري بعملية الحذف !!!');
        }
    }

    public function editProfile($id)
    {
        $row = $this->model::findOrFail($id);

        return view('admin.users.userProfile', compact('row'));
    }


    public function updateProfile(Request $request){

           $validator = Validator::make($request->all(), [
            'f_name' => 'required',
            'l_name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'phone' => 'required|unique:users,phone, '.Auth::user()->id,
            'password' => 'required|min:8',
        ]);

        if($validator->fails()){
            return redirect()->back()->with('flash_danger', $validator->messages());
        }

        try
        {
            $input =$request->except('_token','user_id');
            if($input['password'] != null)
                $input['password'] = \Hash::make($input['password']);
            else
                unset($input['password']);

            $user = $this->model::findOrFail($request->input('user_id'));
            $user->update($input);


            return redirect()->back()->with('flash_success', 'تم حفظ البيانات');

        } catch (\Exception $e) {
            return redirect()->back()->with('flash_danger', $e->getMessage());
        }
    }

}
