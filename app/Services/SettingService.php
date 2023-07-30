<?php

namespace App\Services;

use App\Helpers\UtilHelper;
use App\Models\Setting;


class SettingService
{


    // return collection
    public function queryAll($params = [], $language = null)
    {

    }

    // return collection
    public function getAll($language = null)
    {
        $language = $language ?? app()->getLocale();
        $settings = Setting::find(1);
       
        $settings = $settings->toArray();
        $data = array();

        foreach ($settings as $item => $value) {

            if (is_array($value)) {
                $data[$item] = $value[$language];
            } else {
                $data[$item] = $value;
            }

        }



        return $data;

    }

    // return model
    public function getSettingByProperty($property, $language = null)
    {
        $language = $language ?? app()->getLocale();

        $item = Setting::select($property)->find(1);
        $item = $item->toArray()[$property];
        if (!$item) {
            return false;
        }
        if (is_array($item)) {
            $item = $item[$language];
        }

        return $item;

    }

    public function getSettingByProperties($properties = [], $language = null)
    {
        $language = $language ?? app()->getLocale();

        $items = Setting::select($properties)->find(1);
        $items = $items->toArray();
        $all = [];
        foreach ($items as $item => $value) {

            if (is_array($value)) {
                $all[$item] = $value[$language];
            } else {
                $all[$item] = $value;
            }

        }
        return $all;
    }

    public function getSettingContacts($language = null)
    {
        $language = $language ?? app()->getLocale();

       return $this->getSettingByProperties(['phone_1','mail'],$language);

    }

    public function update($request)
    {
        $language = $request->language;
        $settings = Setting::find(1);
        try {

            $settings = $settings->toArray();
            $data = array();

            foreach ($request->all() as $item => $value) {

                if (is_array($value)) {
                    
                    $data[$item] = $request->merge([$item => array_merge( $settings[$item] , $value)])[$item]; 
                } else {
                    if ($item == 'logo') {
                        continue;
                    }

                    if ($item == 'about_us_image') {
                        continue;
                    }
                    $data[$item] = $request->$item;
                }

            }

            Setting::find(1)->update($data);

        } catch (\Exception $e) {
            return $e->getMessage();

        }

        return true;

    }


}
