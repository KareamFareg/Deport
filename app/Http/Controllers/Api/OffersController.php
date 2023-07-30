<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\OfferDetails;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Product;
use App\Services\CategoryService;

class OffersController extends Controller
{


    private $categoryServ;

    
    use ApiResponse;

    
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryServ = $categoryService;

    }

    public function index()
    {

        $offers = Offer::orderBy('id', 'desc')->get();
        $language = $language ?? app()->getLocale();

        if ($offers->isEmpty()) {
            throw new ModelNotFoundException;
        }

        $data = [];
        foreach ($offers as $offer) {
            $offerData['id'] = $offer['id'];
            $offerData['title'] = $offer->title($language);
            $offerData['logo'] = $offer->logo;
            $offerData['image'] = $offer['images'][0] ?? '';

            $data[] = $offerData;
        }

        return $this->responseSuccess([
            'data' => $data,
        ]);
    }

    public function details($id)
    {

        $language = $language ?? app()->getLocale();
      
        $offer = Offer::find($id);
        if (!$offer) {
            throw new ModelNotFoundException;

        }

        $data = [];

        $data['id'] = $offer['id'];
        $data['title'] = $offer->title($language);
        $data['images'] = $offer['images'];
        $data['logo'] = $offer->logo;
        $data['categories'] = $this->categoryServ->getCategoryByIds(Product::where('offer_id',$id)->get()->pluck('category_id'));
        $data['details'] = Product::where('offer_id',$id)->get();

        // $offerDetails = OfferDetails::where('offer_id', $id)->get();

        // foreach ($offerDetails as $offer) {
        //     $offerData['id'] = $offer['id'];
        //     $offerData['title'] = $offer->title($language);
        //     $offerData['description'] = $offer->description($language);
        //     $offerData['images'] = $offer['images'];
        //     $offerData['logo'] = $offer['logo'];
        //     $offerData['lat'] = $offer['lat'];
        //     $offerData['lng'] = $offer['lng'];

        //     $data['details'][] = $offerData;
        // }

        return $this->responseSuccess([
            'data' => $data,
        ]);

    } 
    
    public function details_by_category($id,$category_id)
    {

        $language = $language ?? app()->getLocale();
      
        $offer = Offer::find($id);
        if (!$offer) {
            throw new ModelNotFoundException;

        }

        $data = [];

        $data['id'] = $offer['id'];
        $data['title'] = $offer->title($language);
        $data['images'] = $offer['images'];
        $data['logo'] = $offer->logo;
        $data['details'] = Product::where(['offer_id'=>$id,'category_id'=>$category_id])->get();

        // $offerDetails = OfferDetails::where('offer_id', $id)->get();

        // foreach ($offerDetails as $offer) {
        //     $offerData['id'] = $offer['id'];
        //     $offerData['title'] = $offer->title($language);
        //     $offerData['description'] = $offer->description($language);
        //     $offerData['images'] = $offer['images'];
        //     $offerData['logo'] = $offer['logo'];
        //     $offerData['lat'] = $offer['lat'];
        //     $offerData['lng'] = $offer['lng'];

        //     $data['details'][] = $offerData;
        // }

        return $this->responseSuccess([
            'data' => $data,
        ]);

    }
}
