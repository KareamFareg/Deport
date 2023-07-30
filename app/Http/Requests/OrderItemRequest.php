<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Traits\ApiResponse;

use App\Helpers\UtilHelper;

class OrderItemRequest extends FormRequest
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
          'user_id_shop' => 'required|integer|exists:users,id',
          'category_id' => 'required|integer|exists:categories,id',
          'paytype_id' => 'required|integer|exists:pay_types,id',
          'deliverytype_id' => 'required|integer|exists:delivery_types,id',
          'delivery_mount' => 'required|numeric', // double
          'lat' => 'required|numeric',
          'lng' => 'required|numeric',
          'total_first' => 'required|numeric', // double
          'total' => 'required|numeric', // double

          'items.*.item_id' => 'required|integer|exists:items,id',
          'items.*.title' => 'required|string|max:200',
          'items.*.price' => 'required|numeric',  // double
          'items.*.description' => 'required|string|max:4000',
        ];

    }

    protected function prepareForValidation()
    {
      // $this->merge(['total_first' => UtilHelper::formatNumber($this['total_first'])]);

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
