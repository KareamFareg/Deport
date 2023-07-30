<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\HowToUse;
use App\Models\Slider;
use App\Services\CountryService;
use App\Services\SettingService;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\BankAccount;

class SettingController extends Controller
{
    use ApiResponse;
    private $settingServ;
    private $countryServ;

    public function __construct(SettingService $settingService, CountryService $countryService)
    {
        $this->settingServ = $settingService;
        $this->countryServ = $countryService;

    }

    public function index()
    {
        $data = $this->settingServ->getAll();
        // $newData = [];
        // foreach ($data as $key => $value) {
        //     $newData = $newData + [$value->property => $value->value];
        // }

        return $this->responseSuccess([
            'data' => $data,
        ]);
    }

    public function show($property)
    {
        $data = $this->settingServ->getSettingByProperty($property);
        if (!$data) {
            throw new ModelNotFoundException;
        }

        $newData = [$property => $data];

        return $this->responseSuccess([
            'data' => $newData,
        ]);

    }

    public function contacts()
    {

        $data = $this->settingServ->getSettingContacts();
        if (!$data) {
            throw new ModelNotFoundException;
        }

        return $this->responseSuccess([
            'data' => $data,
        ]);

    }

    public function areas($id)
    {

        $locale = app()->getLocale();

        $countries = Country::where('parent_id', $id)->get();
        $data = [];
        foreach ($countries as $country) {
            $countryData['id'] = $country->id;
            $countryData['title'] = $country->title[$locale] ?? '';
            $data[] = $countryData;
        }

        if (!$countries) {
            throw new ModelNotFoundException;
        }

        return $this->responseSuccess([
            'data' => $data,
        ]);
    }

    public function how_to_use($type)
    {
        $howToUse = HowToUse::where('type',$type)->orderBy('id', 'desc')->get();
        $language = $language ?? app()->getLocale();

        if ($howToUse->isEmpty()) {
            throw new ModelNotFoundException;
        }

        $data = [];
        foreach ($howToUse as $item) {
            $itemData['id'] = $item['id'];
            $itemData['title'] = $item->title($language);
            $itemData['description'] = $item->description($language);
            $itemData['image'] = $item['image'];

            $data[] = $itemData;
        }

        return $this->responseSuccess([
            'data' => $data,
        ]);
    }

    public function slider($id)
    {
        $slider = Slider::find($id);
        $language = $language ?? app()->getLocale();

        if (!$slider) {
            throw new ModelNotFoundException;
        }

        $sliderData['id'] = $slider['id'];
        $sliderData['images'] = [];

        foreach ($slider['images'] as $image) {
            $data['image'] = $image['image'];
            $data['link'] = $image['link'];

            $sliderData['images'][] = $data;
        }

        return $this->responseSuccess([
            'data' => $sliderData,
        ]);
    }


    public function bank_accounts(){
        $data = BankAccount::get();
        return $this->responseSuccess([
            'data' => $data,
        ]);
    }

    public function settings(){
        
    }

}
