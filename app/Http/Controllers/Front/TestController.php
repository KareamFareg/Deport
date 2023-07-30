<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TestService;
use Auth;


class TestController extends Controller
{
  private $testServ;

  public function __construct( TestService $testService  )
  {

     $this->testServ = $testService;

  }

  public function test(Request $request)
  {

    // if (!$request->title){
    //   throw ValidationException::withMessages(['field_name' => 'This value is incorrect']);
    // }

    // return route()
        // $request->merge([ 'comment' => UtilHelper::formatNormal($request->comment) ]);
        //
        // $validator = Validator::make($request->all(), [
        //     'comment' => 'required|max:200',
        //     'parent_id' => 'required|numeric|min:0',
        //     'table_name' => ['required','string','max:30',Rule::in(['items']) ],
        //     'table_id' => 'required|integer',
        // ]);

  }

}
