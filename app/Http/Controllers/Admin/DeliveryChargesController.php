<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\DeliveryCharge;
use App\Services\CategoryService;

use App\Helpers\UtilHelper;
use Auth;

class DeliveryChargesController extends AdminController
{
  private $categoryServ;

  public function __construct(CategoryService $categoryService)
  {

      $this->categoryServ = $categoryService;

      $this->share([
        'page' => DeliveryCharge::PAGE,
        'recordsCount' => DeliveryCharge::count(),
      ]);

      $this->defaultLanguage = $this->defaultLanguage();

  }

    public function index(Request $request)
    {

        $language = $this->defaultLanguage;
        $categories = $this->categoryServ->getAll();
        $temp = [];
        $categories = UtilHelper::buildTreeRoot( $categories, null, $temp, 1, 0 );

        $data = DeliveryCharge::with(['category.category_info' => function($query) use($language) {
          $query->where('language',$language->locale);
        } ]);


        if ($request->category_id) {
          $data->where('category_id',$request->category_id);
        }

        // if ($request->active_status === "0" || $request->active_status === "1" ) {
        //   $data->where('is_active',$request->active_status);
        // };

        $data = $data->get();
                // dd($data);
        $request->flash();

        return view('admin.delivery_charges.index',compact(['categories','data']));


    }

    public function create()
    {

      $deliveryCharges = DeliveryCharge::with('category')->get();

      $categories = $this->categoryServ->getAll();
      $temp = [];
      $categories = UtilHelper::buildTreeRoot( $categories, null, $temp, 0, 0 );

      return view('admin.delivery_charges.create',compact(['deliveryCharges','categories']));

    }

    public function store(Request $request)
    {

      $validate = $request->validate([
          'category_id' => 'required|integer|exists:categories,id',
          'd_from' => 'required|numeric',
          'd_to' => 'required|numeric',
          'charge' => 'required|numeric',
      ]);


      $checkFromTo = $this->validateFromTo( $request->category_id, $request->d_from, $request->d_to );
      if ($checkFromTo !== true) {
        return back()->withinput()->withErrors(['from' => $checkFromTo ]);
      }


      DeliveryCharge::create(
        array_merge( $request->all(),
            ['ip' => UtilHelper::getUserIp() , 'access_user_id' => Auth::id() ]
        )
      );

      return redirect(route('admin.deliverycharges.index'));


    }

    public function edit(Request $request)
    {

        $data = DeliveryCharge::findOrFail($request->id);

        $deliveryCharges = DeliveryCharge::with('category')->get();

        $categories = $this->categoryServ->getAll();
        $temp = [];
        $categories = UtilHelper::buildTreeRoot( $categories, null, $temp, 0, 0 );

        return view('admin.delivery_charges.edit',compact(['deliveryCharges','categories','data']));


    }

    public function update(Request $request)
    {

      $deliveryCharge = DeliveryCharge::findOrFail($request->id);

      $validate = $request->validate([
          'category_id' => 'required|integer|exists:categories,id',
          'd_from' => 'required|numeric',
          'd_to' => 'required|numeric',
          'charge' => 'required|numeric',
      ]);


      $checkFromTo = $this->validateFromTo( $request->category_id, $request->d_from, $request->d_to , $deliveryCharge->id);
      if ($checkFromTo !== true) {
        return back()->withinput()->withErrors(['from' => $checkFromTo ]);
      }


      $deliveryCharge->update(
        array_merge( $request->all(),
            ['ip' => UtilHelper::getUserIp() , 'access_user_id' => Auth::id() ]
        )
      );

      return redirect(route('admin.deliverycharges.index'));

    }

    public function validateFromTo( $categoryId , $from , $to , $currentId = null )
    {

        if ($from >= $to) {
          return __('delivery_charge.from_gt_to') ;
        }

        $chk2 = DeliveryCharge::where('category_id',$categoryId)
          ->where('d_from',$from)
          ->where('d_to',$to)
          ->when($currentId, function ($query,$currentId) {
              return $query->where('id', '!=', $currentId);
          })->exists();

        if ($chk2) {
          return __('delivery_charge.from_to_dublicate');
        }


        return true;

    }


}
