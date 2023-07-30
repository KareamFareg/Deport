<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Traits\ApiResponse;

class ItemAirRequest extends FormRequest
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
                'from_country_id' => 'required|integer|exists:countries,id',
                'to_country_id' => 'required|integer|exists:countries,id',
                'package_count' => 'required|integer',
                '_date' => 'required',
                '_time' => 'required|date_format:H:i',
                'price' => 'required|numeric',
                'user_id' => 'required|integer|exists:users,id',
              ];
            }
            case 'DELETE':
            case 'PUT':
            {
              return [
                'from_country_id' => 'required|integer|exists:countries,id',
                'to_country_id' => 'required|integer|exists:countries,id',
                'package_count' => 'required|integer',
                '_date' => 'required',
                '_time' => 'required|date_format:H:i',
                'price' => 'required|numeric',
                'user_id' => 'required|integer|exists:users,id',
                'item_id' => 'required|integer',
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
