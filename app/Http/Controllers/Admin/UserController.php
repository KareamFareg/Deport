<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UtilHelper;
use App\Http\Controllers\AdminController;
use App\Models\Order;
use App\Models\Rate;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\UserType;
use App\Models\Country;
use App\Services\CategoryService;
use App\Services\OrderService;
use App\Services\RoleService;
use App\Services\UserService;
use App\Services\UserTypeService;
use App\Traits\FileUpload;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use App\Models\Transaction;
use App\Traits\Fcm;


class UserController extends AdminController
{

    use FileUpload;
    use Fcm;

    private $userServ;
    private $userTypeServ;
    private $roleServ;
    private $categoryServ;
    private $orderServ;
    private $defaultLanguage;

    public function __construct(
        UserService $userService,
        UserTypeService $userTypeService,
        RoleService $roleService,
        CategoryService $categoryService,
        OrderService $orderService) {
        $this->userServ = $userService;
        $this->userTypeServ = $userTypeService;
        $this->roleServ = $roleService;
        $this->categoryServ = $categoryService;
        $this->orderServ = $orderService;

        $this->share([
            'page' => User::PAGE,
            //'recordsCount' => User::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {

        // $language = $this->defaultLanguage;

        // $categories = collect([]);
        // $data = collect([]);
        // $userTypes = collect([]);
        // $categoryId = $request->category_id;

        // if (Auth::user()->isAdmin()) {
        //     $categories = $this->categoryServ->getAll();
        //     $temp = [];
        //     $categories = UtilHelper::buildTreeRoot($categories, null, $temp, 0, 0);

        //     $userTypes = UserType::orderby('sort')->get();

        //     $data = User::with(['client.client_info' => function ($query) use ($language) {
        //         $query->where('language', $language->locale);
        //     }, 'categories.category_info']);

        //     if ($request->type_id) {
        //         $data->where('type_id', $request->type_id);
        //     }

        //     if ($request->category_id) {
        //         $data->whereHas('categories', function ($query) use ($categoryId) {
        //             $query->where('category_id', $categoryId);
        //         });
        //     };

        //     if ($request->active_status === "0" || $request->active_status === "1") {
        //         $data->where('is_active', $request->active_status);
        //     };

        //     $request->flash();
        //     $data = $data->get();

        // }

        // if (Auth::user()->isClient()) {
        //   $data = User::where('id', Auth::id())->orwhere('client_id',Auth::id())->get();
        // }

        //  return view('admin.users.index', compact(['categories', 'userTypes', 'data']));

        return redirect(route('admin.users.type', ['id' => 1]));

    }
// public function saveToken(Request $request){
 
//     // $user = User::find(Auth::id());
//     $user = User::find(1);

//     $user->fcm_token = $request->token;
//     $user->save();
//     return $user;
// }
    public function getUsersByType(Request $request)
    {


        $request->merge(['id' => $request->route('id')]);

        $request->validate([
            'id' => 'required|integer',
        ], [], ['id' => 'نوع المستخدم']);

        $language = $this->defaultLanguage;

        $data = User::Info();

        if ($request->active_status === "0" || $request->active_status === "1") {
            $data->where('is_active', $request->active_status);
        };

        $data->where('type_id', $request->route('id'));

        $request->flash();

        $data = $data->get();

        $subTitle = '';
        switch ($request->route('id')) {
            case "1":
                $subTitle = __('admin/dashboard.users');
                break;
            case "2":
                $subTitle = __('admin/dashboard.customers');
                break;
            case "3":
                $subTitle = __('admin/dashboard.shippers');
                break;
            case "4":
                $subTitle = __('admin/dashboard.traders');
                break;
            default:
                $subTitle = '';
        }

        $this->share([
            'page' => User::PAGE,
            'recordsCount' => $data->count(),
            'subTitle' => $subTitle,
        ]);

        //dump(Auth::user()->roles()->first()->privileges);

        return view('admin.users.type', compact(['data']));

    }

    public function clients(Request $request)
    {

        $type = 2;
        $typeName = 'clients';
        $data = User::Info();

        if ($request->active_status === "0" || $request->active_status === "1") {
            $data->where('is_active', $request->active_status);
        };

        $data->where('type_id', $type);
        $request->flash();
        $data = $data->get();

        $subTitle = __("admin/dashboard.$typeName");

        $this->share([
            'page' => User::PAGE,
            'recordsCount' => $data->count(),
            'subTitle' => $subTitle,
        ]);

        //dump(Auth::user()->roles()->first()->privileges);

        return view('admin.users.type', compact(['data', 'type', 'typeName']));

    }

    public function coupon(Request $request)
    {

        $coupon = $request->route('coupon');
        $type = 2;
        $typeName = 'clients';

        $userIds = Order::where('coupon', $coupon)->pluck('user_id');

        $data = User::whereIn('id', $userIds);

        if ($request->active_status === "0" || $request->active_status === "1") {
            $data->where('is_active', $request->active_status);
        };

        $data->where('type_id', $type);
        $request->flash();
        $data = $data->get();

        $subTitle = __("admin/dashboard.$typeName");

        $this->share([
            'page' => User::PAGE,
            'recordsCount' => $data->count(),
            'subTitle' => $subTitle,
        ]);

        //dump(Auth::user()->roles()->first()->privileges);

        return view('admin.users.type', compact(['data', 'type', 'typeName']));

    }
    public function shippers(Request $request)
    {
        $type = 3;
        $typeName = 'shippers';
        $data = User::Info();

        if ($request->active_status === "0" || $request->active_status === "1") {
            $data->where('is_active', $request->active_status);
        };

        $data->where('type_id', $type);

        $request->flash();

        $data = $data->get();

        $subTitle = __("admin/dashboard.$typeName");

        $this->share([
            'page' => User::PAGE,
            'recordsCount' => $data->count(),
            'subTitle' => $subTitle,
        ]);

        //dump(Auth::user()->roles()->first()->privileges);

        return view('admin.users.type', compact(['data', 'type', 'typeName']));

    }
    public function traders(Request $request)
    {
        $type = 4;
        $typeName = 'traders';
        $data = User::Info();

        if ($request->active_status === "0" || $request->active_status === "1") {
            $data->where('is_active', $request->active_status);
        };

        $data->where('type_id', $type);

        $request->flash();

        $data = $data->get();

        $subTitle = __("admin/dashboard.$typeName");

        $this->share([
            'page' => User::PAGE,
            'recordsCount' => $data->count(),
            'subTitle' => $subTitle,
        ]);

        //dump(Auth::user()->roles()->first()->privileges);

        return view('admin.users.type', compact(['data', 'type', 'typeName']));

    }

    public function admins(Request $request)
    {

        $type = 1;
        $typeName = 'admins';

        $roles_id = Role::where('level','>',Auth::user()->level())->get()->pluck('id');
        $users_id=RoleUser::whereIn('role_id',$roles_id)->get()->pluck('user_id');

        $data = User::Info();

        if ($request->active_status === "0" || $request->active_status === "1") {
            $data->where('is_active', $request->active_status);
        };

       // $data->where('type_id', $type);
       $data->where('type_id', $type)->whereIn('id',$users_id);

        $request->flash();

        $data = $data->get();

        $subTitle = __("admin/dashboard.$typeName");

        $this->share([
            'page' => User::PAGE,
            'recordsCount' => $data->count(),
            'subTitle' => $subTitle,
        ]);

        //dump(Auth::user()->roles()->first()->privileges);

        return view('admin.users.type', compact(['data', 'type', 'typeName']));

    }

    public function create()
    {

        $roles = Role::all();
        $userTypes = UserType::all();

        $this->share([
            'page' => User::PAGE,
            'subTitle' => '',
        ]);

        return view('admin.users.create', compact(['roles', 'userTypes']));

    }

    public function createClient()
    {
        $type = 2;
        $typeName = 'clients';

        $roles = Role::all();
        $userTypes = UserType::where('id', 2);

        $subTitle = __("admin/dashboard.$typeName");

        $this->share([
            'page' => User::PAGE,
            'subTitle' => $subTitle,
        ]);

        return view('admin.users.create', compact(['roles', 'userTypes', 'type', 'typeName']));

    }
    public function createShipper()
    {


        $type = 3;
        $typeName = 'shippers';

        $roles = Role::all();
        $areas= Country::where('parent_id',1)->get();
        $cities= Country::where('parent_id',$areas->first()->id)->get();
        $userTypes = UserType::where('id', 2);
        $subTitle = __("admin/dashboard.$typeName");

        $this->share([
            'page' => User::PAGE,
            'subTitle' => $subTitle,
        ]);

        return view('admin.users.create', compact(['roles', 'userTypes', 'type', 'typeName','areas','cities']));

    }
    public function createTrader()
    {


        $type = 4;
        $typeName = 'traders';

        $roles = Role::all();
        $areas= Country::where('parent_id',1)->get();
        $cities= Country::where('parent_id',$areas->first()->id)->get();
        $userTypes = UserType::where('id', 4);
        $subTitle = __("admin/dashboard.$typeName");

        $this->share([
            'page' => User::PAGE,
            'subTitle' => $subTitle,
        ]);

        return view('admin.users.create', compact(['roles', 'userTypes', 'type', 'typeName','areas','cities']));

    }

    public function getCities(Request $request){
        $id = $request->id;
        $cities= Country::where('parent_id',$id)->get();

        $data='';
        foreach($cities as $city){
          $data.='<option value="'.$city->id.'">'.$city->translation('ar').'</option>';

        }

        return $data;

    }

    public function createAdmin()
    {
        $type = 1;
        $typeName = 'admins';

        if(Auth::user()->roles()->first()->deletable == 0){
            $roles = Role::where('deletable',1)->get();

          }else{
            $roles = Role::where('deletable',1)->where('level','>',Auth::user()->level())->get();

          }

        $userTypes = UserType::all();
        $subTitle = __("admin/dashboard.$typeName");

        $this->share([
            'page' => User::PAGE,
            'subTitle' => $subTitle,
        ]);

        return view('admin.users.create', compact(['roles', 'userTypes', 'type', 'typeName']));

    }

    public function store(Request $request)
    {

        $request->merge(['name' => UtilHelper::formatNormal($request->name)]);

        $validate = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'nullable|string|email|max:50|unique:users',
            'password' => 'required|string|min:6|max:12|confirmed',
            'phone' => 'nullable|numeric|gt:0|unique:users',
            'type_id' => 'nullable|exists:user_type,id',
            'role' => 'nullable|exists:roles,id',
            'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
            'license' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
            'id_card' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
        ]);

        // if we will create user of type admin then make it verified
        $is_verified = 0;
        if ($request->type_id == 1) {
            $is_verified = 1;
        }

        $user = new User();

        // $user->role = $request->role;
        // $user->client_id = 0;

        $user->type_id = $request->type_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->id_number = $request->id_number;
        $user->area = $request->area;
        $user->city = $request->city;
        $user->password = Hash::make($request->password);
        $user->is_verified = $is_verified;
        $user->ip = UtilHelper::getUserIp();
        $user->access_user_id = Auth::id();
        $user->save();

        // if we will create user of type admin then give hime role
        if ($request->type_id == 1) {
            $roleUser = new RoleUser();
            $roleUser->user_id = $user->id;
            $roleUser->role_id = $request->role;
            $roleUser->save();
        }

        // upload image
        if ($request->hasFile('image')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'image',
                'folder' => user::FILE_FOLDER,
                'recordId' => $user->id,
            ]);
            $user->Update(['image' => $path]);
        }

        if ($request->hasFile('license')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'license',
                'folder' => user::FILE_FOLDER,
                'recordId' => $user->id,
            ]);
            $user->Update(['license' => $path]);
        }
        if ($request->hasFile('id_card')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'id_card',
                'folder' => user::FILE_FOLDER,
                'recordId' => $user->id,
            ]);
            $user->Update(['id_card' => $path]);
        }

        //return redirect(route('admin.users.type', ['id' => $request->type_id]));

        $this->flashAlert(['success' => ['msg' => __('messages.added')]]);
        return redirect(route("admin.$request->typeName.index"));

    }

    public function edit(Request $request)
    {


        $user = User::with('roles')->where('id', $request->id)->firstorfail();

        $roles = [];

        if(Auth::user()->roles()->first()->deletable == 0){
            $roles = Role::where('deletable',1)->get();

          }else{
            $roles = Role::where('deletable',1)->where('level','>',Auth::user()->level())->get();

          }

        $userTypes = UserType::all();

        switch ($user->type_id) {
            case "1":
                $type = 1;
                $typeName = 'admins';
                break;
            case "2":
                $type = 2;
                $typeName = 'clients';
                break;
            case "3":
                $type = 3;
                $typeName = 'shippers';
                break;
            case "4":
                $type = 4;
                $typeName = 'shippers';
                break;
        }

        $subTitle = '';
        switch ($type) {
            case "1":
                $subTitle = __('admin/dashboard.users');
                break;
            case "2":
                $subTitle = __('admin/dashboard.customers');
                break;
            case "3":
                $subTitle = __('admin/dashboard.shippers');
                break;
            case "4":
                $subTitle = __('admin/dashboard.traders');
                break;
            default:
                $subTitle = '';
        }

        $this->share([
            'page' => User::PAGE,
            'subTitle' => $subTitle,
        ]);
        $areas= Country::where('parent_id',1)->get();
        $cities= Country::where('parent_id',$user->area)->get();
        return view('admin.users.edit', compact(['roles', 'userTypes', 'user', 'type', 'typeName','areas','cities']));

    }

    public function edit_profile(Request $request)
    {
        $user = User::with('roles')->where('id',  Auth::id())->firstorfail();
        $roles = [];
        $roles = Role::all();

        $userTypes = UserType::all();

        switch ($user->type_id) {
            case "1":
                $type = 1;
                $typeName = 'admins';
                break;
            case "2":
                $type = 2;
                $typeName = 'clients';
                break;
            case "3":
                $type = 3;
                $typeName = 'shippers';
                break;
            case "4":
                $type = 4;
                $typeName = 'traders';
                break;    
        }

        $subTitle = '';
        switch ($type) {
            case "1":
                $subTitle = __('admin/dashboard.users');
                break;
            case "2":
                $subTitle = __('admin/dashboard.customers');
                break;
            case "3":
                $subTitle = __('admin/dashboard.shippers');
                break;

            case "4":
                $subTitle = __('admin/dashboard.traders');
                break;
            default:
                $subTitle = '';
        }

        $this->share([
            'page' => User::PAGE,
            'subTitle' => $subTitle,
        ]);
        $areas= Country::where('parent_id',1)->get();
        $cities= Country::where('parent_id',$user->area)->get();
        return view('admin.users.edit', compact(['roles', 'userTypes', 'user', 'type', 'typeName','areas','cities']));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);

        $request->merge(['name' => UtilHelper::formatNormal($request->name)]);

        $validate = $request->validate([
            'name' => 'required|string|max:150' ,
            'email' => 'nullable|string|email|max:50|unique:users,email,' . $request->id,
            'password' => 'nullable|string|min:6|max:12|confirmed',
            'phone' => 'required|numeric|gt:0|unique:users,phone,' . $request->id,
            // 'type_id' => 'required|exists:user_type,id',
            'role' => 'nullable|exists:roles,id',
            'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
            'license' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
            'id_card' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
        ]);

        //$user->role = $request->role;
        //$user->type_id = $request->type_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->id_number = $request->id_number;
        $user->area = $request->area;
        $user->city = $request->city;
        $user->gender = $request->gender;
        $user->amount = $request->amount;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        if ($request->carTypeId) {
            $user->carTypeId = $request->carTypeId;
        }
        if ($request->card_number) {
            $user->card_number = $request->card_number;
        }
        if ($request->iBanNum) {
            $user->iBanNum = $request->iBanNum;
        }
        if ($request->benificiaryName) {
            $user->benificiaryName = $request->benificiaryName;
        }
        if ($request->bankIdCode) {
            $user->bankIdCode = $request->bankIdCode;
        }
        if ($request->vehicleSequenceNumber) {
            $user->vehicleSequenceNumber = $request->vehicleSequenceNumber;
        }
        if ($request->dateOfBirth) {
            $user->dateOfBirth = $request->dateOfBirth;
        }
        if ($request->identityTypeId) {
            $user->identityTypeId = $request->identityTypeId;
        }
        if ($request->carType) {
            $user->carTypeId = $request->carType;
        }
        if ($request->carNumber) {
            $user->carNumber = $request->carNumber;
        }
        $user->is_verified = 1;
        $user->ip = UtilHelper::getUserIp();
        $user->access_user_id = Auth::id();
        $user->save();

        if (isset($request->role)) {

            RoleUser::where('user_id', $user->id)->delete();

            $roleUser = new RoleUser();
            $roleUser->user_id = $user->id;
            $roleUser->role_id = $request->role;
            $roleUser->save();
        }

        // upload image
        if ($request->hasFile('image')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'image',
                'folder' => user::FILE_FOLDER,
                'recordId' => $user->id,
            ]);
            $user->Update(['image' => $path]);
        }
        if ($request->hasFile('license')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'license',
                'folder' => user::FILE_FOLDER,
                'recordId' => $user->id,
            ]);
            $user->Update(['license' => $path]);
        }
        if ($request->hasFile('id_card')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'id_card',
                'folder' => user::FILE_FOLDER,
                'recordId' => $user->id,
            ]);
            $user->Update(['id_card' => $path]);
        }

        // return redirect(route('admin.users.type', ['id' => $request->type_id]));

        $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
        return back();

    }

    public function setActive(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        if (!$user) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'msg' => __('messages.not_found'), 'alert' => 'swal']);
            }
            $this->flashAlert(['faild' => ['msg' => __('messages.not_found')]]);
            return back();
        }

        // check to don't deactivate last admin in the system
        if (!$user->roles->isEmpty()) {
            if ($user->roles()->first()->id == 1) {
                if ($this->userServ->getCountActiveAdmins() == 1) {
                    if ($request->ajax()) {
                        return response()->json(['status' => 'error', 'msg' => __('auth.last_active_admin'), 'alert' => 'swal']);
                    }
                    $this->flashAlert(['faild' => ['msg' => __('auth.last_active_admin')]]);
                    return back();
                }
            }
        }

        $status = !$user->is_active;

        $this->userServ->setActive($user, $status);

        if($user->is_active == 0){
            $user->revokeAccessTokenByUser($user->id);
        }

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'msg' => __('messages.updated'), 'alert' => 'swal']);
        }
        $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
        return back();

    }

    public function setApproved(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        $user->update([ 'approved' => !$user->approved ]);

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'msg' => __('messages.updated'), 'alert' => 'swal']);
        }
        $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
        return back();

    }

    public function updateFcmWeb(Request $request)
    {
        User::where('id', Auth::id())->update(['fcm_token' => $request->token]);
        // return response()->json($request->all());
    }

    public function notification_readed(Request $request)
    {
        $notification = Notification::where(['user_reciever_id'=>Auth::id(),'read_at'=>null])->update(['read_at' => UtilHelper::currentDate()]);

    }

    public function notification_readed_by_user_id($id)
    {
        $notification = Notification::where(['user_reciever_id'=>0,'user_sender_id'=>$id,'read_at'=>null])->update(['read_at' => UtilHelper::currentDate()]);

    }

    public function deleteUser(Request $request)
    {

        // $id = $request->route('id');
        $id = $_GET['id'];
        $user = User::find($id);
        //if ($user->type_id == 1) {
        if (User::where('type_id', 1)->count() == 1) {
            return response()->json(['error' => __('messages.deleted_faild')]);
        }
        $user->delete();

        //deleteFromFirebase

        $serviceAccount = ServiceAccount::fromJsonFile(base_path() . '/kafoo-2a7a1-firebase-adminsdk-ht8n2-120c062d88.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://kafoo-2a7a1-default-rtdb.firebaseio.com/')
            ->create();


            $database = $firebase->getDatabase();
            $database->getReference('Delegates/'.$id)->remove();
            $database->getReference('Locations/'.$id)->remove();
            $database->getReference('Status/'.$id)->remove();


        return  response()->json(['success' => __('messages.deleted')]);

        // }

    }

    public function deleteFromFirebase($id)
    {
        return view('admin.users.deleteFromFirebase', compact(['id']))->render();
    }

    public function rate(Request $request)
    {
        $id = $request->route('id');
        $rates = Rate::where('user_id',$id)->orderBy('id','desc')->get();

        $user = User::with('roles')->where('id', $id)->firstorfail();

        switch ($user->type_id) {
            case "1":
                $type = 1;
                $typeName = 'admins';
                break;
            case "2":
                $type = 2;
                $typeName = 'clients';
                break;
            case "3":
                $type = 3;
                $typeName = 'shippers';
                break;
                case "4":
                    $type = 4;
                    $typeName = 'traders';
                    break;
        }

        $subTitle = '';
        switch ($type) {
            case "1":
                $subTitle = __('admin/dashboard.users');
                break;
            case "2":
                $subTitle = __('admin/dashboard.customers');
                break;
            case "3":
                $subTitle = __('admin/dashboard.shippers');
                break;
                case "4":
                    $subTitle = __('admin/dashboard.traders');
                    break;
            default:
                $subTitle = '';
        }

        $this->share([
            'page' => User::PAGE,
            'subTitle' => $subTitle,
        ]);

        return view('admin.users.rate', compact(['user', 'type', 'typeName','rates']));
    }

    public function wallet(Request $request)
    {
        $id = $request->route('id');

        $data['user']=User::findOrFail($id);
        $data['wallet_transactions']= Transaction::where(['user_id' => $id,'method'=>'wallet'])->orderBy('id', 'desc')->get();
        $data['online_transactions']= Transaction::where(['user_id' => $id,'method'=>'online'])->orderBy('id', 'desc')->get();

      return view('admin.users.wallet',$data);
    }

    public function charge_wallet(Request $request)
    {
        $id = $request->user_id;
        $amount = $request->amount;
        $note = $request->message;

        $client = User::where(['type_id' => 2])->find($id);
        if ($client) {
            $client->amount = $client->amount + $amount;
            $client->save();

            $data['title'] = 'wallet_charged';
            $data['amount'] = $amount;
            $data['date'] = \Carbon\Carbon::now();
            $data['description'] = "add_amount_from_admin";
            $data['message'] = $note;
            $data['user_id'] = $client->id;
            Transaction::create($data);




        $msg['user_sender'] = 0;
        $msg['user_reciever'] = $id;
        //$msg['order'] = '';
        $msg['type'] = 11;
        $msg['title'] = __('messages.wallet_charged');
        $msg['body'] = __('messages.charge_wallet_message_admin', ['message' => $request->message]);



        $user=User::find($id);
        $this->sendFcm($client->mobile_type, $client->fcm_token, $msg);


        $data['user_sender_id'] = 0;
        $data['user_reciever_id'] = $id;
        $data['table_name'] = '';
        $data['table_id'] = 0;
        $data['type'] = 11; // order 1 , 2 chat
        $data['title'] = 'wallet_charged';
        $data['data'] = 'charge_wallet_message_admin';
        $data['params'] = ['message' => $request->message ];

         Notification::Create($data);






            $this->flashAlert(['success' => ['msg' => __('messages.added')]]);
        return back();
        }
        $this->flashAlert(['faild' => ['msg' => __('messages.added_faild')]]);
        return back();
    }
}
