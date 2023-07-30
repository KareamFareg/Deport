<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Traits\ApiResponse;

class FaqController extends Controller
{

    use ApiResponse;

    public function index()
    {
        $locale = app()->getLocale();



        $faqs = Faq::select('id',"question", "answer")->get();
        $data = [];
        foreach ($faqs as $key => $value) {
            if(!isset ($value->question[$locale]) ){
                continue;
            }
            
            $faq['id'] = $value->id;
            $faq['question'] = $value->question[$locale] ;
            $faq['answer'] = $value->answer[$locale];
            $data[] = $faq;
        }

        return $this->responseSuccess([
            'data' => $data,
        ]);

    }

}
