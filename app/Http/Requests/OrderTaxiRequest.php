<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Traits\ApiResponse;

class OrderTaxiRequest extends FormRequest
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
          'items.*._count' => 'required|integer|gt:0',
          'items.*._date' => 'required',
          'items.*.from_lat' => 'required|numeric',
          'items.*.from_lng' => 'required|numeric',
          'items.*.to_lat' => 'required|numeric',
          'items.*.to_lng' => 'required|numeric',
          // 'items.*.description' => 'required|string|max:4000',
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
