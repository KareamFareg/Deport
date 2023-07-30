<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Http\Resources\UserResource;
use App\Models\Transaction;
use App\Services\ClientService;
use App\Services\FileUploadService;
use App\Services\ItemService;
use App\Services\SettingService;
use App\Services\UserService;
use App\Services\VerificationService;
use App\Traits\ApiResponse;
// use App\Http\Resources\ItemCollectionResource;
use Illuminate\Support\Facades\Http;
use App\Traits\FileUpload;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Traits\GeneralTrait;
use App\Helpers\UtilHelper;
use App\Traits\TawseelDriver;

class UserController extends Controller
{
    use GeneralTrait,FileUpload ,ApiResponse,TawseelDriver;
    private $userServ;
    private $clientServ;
    private $verificationServ;
    private $settingServ;
    private $itemServ;
    private $fileServ;
    private $defaultLanguage;

    public function __construct(
        UserService $userService,
        ClientService $clientService,
        VerificationService $verificationService,
        SettingService $settingService,
        ItemService $itemService,
        FileUploadService $fileService) {

        $this->userServ = $userService;
        $this->clientServ = $clientService;
        $this->verificationServ = $verificationService;
        $this->settingServ = $settingService;
        $this->itemServ = $itemService;
        $this->fileServ = $fileService;

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index()
    {

    }

//check user  throw his id
    public function check_user(Request $request)
    {
        
        $user = User::where(['id' => $request->user_id])->first();
        
        if(!$user){
            
            $response = ['errors' => ['phone' => trans('messages.deleted')]];
            return $this->responseFaild($response, 401);
        }else{
            if($user->type_id == 3){
                 return $this->responseSuccess(['Driver' => $user]);
            }else{
                   return $this->responseSuccess([ 'Client' => $user]);
            }
        }
    }

//User Login with [phone and password and his type (client or driver)]
    public function login(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|numeric',
            'password' => 'required|string',
            'type' => 'required|numeric',
        ]);

        $user = User::where(['phone' => $request->phone, 'type_id' => $request->type])->first();
        if (!$user) {
            $response = ['errors' => ['phone' => trans('auth.wrong_phone')]];
            return $this->responseFaild($response, 401);
        }


        if ($user->isVerified(0)) {
            // createVerification
            $user->verification_code = $this->verificationServ->createVerification($user->id);

            $response = [
                'code' => 401,
                'errors' => ['User' => trans('auth.not_verified') . trans('auth.please_verify')],
                'data' => $user->only('id', 'name', 'email', 'phone', 'type_id', 'image', 'verification_code','approved', 'access_token', 'ip', 'created_at'),
            ];
            return $this->responseFaild($response, 401);
        }

        if (!auth()->attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $response = ['errors' => ['User' => trans('auth.wrong_password')]];
            return $this->responseFaild($response, 401);
        }

        $isUserValid = $this->userServ->isUserValid($user);
        if (!empty($isUserValid)) { // active , verifid
            $response = ['errors' => ['user' => $isUserValid['error']]];
            return $this->responseFaild($response, 401);
        }

        $user->lang = app()->getLocale();
        $user->save();
        // createToken
        $user->revokeAccessTokenByUser($user->id);
        $user->access_token = $user->createToken('LaraApp')->accessToken;
        
        // to send user description with data
        // $user->load('client.client_info');
        //$user->description = !$user->client->client_info->isEmpty() ? $user->client->client_info->first()->description : null;



        // send success
        $response = [
            'message' => ['sucess' => [trans('auth.login_success')]],
            // 'data' => $user->only('id','name','email','phone','type_id','image','verification_code','access_token','ip','created_at'), // original
            'data' => $user->only('id', 'name', 'email', 'phone', 'type_id' , 'image', 'banner', 'verification_code','approved','access_token', 'ip', 'created_at','gender'),
        ];
        return $this->responseSuccess($response);

    }

