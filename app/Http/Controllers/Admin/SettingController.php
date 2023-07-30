<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\ContactUsType;
use App\Models\Setting;
use App\Services\SettingService;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class SettingController extends AdminController
{
    use FileUpload;
    private $settingServ;

    public function __construct(SettingService $settingService)
    {

        $this->settingServ = $settingService;

        $this->share([
            'page' => Setting::PAGE,
            //'recordsCount' => Setting::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {

        $trans = app()->getLocale();
        if ($request->isMethod('post')) {
            $trans = $request->trans;
        }

        $msgTypes = ContactUsType::all();

        $settings = $this->settingServ->getAll($trans);

        return view('admin.settings.index', compact(['settings', 'trans', 'msgTypes']));

    }

    public function update(Request $request)
    {

        $validate = $request->validate([
            'language' => 'required|exists:languages,locale',
            'app_title' => 'required|max:100',
            'facebook' => 'nullable|max:500',
            'tweeter' => 'nullable|max:500',
            'instagram' => 'nullable|max:500',
            'snapchat' => 'nullable|max:500',
            'linkedin' => 'nullable|max:500',
            'website' => 'nullable|max:500',
            'phone_1' => 'nullable|max:100',
            'UPhone' => 'nullable|max:100',
            'CRMPhone' => 'nullable|max:100',
            'customer_service' => 'nullable|max:100',
            'mail' => 'nullable|email|max:300',
            'address' => 'nullable|max:500',
            'app_android_lnk' => 'nullable|max:500',
            'app_ios_link' => 'nullable|max:500',
            'app_share_note' => 'nullable|max:500',
            'work_times' => 'nullable|max:500',
            'logo' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
            'register_st_1' => 'nullable|max:200',
            'register_st_2' => 'nullable|max:200',
            'register_st_3' => 'nullable|max:200',
            'about_us' => 'nullable',
            'about_us_image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
            'terms' => 'nullable|string',
            'privacy' => 'nullable',
            'lat' => 'nullable',
            'lng' => 'nullable',

        ]);

        $update = $this->settingServ->update($request);
        if ($update !== true) {
            return back()->withinput()->withErrors(['general' => $update]);
        }

        // // upload image
        if ($request->hasFile('logo')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'logo',
                'folder' => Setting::FILE_FOLDER,
                'recordId' => 'logo',
            ]);

            Setting::find(1)->Update(['logo' => $path]);
        }

        // upload about us image
        if ($request->hasFile('about_us_image')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'about_us_image',
                'folder' => Setting::FILE_FOLDER,
                'recordId' => 'about_us_image',
            ]);
            Setting::find(1)->Update(['about_us_image' => $path]);
        }

        $this->flashAlert([
            'success' => ['msg' => __('messages.updated')],
        ]);

        return back();

    }

    public function addMsgType(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:250|unique:contact_us_types',
        ]);
        // $errors = $validator->errors();

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $msgType = new \App\Models\ContactUsType();
        $msgType->title = $request->title;
        $msgType->save();

        return back();

    }

    public function updateMsgType(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:250|unique:contact_us_types,title,' . $id,
        ]);
        // $errors = $validator->errors();

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        \App\Models\ContactUsType::where('id', $request->id)->update(['title' => $request->title]);
        return back()->with('alert_msgtype', 'تم التعديل');

    }

    public function delete(Request $request)
    {
        try {
            DB::Table($request->table)->whereIn('ids', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed']);
        }
        return response()->json(['message' => 'Success']);
    }

}


// $t = ['ar'=>'بيانات باللغة العربية' , 'en' => 'English Data'];
// Setting::where('property','test')->update(['value' => UtilHelper::encodeData($t) ]);

// $t = [ 'ar' => [
//       'condition1'=>'شروط 1 عربى' ,
//       'condition2' => 'شروط 2 عربى',
//       'condition3' => 'شروط 3 عربى',
//     ],
//     'en' => [
//          'condition1'=>'condition 1 english' ,
//          'condition2' => 'condition 2 english',
//          'condition3' => 'condition 3 english',
//        ]
//   ];
//   Setting::where('property','agree_conditions')->update(['value' => UtilHelper::encodeData($t) ]);
