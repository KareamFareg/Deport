<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Requests\ClientRequest;
use App\Helpers\UtilHelper;
use App\Helpers\CommonHelper;

use App\User;
use App\Services\UserService;
use App\Services\ClientService;
use App\Services\VerificationService;
use App\Services\SettingService;
use App\Services\ItemService;
use App\Services\FileUploadService;

use App\Models\Client;
use App\Models\ClientInfo;
use App\Models\UserType;
// use App\Models\Language;
use App\Traits\FileUpload;
use Auth;

class UserController extends Controller
{
    use FileUpload;
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
      FileUploadService $fileService)
    {

      $this->userServ = $userService;
      $this->clientServ = $clientService;
      $this->verificationServ = $verificationService;
      $this->settingServ = $settingService;
      $this->itemServ = $itemService;
      $this->fileServ = $fileService;

      $this->defaultLanguage = $this->defaultLanguage();

    }


    public function updateBackground(Request $request)
    {


      if ($request->hasFile('banner')) {
          $validate = $this->userServ->validateStoreBanner( $request->file('banner') );
          if ($validate !== true) {
            if ($request->ajax())
            { return response()->json(array('status'=>'validation' , 'msg' => $validate )); }
          }

          $storeImage = $this->userServ->storeBanner( $request->file('banner') , Auth::id() );
          User::where( 'id' , Auth::id() )->update( ['banner' => $storeImage ] );

          if ($request->ajax())
          { return response()->json(array('status'=>'success')); }
      }

      return;

    }

    public function updateImage(Request $request)
    {

      if ($request->hasFile('image')) {
          $validate = $this->userServ->validateStoreBanner( $request->file('image') );
          if ($validate !== true) {
            if ($request->ajax())
            { return response()->json(array('status'=>'validation' , 'msg' => $validate )); }
          }

          $storeImage = $this->userServ->storeImage( $request->file('image') , Auth::id() );
          User::where( 'id' , Auth::id() )->update( ['image' => $storeImage ] );

          if ($request->ajax())
          { return response()->json(array('status'=>'success')); }
      }

      return;

    }

    public function show($id ,Request $request)
    {

    }

    public function edit(Request $request)
    {

      $this->checkCurrentAuth($request->id);

      $user = $this->userServ->getUserById($request->id);

      if (!$user) { abort(404); }

      $images = $this->fileServ->getFilesOfUserItems($request->id,7)->all();

      $page = 'profile';

      return view('front.users.many-data' , compact(['user','images','page']));

    }

    public function update(ClientRequest $request)
    {


      $user = User::findOrFail(Auth::id());
      $client = Client::where('user_id',Auth::id())->first();
      $clientInfo = ClientInfo::where('client_id',$client->id)->first();

      $defaultLanguage = $this->defaultLanguage->locale;

      // check dublicate title
      $checkTitle = ClientInfo::where('title',$request->name)->where('language',$defaultLanguage)->where('id','!=',$clientInfo->id)->exists();
      if ($checkTitle){
        return back()->withinput()->withErrors(['name' => __('messages.duplicate_title_language') ]);
      }

      // update
      $user = $this->userServ->update( array_merge(
            $request->validated() , ['access_user_id' => Auth::id()]) , $user
      );
      if (! $user) {
        return back()->withinput()->withErrors(['general' => __('messages.updated_faild') ]);
      }


      $client = $this->clientServ->update( array_merge(
        $request->validated() , ['access_user_id' => Auth::id()]) , $client
      );
      if (! $client) {
        return back()->withinput()->withErrors(['general' => __('messages.updated_faild') ]);
      }

      $clientInfo = $this->clientServ->updateInfo( array_merge(
        $request->validated() , [ 'access_user_id' => $user->id ]) , $clientInfo
      );
      if (! $clientInfo) {
        return back()->withinput()->withErrors(['general' => __('messages.updated_faild') ]);
      }

      $this->flashAlert([
        'success' => ['msg'=> __('messages.updated')]
      ]);
      return back()->withinput();

    }

    public function getCoupons(Request $request)
    {

        $this->checkCurrentAuth($request->id);

        $user = $this->userServ->getUserById($request->id);

        if (!$user) { abort(404); }

        $data = $this->itemServ->itemSummery([
            'where' => [ 'is_active' => 1 , 'user_id' => $request->id, 'type_id' => 2] ,  // Auth::id()
            'paginate'=> 2
          ]);

        if ($request->ajax()) {
            return response()->json(array(
            'status' => 'success',
            'html' => view('components.front.items' , [ 'data' => $data ])->render(),
            'paginate' => view('components.front.paginate' , [ 'nextUrl' => $data->nextPageUrl() ])->render()
            )
          );
        };

        $images = $this->fileServ->getFilesOfUserItems($request->id,7)->all();

        $page = 'coupons';

        return view('front.users.many-data' , compact(['data','user','images','page']));

    }

    public function getOffers(Request $request)
    {

        $this->checkCurrentAuth($request->id);

        $user = $this->userServ->getUserById($request->id);
        if (!$user) { abort(404); }

        $data = $this->itemServ->itemSummery([
            'where' => [ 'is_active' => 1 , 'user_id' => $request->id, 'type_id' => 1] ,   // Auth::id()
            'paginate'=> 2
          ]);

        if ($request->ajax()) {
            return response()->json(array(
            'status' => 'success',
            'html' => view('components.front.items' , [ 'data' => $data ])->render(),
            'paginate' => view('components.front.paginate' , [ 'nextUrl' => $data->nextPageUrl() ])->render()
            )
          );
        };

        $images = $this->fileServ->getFilesOfUserItems($request->id,7)->all();

        $page = 'offers';

        return view('front.users.many-data' , compact(['data','user','images','page']));


    }

    public function getLikes(Request $request)
    {

        // if (! $this->checkCurrentAuth($request->id)) {
        //   return redirect(route('front.home'));
        // }
        $this->checkCurrentAuth($request->id);

        $user = $this->userServ->getUserById($request->id); // Auth::id()
        if (!$user) { abort(404); }

        $data = $this->itemServ->getUserItemsLikes($request->id); // Auth::id()

        if ($request->ajax()) {
            return response()->json(array(
            'status' => 'success',
            'html' => view('components.front.items' , [ 'data' => $data ])->render(),
            'paginate' => view('components.front.paginate' , [ 'nextUrl' => $data->nextPageUrl() ])->render()
            )
          );
        };


        $images = $this->fileServ->getFilesOfUserItems($request->id,7)->all();

        $page = 'likes';

        return view('front.users.many-data' , compact(['data','user','images','page']));

    }

    public function getComments(Request $request)
    {

        // if (! $this->checkCurrentAuth($request->id)) {
        //   return redirect(route('front.home'));
        // }
        $this->checkCurrentAuth($request->id);

        $user = $this->userServ->getUserById($request->id); // Auth::id()
        if (!$user) { abort(404); }

        $data = $this->itemServ->getUserItemsComments($request->id); // Auth::id()
        if ($request->ajax()) {
            return response()->json(array(
            'status' => 'success',
            'html' => view('components.front.items' , [ 'data' => $data ])->render(),
            'paginate' => view('components.front.paginate' , [ 'nextUrl' => $data->nextPageUrl() ])->render()
            )
          );
        };


        $images = $this->fileServ->getFilesOfUserItems($request->id,7)->all();

        $page = 'comments';

        return view('front.users.many-data' , compact(['data','user','images','page']));

    }

    public function getImages(Request $request)
    {

        $this->checkCurrentAuth($request->id);

        $user = $this->userServ->getUserById($request->id);
        if (!$user) { abort(404); }

        // $data = $this->itemServ->getUserItemsComments(Auth::id())->all();

        $images = $this->fileServ->getFilesOfUserItems($request->id,7)->all();

        $userImages = $this->fileServ->getFilesOfUserItems($request->id,6);
        if ($request->ajax()) {
            return response()->json(array(
            'status' => 'success',
            'html' => view('components.front.album' , [ 'userImages' => $userImages ])->render(),
            'paginate' => view('components.front.paginate' , [ 'nextUrl' => $userImages->nextPageUrl() ])->render()
            )
          );
        };


        $page = 'images';

        return view('front.users.many-data' , compact(['user','images','page','userImages']));

    }

    public function checkCurrentAuth($user_id)
    {

      $auth = false;
      if (Auth::id() == $user_id) {
        $auth = true;
      }

      View::share('auth',$auth);
      return $auth;

    }

    public function showRegistrationForm()
    {
        return view('front.users.register');
    }

    protected function store(ClientRequest $request)
    {

        $defaultLanguage = CommonHelper::getDefultLanguage()->locale;

        // check dublicate title
        $checkTitle = ClientInfo::where('title',$request->name)->where('language',$defaultLanguage)->exists();
        if ($checkTitle){
          return back()->withinput()->withErrors(['name' => __('messages.duplicate_title_language') ]);
        }

        // store
        $user = $this->userServ->store( array_merge(
              $request->validated() , ['role' => User::SITE_ROLE , 'type_id' => UserType::User()->first()->id , 'is_verified' => 0 ])
        );
        if (! $user) {
          return back()->withinput()->withErrors(['general' => __('auth.registration_faild') ]);
        }
        \App\Models\RoleUser::create(['user_id' => $user->id , 'role_id' => User::SITE_ROLE ]);


        $client = $this->clientServ->store( array_merge(
          $request->validated() , ['user_id' => $user->id])
        );
        if (! $client) {
          return back()->withinput()->withErrors(['general' => __('auth.registration_faild') ]);
        }

        $clientInfo = $this->clientServ->storeInfo( array_merge(
          $request->validated() , [ 'language' => $defaultLanguage , 'client_id' => $client->id , 'user_id' => $user->id ])
        );
        if (! $clientInfo) {
          return back()->withinput()->withErrors(['general' => __('auth.registration_faild') ]);
        }


        // createVerification
        $user->verification_code = $this->verificationServ->createVerification($user->id);

        // send SMS

        Auth::login($user);

        return $this->redirectTo($user->id);


    }

    public function showLoginForm()
    {
        return view('front.users.login');
    }

    public function login(Request $request)
    {

       $this->validate($request, [
          'phone' => 'required|numeric',
          'password' => 'required|string',
       ]);


       $user = User::where('phone', $request->phone)->first();
       if (! $user ) {
         return back()->withinput()->withErrors(['phone' => [trans('auth.wrong_phone')] ]);
       }

       if (! auth()->attempt(['phone' => $request->phone, 'password' => $request->password])) {
            return back()->withinput()->withErrors(['mobile' => [trans('auth.wrong_password')] ]);
        }

        if ($user->isVerified(1)) {
          return redirect(route('front.home'));
        }

        // createVerification
        $user->verification_code = $this->verificationServ->createVerification($user->id);

       // send SMS

       Auth::login($user);

       return $this->redirectToAfterLogin($user->id);


       // if ($user->isVerified(0)) {
       //   // createVerification
       //   $user->verification_code = $this->verificationServ->createVerification($user->id);
       //
       //   $response = [
       //       'code' => 4011,
       //       'errors' => [ 'User' => [trans('auth.not_verified') . trans('auth.please_verify')] ],
       //       'data' => $user->only('id','name','email','phone','type_id','image','verification_code','access_token','ip','created_at'),
       //   ];
       //   return $this->responseFaild($response,401);
       // }

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect()->route('front.home');
    }

    private function redirectTo($user_id)
    {
      return redirect(route('user.profile' , ['id' => $user_id] ));
    }

    private function redirectToAfterLogin($user_id)
    {
      return redirect(route('user.profile' , ['id' => $user_id] ));
    }

}
