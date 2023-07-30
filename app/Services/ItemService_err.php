<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Helpers\UtilHelper;
use App\Helpers\CoreHelper;
use App\Services\CategoryService;
use App\Models\Item;
use App\Models\ItemInfo;
use App\Models\ItemCategory;
// use App\Traits\Cachement;
use Auth;

class ItemService_err
{
  // use Cachement;

    // return collection
    public function queryAll( $params = [] , $language = null)
    {
        $language = $language ?? app()->getLocale();

        $data = DB::Table('items')
          ->leftjoin("item_info",function($join) use ($language) // leftjoin because car and air don't have info
              { $join->on('items.id','=','item_info.item_id')->where('item_info.language', $language)->where('item_info.is_active','1'); })
          ->join('item_category','items.id','item_category.item_id')
          ->join('categories',function($join)
              { $join->on('categories.id','item_category.category_id')->where('categories.is_active','=',1); })
          ->join("category_info",function($join) use ($language)
              { $join->on('categories.id','=','category_info.category_id')->where('category_info.language', $language); })
          ->join("users",function($join)
              { $join->on('items.user_id','=','users.id')->where('users.is_active','1')->where('users.is_active_admin','1')->where('users.is_verified',1); })
          ->leftjoin("clients",function($join)
              { $join->on('clients.user_id','=','users.id')->where('clients.is_active','1')->where('clients.is_active_admin','1'); })
          ->leftjoin("client_info",function($join) use ($language)
              { $join->on('clients.id','=','client_info.client_id')->where('client_info.language', $language); })
          ->leftjoin("manufacturers",function($join)
              { $join->on('items.manufacturer_id','=','manufacturers.id')->where('manufacturers.is_active','1'); })
          ->leftjoin("offer_item",function($join)
              { $join->on('items.id','=','offer_item.item_id'); }) // ->where('offer_item.item_type','item'); })
          ->leftjoin("offers",function($join)
              { $join->on('offer_item.offer_id','=','offers.id')->where('offers.is_active','1'); })
          ->where('items.is_active_admin','=',1)
          ;

          // to join options
          $join_option = 0;
          $join_text = 0 ;
          foreach( $params as $key => $value)
          {
              if ( substr( $key, 0, 4 ) === "text" )
              {
                  if ( $value )
                  { $join_option=1; $join_text=1;}
              }
              if ( substr( $key, 0, 6 ) === "select" )
              {$join_option=1; }
              if ( substr( $key, 0, 5 ) === "check" )
              {$join_option=1;}
          }
          if ( $join_option != 0 )  // user select ( text,select,check )
          { $data->leftJoin('item_option_value_selector','item_option_value_selector.item_id', '=', 'items.id'); }

          if ( $join_text != 0 )  // ther is text search
          {
              $data->Join('option_values','option_values.id', '=', 'item_option_value_selector.option_value_id');
              $data->Join('option_value_info','option_value_info.option_value_id', '=', 'option_values.id');
          }


          // to join airs
          // foreach( $params as $key => $value)
          // {
          //   if ($key == 'type')
          //   {
          //     ->leftjoin('car_brands',function($join)
          //         { $join->on('car_brands.id','items.car_brand_id')->where('car_brands.is_active','=',1); })
          //     ->leftjoin("car_brand_info",function($join) use ($language)
          //         { $join->on('car_brands.id','=','car_brand_info.car_brand_id')->where('car_brand_info.language', $language); })
          //     ->leftjoin('car_types',function($join)
          //         { $join->on('car_types.id','items.car_type_id')->where('car_types.is_active','=',1); })
          //     ->leftjoin("car_type_info",function($join) use ($language)
          //         { $join->on('car_types.id','=','car_type_info.car_type_id')->where('car_type_info.language', $language); })
          //   }
          // }


          $ftxt=null;  // if params has ftext(full text search) then put value in this variable to reuse it in select statment
          $orderby=0; // flag to determine if user select any orderby or not
          foreach( $params as $key => $value)
          {
              if ($key == 'item_id')
              {
                  $data->where('items.id' , $value );
              }
              if ($key == 'ids')
              {
                  $data->whereIn('items.id' , array_values($value) );
              }
              if ($key == 'category')
              {
                  $data->whereIn('item_category.category_id' , array_values($value) );
              }
              if ($key == 'user')
              {
                  $data->where('users.id' , $value );
              }
              if ($key == 'type')
              {
                  $data->where('items.type_id' , $value );
              }
              if ($key == 'active')
              {
                  $data->where('items.is_active','=',$value);
              }
              if ($key == 'fav')
              {
                  $data->join('fav','items.id','fav.item_id')->where('fav.user_id',Auth::user()->id);
                  if ($value)
                  {$data->where('fav.parent_id',$value);}
              }
              if ( substr( $key, 0, 6 ) === "select" )
              {
                  $data->wherein('item_option_value_selector.option_value_id' , array_values($value) );
              }
               if ( substr( $key, 0, 4 ) === "text" )
               {
                   if ( $value )
                   {$data->where('option_value_info.title' , 'like' , '%'.$value.'%' );}
               }
               if ($key == 'ftxt')  // full Text Search
               {
                  $ftxt = $value;
                  $data->whereRaw("MATCH ({$value[0]}) AGAINST (? IN BOOLEAN MODE)", $value[1] ); //$value[0]: columns to search in , $value[1]: words to search
               }
               // --------------- end item


               if ($key == 'orderby')
               {
                   $orderby=1;
                   switch ($value)
                   {
                      case '1':  // for full text search
                         $data->orderBy('rel_score','desc');break;
                      case '2':  // Sort by Most Recent
                         $data->orderBy('items.id','desc');break;
                      case '3':  // Sort by Oldest
                         $data->orderBy('items.id','asc');break;
                     case '4':  // Sort by Most Viewed
                        $data->orderBy('items.viewed','desc'); //item_info.viewd
                        break;
                     case '5':  // Sort by price: low to high
                        $data->orderBy('items.price','asc');break;
                     case '6':  // Sort by price: high to low
                        $data->orderBy('items.price','desc');break;
                   }
               }
          }

          // default orderby
          if ($orderby==0) // if user didnt shose any order by make it default Sort by Most Recent
          {$data->orderBy('items.id','desc');}



          // $show for home , category page just liitel information about item
          if( $params['fields'] == 'select_default') {
              $data->select('category_info.title as category_title','category_info.alias as category_alias',
                  'item_info.item_id as item_id','item_info.id as item_info_id','item_info.title as item_title','item_info.description as item_description',
                  'item_info.alias as item_alias','items.price as item_price','item_info.image as item_image','items.viewed as item_viewed',
                  'users.name as user_name','users.lat','users.lng','client_info.title as client_title',
                  'offer_item.items_count','offers.perc_or_mount','offers.diccount','items.is_active');
          }

          // $show for full text search ddlist
          if( $params['fields'] == 'select_for_auto') {
              $data->selectRaw("item_info.title as value,item_info.alias as item_alias,
                  MATCH ({$ftxt[0]}) AGAINST (? IN BOOLEAN MODE) as rel_score", [$ftxt[1]]); // item_info.title as value to can access it via auto complete
          }

          // $show for full text search for search page (main search page)
          if( $params['fields'] == 'select_for_search') {
              $data->selectRaw("category_info.title as category_title,category_info.alias as category_alias,
                  item_info.item_id as item_id,item_info.id as item_info_id,item_info.title as item_title,item_info.description as item_description,
                  item_info.alias as item_alias,items.price as item_price,item_info.image as item_image,items.viewed as item_viewed,
                  users.name as user_name,users.lat,users.lng,client_info.title as client_title,
                  offer_item.items_count,offers.perc_or_mount,offers.diccount,users.id as user_id,
                  MATCH ({$ftxt[0]}) AGAINST (? IN BOOLEAN MODE) as rel_score", [$ftxt[1]]);
          }

          // $show for airs
          // if( $params['fields'] == 'select_airs') {
          //     $data->select('category_info.title as category_title','category_info.alias as category_alias',
          //         'item_info.item_id as item_id','item_info.id as item_info_id','item_info.title as item_title','item_info.description as item_description',
          //         'item_info.alias as item_alias','items.price as item_price','item_info.image as item_image','items.viewed as item_viewed',
          //         'users.name as user_name','users.lat','users.lng','client_info.title as client_title',
          //         'offer_item.items_count','offers.perc_or_mount','offers.diccount','items.is_active',
          //         'car_brand_info.title as car_brand','car_type_info.title as car_type','items.car_model');
          // }

          // $show for item page
          if( $params['fields'] == 'select_item') {

          }


          $pages = null ; // get not paginate
          if ( isset($params['pages']) ) {
            if ($params['pages'] === true){
              $pages = 2; // default for paginate
            } else {
              $pages = $params['pages'];
            }
          }


          //-------------------------
          if ($pages == null) {
            $data = $data->get();
          } else {
            $data = $data->paginate($pages);
          }
          // ????????->unique('item_info_id')
          // if item in tow categories so pagintae didnt work with ditincit so we have to use(uniqe heleper)
          // paginate($pg , ['item_info.id'] )  //distinct()
          //---------------------------


          // $currency=session()->get('currency');
          // foreach ($items as $item)
          // {
          //   if (isset($item->item_Price_Value))
          //   {
          //     $item_price=$item->item_Price_Value;
          //     if ($item->perc_or_mount)
          //     {
          //        if ($item->perc_or_mount == 2) // perc
          //           { $item_price = $item_price-$item_price*$item->diccount/100; }
          //        else
          //           { $item_price = $item_price-$item->diccount; }
          //     }
          //     $item->item_Price= $item_price / $currency['exchange'] ; // (number_format($item_price / $currency['exchange'], 2, '.', '.'));
          //   }
          // }

          return $data;



    }

    // return collection
    public function getAll($language = null)
    {
        return $this->queryAll(
            [ 'active' => 1 ,'fields' => 'select_default' , 'pages' => true ]
        );
    }

    public function getItems($language = null)
    {
        return $this->queryAll(
            [ 'type' => 1 ,'active' => 1 ,'fields' => 'select_default' , 'pages' => true ]
        );
    }

    public function getAir($language = null)
    {
      // if we need
    }

    public function getTransport($language = null)
    {
      // if we need
    }


    // return collection
    public function getItemById($id)
    {

        $item = Item::findOrFail($id);

        if ($item->type_id == 1){ // product

        }

        if ($item->type_id == 2){ // car
          $item->load(
            'carType.translation:car_type_id,title',
            'carBrand.translation:car_brand_id,title',
            'files:id,file_type_id,table_name,table_id,file_name,is_active'
          );
        }

        if ($item->type_id == 3){ // air
          $item->load(
            'countryFrom.translation',
            'countryTo.translation',
          );
        }

        return $item;

    }

    // return collection
    public function getItemsByUser($id,$language = null)
    {
        return $this->queryAll(
            [ 'user' => $id , 'fields' => 'select_default' , 'pages' => true ]
        );
    }

    // public function getItemsAirsByUser($id,$language = null)
    // {
    //     return $this->queryAll(
    //         [ 'user' => $id , 'type' => 3 ,'fields' => 'select_airs' , 'pages' => true ]
    //     );
    // }


    // return collection
    public function searchItems($request , $language = null)
    {

          $params = ['active' => 1 ,'pages' => true];

          $words = $request->words;
          if ($words) {
              $words = UtilHelper::prepareFullTextSearch($words);
              $params = $params + ['ftxt' => array('for_search',$words)] + ['fields' => 'select_for_search'];
          } else {
              $params = $params + ['fields' => 'select_default'];
          }



          $childrenIds = null;
          if ($request->category_id) {
              $categoryService = new CategoryService();
              $childrenIds = $categoryService->getChildrenIds($request->category_id);
              if ($childrenIds) {
                $params = $params + ['category' => explode(',', $childrenIds) ];
              }
          }

          return $this->queryAll($params);

    }

    public function storeTransport($request)
    {

        $item = new Item();
        $item->user_id = $request['user_id'];
        $item->type_id = 2; // car
        $item->title_general = 'car_' . CoreHelper::generateRandomString(7);
        $item->car_type_id = $request['car_type_id'];
        $item->car_brand_id = $request['car_brand_id'];
        $item->car_model = $request['car_model'];

        $item->is_active = 1;
        $item->ip = UtilHelper::getUserIp();
        $item->access_user_id = $request['user_id'];
        $item->save();

        if (! $item) {
          return false;
        }

        return $item;

    }

    public function updateTransport($item , $request)
    {

        $item->user_id = $request['user_id'];
        $item->type_id = 2; // car
        $item->title_general = 'car_' . CoreHelper::generateRandomString(7);
        $item->car_type_id = $request['car_type_id'];
        $item->car_brand_id = $request['car_brand_id'];
        $item->car_model = $request['car_model'];

        $item->is_active = 1;
        $item->ip = UtilHelper::getUserIp();
        $item->access_user_id = $request['user_id'];
        $item->save();

        if (! $item) {
          return false;
        }

        return $item;

    }

    public function storeAir($request)
    {

        $item = new Item();
        $item->user_id = $request['user_id'];
        $item->type_id = 3; // air flight
        $item->title_general = 'air_' . CoreHelper::generateRandomString(7);
        $item->from_country_id = $request['from_country_id'];
        $item->to_country_id = $request['to_country_id'];
        $item->_date = UtilHelper::DateToDb($request['_date']);
        $item->_time = UtilHelper::TimeToDb($request['_time']);
        $item->price = $request['price'];
        $item->package_count = $request['package_count'];

        $item->is_active = 1;
        $item->ip = UtilHelper::getUserIp();
        $item->access_user_id = $request['user_id'];
        $item->save();

        if (! $item) {
          return false;
        }

        return $item;

    }

    public function updateAir( $item , $request)
    {

        // $item->user_id = $request['user_id'];
        $item->type_id = 3; // air flight
        $item->title_general = 'air_' . CoreHelper::generateRandomString(7);
        $item->from_country_id = $request['from_country_id'];
        $item->to_country_id = $request['to_country_id'];
        $item->_date = UtilHelper::DateToDb($request['_date']);
        $item->_time = UtilHelper::TimeToDb($request['_time']);
        $item->price = $reque
    }
}