//User Registiration (all register as anormal user)
    public function register(ClientRequest $request)
    {
        $rules = [
            'phone' => 'required_if:loginField,==,"phone"|numeric|gt:0|unique:users',
            'password' => 'nullable|string|min:8|max:12',
            'type_id' => [ 'required', Rule::in([ 2 , 3 ,5 ]) ], // 'exists:user_type,id',
            
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        $code = $this->returnCodeAccordingToInput($validator);
        return $this->returnValidationError($code, $validator);
    };


    $user = new User();
    $user->type_id = $request['type_id'];
    //$user->role = $request['role'];

    $user->phone = $request['phone']; // $request['phone'];
    $user->password = Hash::make($request['password']);
    $user->is_verified = 0;
    $user->lang = app()->getLocale();
    $user->ip = UtilHelper::getUserIp();
    $user->save();
        
        // $locale = app()->getLocale();

        // $validateClientNameLanguage = $this->userServ->validateClientNameLanguage($request->name, $locale);
        // if ($validateClientNameLanguage) {
        //     $response = [
        //         'errors' => ['user_name' => __('messages.duplicate_title_language')],
        //     ];
        //     return $this->responseFaild($response, 422);
        // }
        // store
        // $user = $this->userServ->store(array_merge(
        //     $request->all(), ['is_verified' => 0])
        // );
        if (!$user) {
            $response = ['errors' => ['User' => trans('auth.registration_faild')]];
            return $this->responseFaild($response);
        }

        // $client = $this->clientServ->store(array_merge(
        //     $request->validated(), ['user_id' => $user->id])
        // );
        // if (!$client) {
        //     $response = ['errors' => ['User' => trans('auth.registration_faild')]];
        //     return $this->responseFaild($response);
        // }

        // $clientInfo = $this->clientServ->storeInfo(array_merge(
        //     $request->validated(), ['language' => $locale, 'client_id' => $client->id, 'user_id' => $user->id])
        // );
        // if (!$clientInfo) {
        //     $response = ['errors' => ['User' => trans('auth.registration_faild')]];
        //     return $this->responseFaild($response);
        // }

        // \App\Models\RoleUser::create(['user_id' => $user->id, 'role_id' => User::SITE_ROLE]);

        $user->access_user_id = $user->id;

        // createToken
        $user->access_token = $user->createToken('LaraApp')->accessToken; // ????????? LaraApp or $request->input('email')

        // createVerification
        $user->verification_code = $this->verificationServ->createVerification($user->id);

        // send success
        
        $response = [
            'code' => 200,
            'status'=>'sucess',
            'message' =>  trans('auth.registration_success') . trans('auth.please_verify'),
            'data' => $user->only('id', 'name' , 'email', 'phone', 'type_id', 'image', 'verification_code', 'access_token', 'ip', 'created_at','gender'),
        ];
        $message =  trans('auth.registration_success') . trans('auth.please_verify');
        return $this->returnData('user',$user,$message);
        // return $this->responseSuccess($response);

    }
//user forget his password and return it back throw phone (verfication code)
    public function forgotPassworod(Request $request)
    {

        $this->validate($request, [
            'phone' => 'required|numeric',
        ]);

        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            $response = [
                'errors' => ['phone' => [trans('auth.wrong_phone')]],
            ];
            return $this->responseFaild($response, 401);
        }

        $user->verification_code = $this->verificationServ->createVerification($user->id);

        $response = [
            //'code' => 4012,
            'data' => $user->only('id' ,'phone', 'type_id', 'verification_code', 'ip', 'created_at'),
        ];
        
   
        return $this->responseSuccess($response);

    }
