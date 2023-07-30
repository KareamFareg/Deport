<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommissionTranaction;
use App\Traits\ApiResponse;
use App\Traits\FileUpload;

class CommissionController extends Controller
{

    use ApiResponse;
    use FileUpload;

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric|exists:users,id',
        ]);

     

        $transaction =CommissionTranaction::create($request->all());

        if(isset($request['image'])){
            $path = $this->storeFile([], [
                'fileUpload' => $request['image'],
                'folder' => CommissionTranaction::FILE_FOLDER,
                'recordId' => $transaction->id . '_image',
            ]);

            $transaction->image = $path;
            $transaction->save();
        }

        if($transaction){
            $response = ['message' => ['sucess' => trans('messages.added')]];
            return $this->responseSuccess($response);


        }else{
            $response = ['message' => ['sucess' => trans('messages.added_faild')]];
            return $this->responseFaild($response);


        }
    }
}
