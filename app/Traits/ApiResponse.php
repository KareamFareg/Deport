<?php

namespace App\Traits;

trait ApiResponse
{
  public function responseFaild( $response = [] , $status = 400 )
  {
    $response = ['status' => 'faild'] + $response ;

    ! isset($response['code']) ? $response = ['code'=> $status] + $response : '';

    // to extract error statment from array
    if (isset($response['errors'])) {
      $errors = $response['errors'];
      $response['message'] = '';
        foreach ($errors as $error) {
          if (is_array($error)) { // for laravel validation
            $response['message'] = $error[0] . ',' . $response['message'];
          } else {
            $response['message'] = $error . ',' . $response['message'];
          }
        }
        unset($response['errors']);
    }

    return response()->json($response);
  }


  public function responseSuccess( $response = [] , $status = 200 )
  {
    if (isset($response['message'])) {
        $messages = $response['message'];
        $newMessage='';
        foreach ( $messages as $message ) {
          if (is_array($message)) {
            $newMessage = $message[0]. ',' . $newMessage;
          } else {
            $newMessage = $message . ',' . $newMessage;
          }
        }
        unset($response['message']);
        $response = ['message'=> $newMessage] + $response;
    }

    $response = ['status' => 'success'] + $response;
    ! isset($response['code']) ? $response = ['code'=> $status] + $response : '';

    return response()->json($response);
  }

  public function responseSuccessPages( $response =[] , $data , $status = 206 )
  {

    $response = ['status' => 'success'] + $response;

    ! isset($response['code']) ? $response = ['code'=> $status] + $response : '';

    $paginate = [
      'total' => $data->total(),
      'lastPage' => $data->lastPage(),
      'currentPage' => $data->currentPage(),
      'nextPageUrl' => $data->nextPageUrl(),
      'previousPageUrl' => $data->previousPageUrl(),
    ];

    $response = $response + [ 'paginate' => $paginate ] ;

    return response()->json($response);

  }

  public function responseDone( $response = [] , $status = 200 )
  {
    $response = ['status' => 'Done'] + $response;
    ! isset($response['code']) ? $response = ['code'=> $status] + $response : '';
    return response()->json($response);
  }

}



// $response = [
// 		'status' => 'sucess',
// 		'message' => [
// 				'success' => ['message'=>'Welcome Back']
// 		],
// 		'errors' => [
// 				'email' => ['message'=>'Error Email']  // must detrmine which field has error to can catch it there
// 		],
// 		'code' => '',
// 		'Data' => [],
// 		'pagination' => [
// 				'Pagination-Count' => 100
// 				'Pagination-Page' => 5
// 				'Pagination-Limit' => 20
// 			],
// 	];
//
//
//
// validation
// "errors": {
// 		"phone": [ "The phone field is required."	]
// },
