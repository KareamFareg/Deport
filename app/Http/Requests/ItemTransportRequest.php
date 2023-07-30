<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Traits\ApiResponse;

class ItemTransportRequest extends FormRequest
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
                'car_type_id' => 'required|integer|exists:car_types,id',
                'car_brand_id' => 'required|integer|exists:car_brands,id',
                'car_model' => 'required|integer|digits:4',
                'user_id' => 'required|integer|exists:users,id',
                'car_license_image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg|max:1024',
                'identity_image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg|max:1024',
                'car_front_image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg|max:1024',
                'car_back_image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg|max:1024',
              ];
            }
            case 'DELETE':
            case 'PUT':
            {
              return [
                'car_type_id' => 'required|integer|exists:car_types,id',
                'car_brand_id' => 'required|integer|exists:car_brands,id',
                'car_model' => 'required|integer|digits:4',
                'user_id' => 'required|integer|exists:users,id',
                'car_license_image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg|max:1024',
                'identity_image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg|max:1024',
                'car_front_image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg|max:1024',
                'car_back_image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg|max:1024',
              ];
            }
            case 'PATCH':
            default:break;
        }






    }

    protected function prepareForValidation()
    {

    }

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
