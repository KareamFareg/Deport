<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Traits\ApiResponse;

class OrderTransportRequest extends FormRequest
{
  use ApiResponse;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
          'user_id' => 'required|integer|exists:users,id',
          'category_id' => 'required|integer|exists:categories,id',

          // 'items.*.item_id' => 'required|integer|exists:items,id',

          'items.*.transport_type_id' => 'required|integer|exists:transport_types,id',
          'items.*.car_type_id' => 'required|integer|exists:car_types,id',
          'items.*.material_type_id' => 'required|integer|exists:material_types,id',

          'items.*.weight' => 'nullable|numeric',
          'items.*.from_lat' => 'required|numeric',
          'items.*.from_lng' => 'required|numeric',
          'items.*.to_lat' => 'required|numeric',
          'items.*.to_lng' => 'required|numeric',
          'items.*.description' => 'required|string|max:4000',
        ];

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
