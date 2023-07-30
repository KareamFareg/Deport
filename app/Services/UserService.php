<?php

namespace App\Services;

use App\Helpers\CoreHelper;
use App\Helpers\UtilHelper;
use App\Models\ClientInfo;
use App\Models\Notification;
use App\Models\ULike;
use App\Traits\FileUpload;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;
use App\Traits\GeneralTrait;
class UserService
{
    use GeneralTrait,FileUpload, ApiResponse;

    public function queryAll($params = [], $language = null)
    {

    }

    public function getUserById($id, $language = null)
    {

        $language = $language ?? app()->getLocale();

        // $user = User::with(['client.client_info' => function ($query) use ($language) {
        //   $query->where('language',$language);
        // }])->where('id',$id)->first();

        $user = User::where('id', $id)->first();

        if ($user) {
            $user->unseen_notifications_count = Notification::where(['user_reciever_id' => $user->id, 'read_at' => null])->count();
            //$user->likes_count = ULike::where( 'user_id' , $user->id )->count();
        }

        return $user;

    }

    public function storeBanner($fileUpload, $user_id)
    {

        $language = app()->getLocale();

        $extension = $fileUpload->getClientOriginalExtension();
        $name = $user_id . '_banner_' . uniqid() . '.' . $extension;
        $fileUpload->move('storage/app/' . User::FILE_FOLDER, $name);

        return User::FILE_FOLDER . '/' . $name;

    }
    
//store user  image
    public function storeImage($fileUpload, $user_id)
    {

        $language = app()->getLocale();

        $extension = $fileUpload->getClientOriginalExtension();
        $name = $user_id . '_image_' . uniqid() . '.' . $extension;
        $fileUpload->move('storage/app/' . User::FILE_FOLDER, $name);

        return User::FILE_FOLDER . '/' . $name;

    }

    public function validateStoreBanner($fileUpload)
    {

        if (!in_array($fileUpload->getClientOriginalExtension(), ['jpeg', 'png', 'gif', 'jpg', 'svg'])) {
            return 'error extintion';
        }

        if (($fileUpload->getSize() / 1000) > 500) {
            return 'حجم الصورة لا يزيد عن 500';
        }

        return true;

    }
// active pr   disactive user
    public function setActive($user, $status)
    {
        if($user->update(['is_active' => $status])){
            return true;
        }else{
            return false;
        }
        
    }

    public function createRandomPassword($user)
    {

        $randPassword = CoreHelper::generateRandomString(8);
        $user->update(['password' => Hash::make($randPassword)]);

        return $randPassword;

    }

    public function updateFcm($user, $request)
    {
        return $user->update(['fcm_token' => $request->fcm_token, 'mobile_type' => $request->mobile_type]);
    }
    
    // update User Data (or complete registiration) and enable normal user to  be driver throw  adding some important data like [his image , id card , his Lisence]

    public function update($request, $user)
    {
        if(isset($request['image'])){
            $path = $this->storeFile([], [
                'fileUpload' => $request['image'],
                'folder' => User::FILE_FOLDER,
                'recordId' => $user->id . '_image',
            ]);

            $user->image = $path;
        }

        if(isset($request['id_card'])){
            $path = $this->storeFile([], [
                'fileUpload' => $request['id_card'],
                'folder' => User::FILE_FOLDER,
                'recordId' => $user->id . '_image',
            ]);

            $user->id_card = $path;
        }

        if(isset($request['license'])){
            $path = $this->storeFile([], [
                'fileUpload' => $request['license'],
                'folder' => User::FILE_FOLDER,
                'recordId' => $user->id . '_image',
            ]);

            $user->license = $path;
        }

        $user->name = $request['name'];
        
        if (isset($request['password'])) {$user->password = Hash::make($request['password']);}
        if (isset($request['phone'])) {$user->phone = $request['phone'];}
        if (isset($request['gender'])) {$user->gender = $request['gender'];}
        if (isset($request['lat'])) {$user->lat = $request['lat'];}
        if (isset($request['lng'])) {$user->lng = $request['lng'];}
        if (isset($request['id_number'])) {$user->id_number = $request['id_number'];}
        if (isset($request['city'])) {$user->city = $request['city'];}
        if (isset($request['area'])) {$user->area = $request['area'];}
        if (isset($request['access_user_id'])) {
            $user->access_user_id = $request['access_user_id'];
        } else {
            $user->access_user_id = $user->id;
        }
        $user->ip = UtilHelper::getUserIp();
        $user->save();

        return $user;

    }

// create new user 
    public function store($request)
    {

        $user = new User();
        $user->type_id = $request['type_id'];
        //$user->role = $request['role'];

        if (isset($request['name'])) {$user->email = $request['name'];}
        if (isset($request['email'])) {$user->email = $request['email'];}
        $user->phone = $request['phone']; // $request['phone'];
        if (isset($request['gender'])) {$user->gender = $request['gender'];}
        if (isset($request['image'])) {$user->image = $request['image'];}
        $user->password = Hash::make($request['password']);
        $user->is_verified = $request['is_verified'];
        $user->lang = app()->getLocale();
        $user->ip = UtilHelper::getUserIp();
        $user->save();

        if (!$user) {
            return false;
        }

        $user->access_user_id = $user->id;
        $user->save();

        return $user;

    }

//check for user validaty
    public function isUserValid($user)
    {

        if ($user->isActive(0)) {
            return ['error' => trans('auth.in_active'), 'code' => 401];
        }

        if ($user->isActiveAdmin(0)) {
            return ['error' => trans('auth.in_active'), 'code' => 401];
        }

        if ($user->isVerified(0)) {
            return ['error' => trans('auth.not_verified'), 'code' => 4011];
        }

        return [];

    }

    public function validateClientNameLanguage($name, $locale, $id = null)
    {
        if ($id == null) {
            return ClientInfo::where('title', $name)->where('language', $locale)->exists();
        } else {
            return ClientInfo::where('title', $name)->where('language', $locale)->where('id', '!=', $id)->exists();
        }

    }

    public function getCountActiveAdmins()
    {
        // used when deactivate any user if this user is last one admin so don't deactivaet it
        return User::with('roles')->wherehas('roles', function ($query) {
            return $query->where('role_id', 1);
        })->count();
    }

    public function getUserLikesCount($user_id)
    {
        return ULike::where('user_id', $user_id)->count();
    }
 public function getUserOrdersAll()
{
    # code...
}
}
