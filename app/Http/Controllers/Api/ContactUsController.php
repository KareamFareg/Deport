<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ContactUs;
use App\Helpers\CommonHelper;
use App\Helpers\UtilHelper;
use App\Traits\ApiResponse;
use App\Services\NotificationService;


class ContactUsController extends Controller
{

  use ApiResponse;


  private $notificationServ;

  public function __construct(NotificationService $notificationService)
  {
      $this->notificationServ = $notificationService;
  }

  public function index()
  {
    // $data = CarType::with('translation:id,car_type_id,title')->select('id','is_active')->get();
    // foreach ($data as $value) {
    //   if (! $value->translation->isEmpty()) {
    //     $value->title = $value->translation->first()->title;
    //   }
    // }
    //
    //   return $this->responseSuccess([
    //     'data' =>  $data
    //   ]);
  }

  public function getContactUsTypes()
  {

    return $this->responseSuccess([
        'data' =>  CommonHelper::getContactUsTypes()
      ]);
  }

  public function store(Request $request)
  {

    $this->notificationServ->notifyAdminContactUs(
      ['fcm', 'db'],
      ['user_id' => $request->user_id]
  );


    $validate = $request->validate([
        'title' => 'required|string|max:100',
        'mobile' => 'required|max:100',
        'contact_us_type_id' => 'required|exists:contact_us_types,id',
        'description' => 'required|max:2000',
        'user_id' => 'nullable|integer|exists:users,id',
    ]);

   ContactUs::create( array_merge(
      $request->all() , [ 'ip' => UtilHelper::getUserIp() ] )
    );

    $response = [
         'message' => [ 'sucess' => [trans('contact_us.sent_success')] ],
    ];
    return $this->responseSuccess($response);

  }


}