// store new password in db
    public function changePassworod(Request $request)
    {

        $this->validate($request, [
            'code' => 'required|numeric',
            'phone' => 'required|numeric',
            'password' => 'required|string|min:6|max:12',
        ]);

        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            $response = [
                'errors' => ['phone' => trans('auth.wrong_phone')],
            ];
            return $this->responseFaild($response, 401);
        }

        // ---------- same as VerficationControllor@checkVerificationCodePasword ------
        if ($user->isVerified(0)) {
            $response = [
                'errors' => ['verification' => trans('verification.not_verified')],
            ];
            return $this->responseFaild($response, 422);
        }

        $userVerification = $this->verificationServ->getUserVerification($user->id);
        if (!$userVerification) {
            $response = [
                'errors' => ['verification' => trans('verification.error_verification_code')],
            ];
            return $this->responseFaild($response, 422);
        }

        $checkVerificationCode = $this->verificationServ->checkVerificationCodePassword($userVerification, $request->code);
        if (!$checkVerificationCode) {
            $response = [
                'errors' => ['verification' => trans('verification.wrong_verification_code')],
            ];
            return $this->responseFaild($response, 422);
        }

        \App\Models\Verification::where('user_id', $user->id)->delete();
        //-----------------------------------------------------------------------

        $user->password = Hash::make($request['password']);
        $user->save();

        $response = [
            'message' => ['sucess' => [trans('auth.password_updated')]],
        ];
        return $this->responseSuccess($response);

    }

    // public function resendCode(Request $request)
    // {

    //     $verification_code = $this->verificationServ->createVerification($request->user_id);

    //     // send sms or
    //     $response = [
    //         'data' => $verification_code,
    //     ];
    //     return $this->responseSuccess($response);

    // }

    public function createRandomPassword(Request $request)
    {

        $user = User::findOrFail($request->user_id);

        if ($user->type_id != 2 && $user->type_id != 5) {
            $response = [
                'errors' => ['subscription' => [trans('general.proccess_not_Alloewd')]],
            ];
            return $this->responseFaild($response, 401);
        }

        if ($user->isActive(0)) {
            $response = [
                'errors' => ['subscription' => [trans('auth.in_active')]],
            ];
            return $this->responseFaild($response, 401);
        }

        if ($user->isActiveAdmin(0)) {
            $response = [
                'errors' => ['subscription' => [trans('auth.in_active')]],
            ];
            return $this->responseFaild($response, 401);
        }

        $randPassword = $this->userServ->createRandomPassword($user);

        $response = [
            'data' => $randPassword,
        ];
        return $this->responseSuccess($response);

    }

    public function updateFcm(Request $request, $id)
    {

        $this->validate($request, [
            'fcm_token' => 'required',
            'mobile_type' => 'required|max:30|in:android,ios',
        ]);

        $user = User::find($id);
        $update= $user->update(['fcm_token' => $request->fcm_token, 'mobile_type' => $request->mobile_type]);
        // $update = $this->userServ->updateFcm($user, $request);
        if (!$update) {
            $response = [
                'errors' => ['subscription' => trans('messages.updated_faild')],
            ];
            return $this->responseFaild($response);
        }

        // success
        $response = ['message' => ['sucess' => trans('messages.updated')],
               'data' => $user];
        return $this->responseSuccess($response);
    }
//logout throw make token is empty value
public function logout(Request $request)
{

    $user = User::findOrFail($request->user_id);

    if ($user) {
        // $user->update(['fcm_token' => ' ','remember_token' => ' ']);
        $user->revokeAccessTokenByUser($user->id);
    }
    // success
    $response = ['message' => ['sucess' => "تم تسجيل الخروج بنجاح"]];
    return $this->responseSuccess($response);

}


    // ----------------------------------
    // ----------------------------------
//make user to change background banner  
    public function updateBackground(Request $request, $id)
    {

        $this->validate($request, [
            'banner' => 'required|file|image|mimes:jpeg,png,gif,jpg|max:1024',
        ]);

        $user = User::findOrFail($id);

        $path = $this->storeFile($request, [
            'fileUpload' => 'banner',
            'folder' => User::FILE_FOLDER,
            'recordId' => $id . '_banner',
        ]);

        if ($path === false) {
            $response = ['errors' => ['banner' => trans('messages.error_upload_image')]];
            return $this->responseFaild($response);
        }

        if ($user->Update(['banner' => $path]) == false) {
            $response = ['errors' => ['banner' => trans('messages.updated')]];
            return $this->responseFaild($response);
        }

        // success
        $response = ['message' => ['sucess' => trans('messages.updated')]];
        return $this->responseSuccess($response);

    }
