<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Traits\ApiResponse;

class OrderAirRequest extends FormRequest
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
          'user_id_accept' => 'required|integer|exists:users,id',
          'category_id' => 'required|integer|exists:categories,id',
          'total' => 'required|numeric', // double

          'items.*.item_id' => 'required|integer|exists:items,id',
          'items.*.package_image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg|max:1024',
          'items.*.description' => 'required|string|max:4000',
          'items.*.identity_no' => 'required|numeric|digits:20',
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
