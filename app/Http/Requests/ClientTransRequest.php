<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\UtilHelper;

class ClientTransRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        switch($this->method())
        {
            case 'GET':
            case 'POST':
            {
              return [
                'language' => 'required|string|exists:languages,locale',
                'name' => 'required|string|max:150',
                'email' => 'required|string|email|max:50',
                'password' => 'nullable|string|min:6|max:12|confirmed',
                'country_id' => 'required|integer|exists:countries,id',
                'categories' => 'present|array',
                'mobile' => 'required|numeric|digits:9',
                'administrator' => 'required|max:200|string',
                'contacts' => 'nullable|string|max:4000',
                'work_times' => 'nullable|string|max:1000',
                'phone' => 'nullable|numeric|digits:9',
                'commerce_no' => 'required|string|max:500',
                'logo' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
                'banner' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
                'address' => 'required|string|max:4000',
                'description' => 'nullable|string|max:4000',
                'lat' => 'nullable|numeric',
                'lng' => 'nullable|numeric',
                'alias' => 'nullable|string|max:150',
                'meta_tags' => 'nullable|string|max:250',
                'meta_keywords' => 'nullable|string|max:250',
                'meta_description' => 'nullable|string|max:250',
                'parent_id' => 'nullable',
                'template_id' =>  'nullable',
                'notify_mail' =>  'nullable',
                'gender_id' =>  'nullable',
                'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
              ];
            }
            case 'DELETE':
            case 'PUT':
            {
              return [
              ];
            }
            case 'PATCH':
            default:break;
        }


    }

    protected function prepareForValidation()
    {

      $title = UtilHelper::formatNormal($this->name);
      $this->merge([ 'title' => $title ]);
      $this->merge([ 'mobile' => UtilHelper::formatNormal($this->mobile) ]);
      $this->merge([ 'administrator' => UtilHelper::formatNormal($this->administrator) ]);
      $this->merge([ 'contacts' => UtilHelper::formatNormal($this->contacts) ]);
      $this->merge([ 'work_times' => UtilHelper::formatNormal($this->work_times) ]);
      $this->merge([ 'phone' => UtilHelper::formatNormal($this->phone) ]);
      $this->merge([ 'commerce_no' => UtilHelper::formatNormal($this->commerce_no) ]);
      $this->merge([ 'address' => UtilHelper::formatNormal($this->address) ]);
      $this->merge([ 'description' => UtilHelper::formatNormal($this->description) ]);
      $this->merge([ 'alias' => UtilHelper::validateAlias(UtilHelper::convertToLower($title)) ]);
      $this->merge([ 'meta_tags' => $title ]);
      $this->merge([ 'meta_keywords' => $title ]);
      $this->merge([ 'meta_description' => $title ]);



      // return array_merge($this->all(), ['user_id' => $this->user()->id ]);

    }


}
