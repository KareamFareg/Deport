<?php

namespace App\Services;

use App\Models\Rate;
use App\User;

class RateService
{

    public function store($request)
    {
        Rate::Create($request);

        $rateSum = Rate::where('user_id', $request['user_id'])->sum('rate');
        $rateCount = Rate::where('user_id', $request['user_id'])->count();
        $rate = $rateSum / $rateCount;

        User::where('id', $request['user_id'])->update(['rate' => $rate,'rate_count' => $rateCount]);

    }

    // public function storeFullRate($tableName, $tableId)
    // {
    //     $rate = $this->calcRate($tableName, $tableId);

    //     \App\User::where('id', $tableId)->Update(['rate' => $rate->rate, 'rate_count' => $rate->rate_count]);
    // }

//   public function calcRate($tableName , $tableId)
    //   {

//     $rate = DB::Table('rates')->where('table_name',$tableName)->where('table_id',$tableId)->select('rate')->get();

//     $itemRatesCount = count($rate);
    //     $fullStars =  $itemRatesCount * 5;
    //     $itemStars = $rate->sum('rate');

//     $rates = $rate->groupBy('rate');

//     $rates = $rates->map(function ($item, $key) use ($fullStars) {
    //         if ($fullStars == 0) {
    //           $perc = 0;
    //         } else {
    //           $count = collect($item)->count();
    //           $perc = ( ($key * $count) * ($key / 5) ) / $fullStars ;
    //         }
    //         return ['reviews' => $count , 'perc' =>  round( ( $perc ) * 100 , 1) ];
    //     });

//     $defaultStars = collect([
    //          '5'=>['reviews'=>0,'perc'=>0],
    //          '4'=>['reviews'=>0,'perc'=>0],
    //          '3'=>['reviews'=>0,'perc'=>0],
    //          '2'=>['reviews'=>0,'perc'=>0],
    //          '1'=>['reviews'=>0,'perc'=>0],
    //      ]);

//      $rates = $rates->union($defaultStars)->sortKeysDesc();

//      $rates->rate_count = $itemRatesCount;

//      $rates->rate  = ($fullStars > 0) ?  round (( $itemStars / $fullStars ) * 5 , 2) : 0;

//      return $rates;

//   }

//   public function storeComment($request)
    //   {
    //     Comment::Create($request + [ 'ip' => UtilHelper::getUserIp() ]);
    //   }

}
