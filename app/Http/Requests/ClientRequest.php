<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\UtilHelper;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponse;

class ClientRequest extends FormRequest
{

  use ApiResponse;

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
                'name' => 'nullable|string|max:150',
                'email' => 'nullable|string|email|max:50|unique:users',
                'password' => 'required|string|min:6|max:12',
                'phone' => 'required|numeric|digits:10|unique:users',
                'contacts' => 'nullable|string|max:100',
                'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
                'banner' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
                'description' => 'nullable|string|max:200',
                'alias' => 'nullable|string|max:150',
                'meta_tags' => 'nullable|string|max:250',
                'meta_keywords' => 'nullable|string|max:250',
                'meta_description' => 'nullable|string|max:250',
                'notify_mail' =>  'nullable',
                'gender' =>  'nullable',
                'accept_terms' => 'accepted',
                'type_id' => 'required',
               // 'lang' => 'required',
              ];
            }
            case 'DELETE':
            case 'PUT':
            {
              return [
                'name' => 'required|string|max:150',
                'email' => 'nullable|string|email|max:50|unique:users,email,'.$this->id,
                'password' => 'nullable|string|min:6|max:12|confirmed',
                'phone' => 'nullable|digits:10|unique:users,phone,'.$this->id,
                'id_number' => 'nullable|numeric|unique:users,id_number,'.$this->id,
                'contacts' => 'nullable|string|max:100',
                'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
                'banner' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
                'description' => 'nullable|string|max:200',
                'alias' => 'nullable|string|max:150',
                'meta_tags' => 'nullable|string|max:250',
                'meta_keywords' => 'nullable|string|max:250',
                'meta_description' => 'nullable|string|max:250',
                'notify_mail' =>  'nullable',
                'gender' =>  'nullable',
                'city' =>  'nullable',
                'area' =>  'nullable',
                'id_card' => 'nullable|file|image|mimes:jpeg,png,gif,jpg|max:1024',
                'license' => 'nullable|file|image|mimes:jpeg,png,gif,jpg|max:1024',
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
     // $this->merge([ 'phone' => UtilHelper::formatNormal($this->phone) ]);
      $this->merge([ 'contacts' => UtilHelper::formatNormal($this->contacts) ]);
      // $this->merge([ 'phone' => UtilHelper::formatNormal($this->phone) ]);
      $this->merge([ 'description' => UtilHelper::formatNormal($this->description) ]);
      $this->merge([ 'alias' => UtilHelper::validateAlias(UtilHelper::convertToLower($title)) ]);
      $this->merge([ 'meta_tags' => $title ]);
      $this->merge([ 'meta_keywords' => $title ]);
      $this->merge([ 'meta_description' => $title ]);

    }

    // public function attributes()
    // {
    //     return [
    //         'name' => 'email address',
    //     ];
    // }

    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
          $errors = (new ValidationException($validator))->errors();

          throw new HttpResponseException(
            $this->responseFaild(['errors' => $errors],422)
          );
        }
    }


}
