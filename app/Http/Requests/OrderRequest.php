<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Traits\ApiResponse;


class OrderRequest extends FormRequest
{
    use ApiResponse;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
          'user_id' => 'required|integer|exists:users,id',
          //'paytype_id' => 'required|integer|exists:pay_types,id',
          'type' => 'required|integer',
          //'delivery_mount' => 'required|numeric', // double
          'source_lat' => 'nullable|numeric',
          'shop_id' => 'nullable|numeric',
          'source_lng' => 'nullable|numeric',
          'destination_lat' => 'required|numeric',
          'destination_lng' => 'required|numeric',
          'discount' => 'nullable|numeric',
          'comment' => 'nullable|string',
          'shop_name' => 'nullable|string',
          'package_type' => 'nullable|numeric',
          'addition_service' => 'nullable|numeric',

          'items' => 'required|array|min:1',
          'items.*.item_id' => 'nullable|integer|exists:products,id',
          'items.*.title' => 'required|string|max:200',
          'items.*.quantity' => 'required|numeric',  // double
          'items.*.image' => 'nullable',
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