//make user to change his profile image   

    public function updateImage(Request $request, $id)
    {

        $this->validate($request, [
            'image' => 'required|file|image|mimes:jpeg,png,gif,jpg|max:1024',
        ]);

        $user = User::findOrFail($id);

        $path = $this->storeFile($request, [
            'fileUpload' => 'image',
            'folder' => User::FILE_FOLDER,
            'recordId' => $id . '_image',
        ]);

        if ($path === false) {
            $response = ['errors' => ['image' => trans('messages.error_upload_image')]];
            return $this->responseFaild($response);
        }

        if ($user->Update(['image' => $path]) == false) {
            $response = ['errors' => ['image' => trans('messages.updated')]];
            return $this->responseFaild($response);
        }

        // success
        $response = ['message' => ['sucess' => trans('messages.updated')]];
        return $this->responseSuccess($response);

    }

//get user by his id
    public function edit(Request $request)
    {
        
        // $user = $this->userServ->getUserById($request->id);
        // if (!$user) {
        //     throw new ModelNotFoundException;
        // }
  
        $user = User::where(['id' => $request->id])->first();
        
        if(!$user){
            
            $response = ['errors' => ['phone' => trans('messages.deleted')]];
            return $this->responseFaild($response, 401);
        }else{
            if($user->type_id == 3){
                 return $this->responseSuccess(['Driver' => $user]);

            }else{
                   return $this->responseSuccess([ 'Client' => $user]);
            }
        }
              
    }
