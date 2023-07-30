<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RateRequest;
use App\Services\RateService;
use App\Traits\ApiResponse;
use App\Services\NotificationService;

class RateController extends Controller
{

    use ApiResponse;
    private $rateServ;
    private $notificationServ;

    public function __construct(RateService $rateService, NotificationService $notificationService)
    {
        $this->rateServ = $rateService;
        $this->notificationServ = $notificationService;

    }

    public function index()
    {

    }

    public function show($id)
    {

    }

    public function store(RateRequest $request)
    {

        // $rate = Rate::where([
        //   'user_id' => $request->validated()['user_id'] ,
        //   'table_id' => $request->validated()['table_id'] ,
        //   'table_name' => $request->validated()['table_name'] ,
        // ])->exists();
        //
        //
        // if ($rate) {
        //   $response = [ 'errors' => [ 'Rate' => [ trans('rate.dublicate_rate_same_user')] ] ];
        //   return $this->responseFaild($response,422);
        // }

        //$this->rateServ->storeFullRate( $request->validated()['table_name'] , $request->validated()['table_id'] );

        // // store comment
        // if ($request->comment){
        //   $this->rateServ->storeComment($request->validated());
        // }

        $this->rateServ->store($request->validated());
       
        $this->notificationServ->notifyRate(
            ['fcm', 'db'],
            ['order_id' => $request->order_id, 'user_id' => $request->user_id]
        );

        $response = [
            'message' => ['sucess' => [trans('messages.added')]],
        ];
        return $this->responseSuccess($response);

    }

}
