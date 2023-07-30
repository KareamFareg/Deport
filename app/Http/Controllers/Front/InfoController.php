<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\SettingService;
use App\Mail;
use App\Models\ContactUs;
use App\Helpers\UtilHelper;

class InfoController extends Controller
{
  private $settingServ;

  public function __construct(SettingService $settingService)
  {
      $this->settingServ = $settingService;

      // $this->share([
      //   'page' => Item::PAGE,
      // ]);

      // $this->defaultLanguage = $this->defaultLanguage();

  }

    public function contactUs(Request $reques)
    {
        $data = '';
        $msg_types = DB::Table('msg_types')->get();
        $info = $this->settingServ->getSettingByProperties(['phone_1','mail']);
        return view('front.info.contact',[ 'data' => $data ,'msg_types' => $msg_types,'info' => $info ,'currentItem'=>trans('front.contactus')]);
    }

    public function contactUsPost(Request $request)
    {

        // $this->validate(request(),[
        //     'name'=>'required|max:100|string',
        //     'phone'=>'nullable|numeric|digits:10',
        //     'email'=>'required|max:100|email',
        //     'msg_type_id'=>'required|integer|exists:msg_types,id',
        //     'msg_body'=>'required|max:4000|string',
        //     'subject' => 'required|max:100|string',
        //   ],[],['subject'=> 'عنوان الرساله']);




          $validate = $request->validate([
              'title' => 'required|string|max:100',
              'mobile' => 'nullable|numeric|digits:10',
              'email'=>'required|max:100|email',
              'contact_us_type_id' => 'required|exists:contact_us_types,id',
              'description' => 'required|max:2000',
              'user_id' => 'nullable|integer|exists:users,id',
          ]);

          if ($request->type_info) {
            $this->flashAlert([
              'success' => ['msg'=> __('messages.added')]
            ]);
            return redirect(route('front.info.contactus'));
          }

         ContactUs::create( array_merge(
            $request->all() , [ 'ip' => UtilHelper::getUserIp() ] )
          );

          // $mail = new \App\Models\Mail;
          // $mail->name=$request->name;
          // $mail->phone=$request->phone;
          // $mail->msg_type_id=$request->msg_type_id;
          // $mail->description=$request->msg_body;
          // $mail->email=$request->email;
          // $mail->subject=$request->msg_title;
          // $mail->save();


          $this->flashAlert([
            'success' => ['msg'=> __('messages.added')]
          ]);
          return redirect(route('front.info.contactus'));

    }

    public function qa(Request $request)
    {

      $qa_search = '';
      if ($request->has('qa_search')) {
        $data = DB::Table('faqs')->where('answer' , 'like' , '%'.$request->qa_search.'%' )->get();
        $qa_search = $request->qa_search;
      } else {
        $data = DB::Table('faqs')->get();
      }

      return view('front.info.faqs',[ 'data' => $data ,'currentItem'=>trans('front.qa') , 'qa_search'=> $request->qa_search]);
    }

    public function customerService()
    {
        // $data = DB::Table('settings')->select('customer_service')->first();
        $info = $this->settingServ->getSettingByProperty('customer_service');
        return view('front.info.index_master',[ 'info' => $info ,'currentItem'=>trans('words.customer_service')]);
    }

    public function aboutUs()
    {
      $info = $this->settingServ->getSettingByProperty('about_us');
      $infoImage = $this->settingServ->getSettingByProperty('aboutus_image');
      return view('front.info.index_master',[ 'info' => $info ,'infoImage' => $infoImage ,'currentItem'=>trans('words.about_us')]);
    }

    public function terms()
    {
      $info = $this->settingServ->getSettingByProperty('terms');
      return view('front.info.index_master',[ 'info' => $info ,'currentItem'=>trans('words.terms')]);
    }

    public function policy()
    {
      $info = $this->settingServ->getSettingByProperty('privacy');
      return view('front.info.index_master',[ 'info' => $info ,'currentItem'=>trans('words.privacy_policy')]);
    }


}