//make user to update his profile data 
public function update(Request $request)
{
    $user = User::findOrFail($request->id);
   
    $isUserValid = $this->userServ->isUserValid($user);
    if (!empty($isUserValid)) { // active , verifid
        $response = ['errors' => ['user' => $isUserValid['error']]];
        return $this->responseFaild($response, 401);
    }
    if (isset($request->email ) && $user->email != $request->email) {
        $rules = [
            'email' => 'email|unique:users',
    ];
   
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {

            $response = "هذا الايميل محجوز من قيل";
            $this->responseFaild($response, 401);
        };
        $user->email = $request->email;
    }
    if(isset($request->regionId)){$user->region_id = $request->regionId;}
    if(isset($request->cityId)){$user->city_id = $request->cityId;}  
    if(isset($request->gender)){$user->gender = $request->gender; }
    if(isset($request->identityTypeId)){ $user->identityTypeId = $request->identityTypeId;}
    if(isset($request->idNumber)){ $user->idNumber = $request->idNumber;}
    if(isset($request->carNumber)){ $user->carNumber = $request->carNumber;}
    if(isset($request->carTypeId)){ $user->carTypeId = $request->carTypeId;}
    if(isset($request->vehicleSequenceNumber)){ $user->vehicleSequenceNumber = $request->vehicleSequenceNumber;}
    if(isset($request->dateOfBirth)){ $user->dateOfBirth = $request->dateOfBirth;}

     $user->save();
     $function ="";
     if($user->type_id == 3 && $user->refrenceCode == null){
       //create tawseel profile
       $function = $this->createTawseel($request,$user);
        // $function = "this from create new tawseel";

     }elseif($user->type_id == 3 && $user->refrenceCode !== null){
       //update tawseel profile
        $this->updateTawseel($request,$user);
        $function = "this from update tawseel";
     }


    $user = $this->userServ->update($request, $user);
    if (!$user) {
        if($request['type_id'] == 3){
            $response = [
                'code' => 200,
                'status'=> "error",
                'errors' => ['user_update' => trans('messages.updated_faild')],
                'data'=>$request->name
            ];
        }else{
            $response = [
                'code' => 200,
                'status'=> "error",
                'errors' => ['user_update' => trans('messages.updated_faild')],
                'data'=>$request->name
                
            ];
        }
        
        return $this->responseFaild($response);
    }

    // success
    if($user->type_id == 3){
        $response = [
            'code' => 200,
            'status'=> "sucess",
            'msg'=>$function,
            'message' => ['sucess' => trans('messages.updated')],
             "data"    => $user
         ];
    }else{
        $response = [
             'code'=>200,
             'status'=> "sucess",
             'msg'=>$function,
             'message' => ['sucess' => trans('messages.updated')],
             "data"    => $user
         ];
    }
   
    return $this->responseSuccess($response);

}
public function createTawseel($request , $user){
    $TawseelResponse = $this->CreatDriverInTawseel($request,$user);
    if($TawseelResponse['tawseelStatus'] == false){
           $user->TawseelErrorMessage = $TawseelResponse['TawseelErrorMessage'];
           $user->save();
        }else{
           $user->TawseelErrorMessage = null;
           $user->idNumber = $TawseelResponse['idNumber'];
           $user->identityTypeId = $TawseelResponse['identityTypeId'];
           $user->refrenceCode = $TawseelResponse['refrenceCode'];
           $user->save();
        }  
         return  $TawseelResponse;
}
public function updateTawseel($request , $user){
    if(isset($request->city_id)){ $user->city_id = $request->city_id;}
    if(isset($request->region_id)){ $user->region_id = $request->region_id;}
    $user->TawseelErrorMessage = null;
        $user->save();
       $TawseelResponse = $this->UpdateDriverInTawseel($request , $user);

       if($TawseelResponse['tawseelStatus'] == false){
        $user->TawseelErrorMessage = $TawseelResponse['TawseelErrorMessage'];
        $user->idNumber = $request->idNumber;
        $user->identityTypeId = $request->identityTypeId;
        $user->save();
     }else{
        $user->TawseelErrorMessage = null;
        $user->save();
    }
}
//return Driver activity or his Acheivement  [his Movement on site] 
    public function shipperAmount($id)
    {
        
        $shipper = User::where(['type_id' => 3])->find($id);
        
     
        if ($shipper) {
            $ordersIds = \App\Models\Order::where(['shipper_id' => $id, 'status' => 4])->pluck('id');
            $data['orders_price'] = $shipper->orders_price($ordersIds, 0);
            $data['orders_count'] = \App\Models\Order::where(['shipper_id' => $id, 'status' => 4])->count();
            $data['shipping_price'] = $shipper->shipping_price($ordersIds, 0);
            $data['shipper_amount'] = $shipper->shipper_amount($ordersIds, 0);
            $data['commission'] = $shipper->commission($ordersIds, 0);
            $data['discount'] = $shipper->discount($ordersIds, 0);
            $data['payment_cash'] = $shipper->payment($ordersIds, 1, 0);
            $data['payment_wallet'] = $shipper->payment($ordersIds, 2, 0);
            $data['payment_online'] = $shipper->payment($ordersIds, 3, 0);
            $data['charge_wallet'] = $shipper->charge_wallet($ordersIds, 0);
            $data['deserved_amount'] = $shipper->deserved_amount($ordersIds, 0);

            $response = [  'data' => $data];
            return $this->responseSuccess($response);
        }

        $response = [
            'message' => ['error' => 'Shipper Not Found'],
        ];
        return $this->responseFaild($response);
    }
    
    //return Client activity or his Acheivement [his Movement on site]
    public function clientAmount($id)
    {
        $client = User::where(['type_id' => 2])->find($id);
        if ($client) {
            $data['amount'] = $client->amount;
            $transactions = Transaction::where(['user_id' => $id,'method'=>'wallet'])->orderBy('id', 'desc')->get();
            $transactionData = [];
            foreach ($transactions as $transaction) {
                $transactionDetails['id'] = $transaction->id;
                //$transactionDetails['lang']=app()->getLocale();
                $transactionDetails['user_id'] = $transaction->user_id;
                $transactionDetails['amount'] = $transaction->amount;
                $transactionDetails['date'] = $transaction->date;
                $transactionDetails['title'] = __('messages.' . $transaction->title);
                $transactionDetails['description'] = __('messages.' . $transaction->description, ['amount' => $transaction->amount, 'order' => $transaction->order_code,'user_name'=>$transaction->user_name,'message'=>$transaction->message]);

                $transactionData[] = $transactionDetails;
            }
            $data['transaction_history'] = $transactionData;

            $response = ['data' => $data];
            return $this->responseSuccess($response);
        }

        $response = [
            'message' => ['error' => 'Client Not Found'],
        ];
        return $this->responseFaild($response);
    }

