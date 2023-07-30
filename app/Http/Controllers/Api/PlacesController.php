<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceRequest;
use App\Models\Place;
use App\Traits\ApiResponse;

class PlacesController extends Controller
{

    use ApiResponse;

    public function add(PlaceRequest $request)
    {

      //  var_dump($request->validated());
        place::create($request->validated());
        $response = [
            'message' => ['sucess' => [trans('messages.added')]],
        ];
        return $this->responseSuccess($response);

    }

    public function edit(PlaceRequest $request)
    {

        $place = place::find($request->id);
        if ($place->update($request->validated())) {
            $response = [
                'message' => ['sucess' => [trans('messages.updated')]],
            ];
            return $this->responseSuccess($response);
        } else {
            $response = [
                'message' => ['error' => [trans('messages.updated_faild')]],
            ];
            return $this->responseFaild($response);
        }
    }

    public function all($id)
    {
        $places = place::where('user_id', $id)->get()->toArray();
        $response = [
            'data' => $places,
        ];

        return $this->responseSuccess($response);

    }

    public function delete(PlaceRequest $request)
    {

        if(Place::where('id', $request->id)->delete()){

            $response = [
                'message' => ['sucess' => [trans('messages.deleted')]],
            ];
            return $this->responseSuccess($response);
        }else {
            $response = [
                'message' => ['error' => [trans('messages.deleted_faild')]],
            ];
            return $this->responseFaild($response);
        }


    }
}
