<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\UserCategory;
use App\Http\Requests\UserCategoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\ApiResponse;
use App\Services\UserCategoryService;

class UserCategoryController extends Controller
{
  use ApiResponse;
  private $userCategoryServ;

  public function __construct(UserCategoryService $userCategoryService)
  {
      $this->userCategoryServ = $userCategoryService;
  }


  public function storeMany(UserCategoryRequest $request , $id)
  {

      // if no items in items array
      if ( empty($request['categories']) ) {
        $response = [
            'errors' => [ 'order_items' => [trans('user_category.no_categories')] ],
        ];
        return $this->responseFaild($response,401);
      }

      User::findOrFail($id);

      $this->userCategoryServ->storeMany($request->validated() , $id);

      $response = [
           'message' => [ 'sucess' => [trans('messages.updated')] ],
      ];
      return $this->responseSuccess($response,201);

  }

  public function store(Request $request)
  {
      $exists = UserCategory::where([ 'user_id' => $request->user_id , 'category_id' => $request->category_id ])->exists();
      if ($exists) {
        $response = [
            'errors' => [ 'UserCategory' => [ trans('messages.already_exists',['var'=>'']) ] ],
        ];
        return $this->responseFaild($response,422);
      }

      UserCategory::create($request->all());

      $response = [
           'message' => [ 'sucess' => [trans('messages.added')] ],
      ];
      return $this->responseSuccess($response,201);

  }


  public function setStoreDestroy(Request $request)
  {
      $userCategory = UserCategory::where([ 'user_id' => $request->user_id , 'category_id' => $request->category_id ])->first();

      if ($userCategory) {
        $userCategory->delete();
        $response = [
             'message' => [ 'sucess' => [trans('messages.deleted')] ],
        ];
        return $this->responseSuccess($response);
      }


      UserCategory::create($request->all());
      $response = [
           'message' => [ 'sucess' => [trans('messages.added')] ],
      ];
      return $this->responseSuccess($response);


  }

  public function update(Request $request, $id)
  {
      // update
  }

  public function destroy($id)
  {

      UserCategory::where('id' , $id )->delete();
      $response = [
           'message' => [ 'sucess' => [trans('messages.added')] ],
      ];
      return $this->responseSuccess($response,204);

  }

}