// enable client to add Money to his Wallet
    public function add_balance(Request $request)
    {
        $id = $request->user_id;
        $amount = $request->amount;

        $client = User::where(['type_id' => 2])->find($id);
        if ($client) {
            $client->amount = $client->amount + $amount;
            $client->save();

            $data['title'] = 'wallet_charged';
            $data['amount'] = $amount;
            $data['date'] = \Carbon\Carbon::now();
            $data['description'] = "add_amount";
            $data['user_id'] = $client->id;
            Transaction::create($data);

            $response = ['message' => ['seccess' => __('messages.updated')]];
            return $this->responseSuccess($response);
        }

        $response = ['message' => ['error' => 'Client Not Found']];
        return $this->responseFaild($response);
    }
//update user language
    public function update_lang(Request $request)
    {
        $id = $request->user_id;
        $lang = $request->lang;
       // $lang = ['user' => 1, 'name' => 'salem'];
        $user = User::find($id);
        if ($user) {
            $user->lang = $lang;
            $user->save();

            $response = ['message' => ['seccess' => __('messages.updated')]];
            return $this->responseSuccess($response);
        }

        $response = ['message' => ['error' => 'Client Not Found']];
        return $this->responseFaild($response);
    }

    public function changeUserStatus(Request $request){
        $user = User::find($request->user_id);
        $resp = $this->userServ->setActive($user,$request->status);
        if($resp){
            return response()->json([
                "code"=>200,
                "status" => "seccess",
                "message"=>__('messages.updated'),
                "data"=>[$user]
              ]);
        }else{
            return response()->json([
                "code"=>200,
                "status" => "error",
                "message"=>trans('messages.updated_faild'),
                "data"=>[]
              ]);
        }
     
    }
    

//this comment
    // public function getOffers(Request $request)
    // {

    //     $user = $this->userServ->getUserById($request->id);
    //     if (!$user) {
    //         throw new ModelNotFoundException;
    //     }

    //     $data = $this->itemServ->itemSummery([
    //         'where' => ['is_active' => 1, 'user_id' => $request->id, 'type_id' => 1],
    //         'user_id' => $request->id,
    //         'paginate' => 2,
    //     ]);

    //     // return response()->json($data);

    //     if (empty($data->all())) {
    //         throw new ModelNotFoundException;
    //     }

    //     return $this->responseSuccess([
    //         'data' => ItemResource::collection($data),
    //         'paginate' => [
    //             'total' => $data->total(),
    //             'lastPage' => $data->lastPage(),
    //             'currentPage' => $data->currentPage(),
    //         ],
    //     ], 206);

    //     // $data->append = $data->lastPage();
    //     // return response()->json($data);

    //     // return $this->responseSuccess([
    //     //   'data' => ItemResource::collection($data)  ,
    //     // ] , 206 );

    //     // return ItemResource::collection($data);

    //     $a = new ItemCollectionResource($data);

    //     // return(json_encode( $a));
    //     // return $a->lastPage();
    //     return $this->responseSuccessPages(['s' => 'ssss', 'data' => $a]);

    //     // return
    //     //   new ItemCollectionResource($data)
    //     // ;

    // }

    // public function getCoupons(Request $request)
    // {

    //     $user = $this->userServ->getUserById($request->id);
    //     if (!$user) {
    //         throw new ModelNotFoundException;
    //     }

    //     $data = $this->itemServ->itemSummery([
    //         'where' => ['is_active' => 1, 'user_id' => $request->id, 'type_id' => 2],
    //         'user_id' => $request->id,
    //         'paginate' => 5,
    //     ]);

    //     if (empty($data->all())) {
    //         throw new ModelNotFoundException;
    //     }

    //     return $this->responseSuccess([
    //         'data' => ItemResource::collection($data),
    //         'paginate' => [
    //             'total' => $data->total(),
    //             'lastPage' => $data->lastPage(),
    //             'currentPage' => $data->currentPage(),
    //         ],
    //     ], 206);

    // }

    // public function getLikes(Request $request)
    // {

    //     $user = $this->userServ->getUserById($request->id);
    //     if (!$user) {
    //         throw new ModelNotFoundException;
    //     }

    //     $data = $this->itemServ->getUserItemsLikes($request->id);

    //     if (empty($data->all())) {
    //         throw new ModelNotFoundException;
    //     }

    //     return $this->responseSuccess([
    //         'data' => ItemResource::collection($data),
    //         'paginate' => [
    //             'total' => $data->total(),
    //             'lastPage' => $data->lastPage(),
    //             'currentPage' => $data->currentPage(),
    //         ],
    //     ], 206);

    // }

    // public function getLikesOffers(Request $request)
    // {

    //     $user = $this->userServ->getUserById($request->id);
    //     if (!$user) {
    //         throw new ModelNotFoundException;
    //     }

    //     $data = $this->itemServ->getUserItemsLikesOffers($request->id);

    //     if (empty($data->all())) {
    //         throw new ModelNotFoundException;
    //     }

    //     return $this->responseSuccess([
    //         'data' => ItemResource::collection($data),
    //         'paginate' => [
    //             'total' => $data->total(),
    //             'lastPage' => $data->lastPage(),
    //             'currentPage' => $data->currentPage(),
    //         ],
    //     ], 206);

    // }

    // public function getLikesCoupons(Request $request)
    // {

    //     $user = $this->userServ->getUserById($request->id);
    //     if (!$user) {
    //         throw new ModelNotFoundException;
    //     }

    //     $data = $this->itemServ->getUserItemsLikesCoupons($request->id);

    //     if (empty($data->all())) {
    //         throw new ModelNotFoundException;
    //     }

    //     return $this->responseSuccess([
    //         'data' => ItemResource::collection($data),
    //         'paginate' => [
    //             'total' => $data->total(),
    //             'lastPage' => $data->lastPage(),
    //             'currentPage' => $data->currentPage(),
    //         ],
    //     ], 206);

    // }

    // public function getComments(Request $request)
    // {

    //     $user = $this->userServ->getUserById($request->id);
    //     if (!$user) {
    //         throw new ModelNotFoundException;
    //     }

    //     $data = $this->itemServ->getUserItemsComments($request->id);

    //     if (empty($data->all())) {
    //         throw new ModelNotFoundException;
    //     }

    //     return $this->responseSuccess([
    //         'data' => ItemResource::collection($data),
    //         'paginate' => [
    //             'total' => $data->total(),
    //             'lastPage' => $data->lastPage(),
    //             'currentPage' => $data->currentPage(),
    //         ],
    //     ], 206);

    // }

    // public function getImages(Request $request)
    // {

    //     $user = $this->userServ->getUserById($request->id);
    //     if (!$user) {
    //         throw new ModelNotFoundException;
    //     }

    //     $data = $this->fileServ->getFilesOfUserItems($request->id, 6);

    //     return $this->responseSuccess([
    //         'data' => UserAlbumeResource::collection($data),
    //         'paginate' => [
    //             'total' => $data->total(),
    //             'lastPage' => $data->lastPage(),
    //             'currentPage' => $data->currentPage(),
    //         ],
    //     ], 206);

    // }

}
