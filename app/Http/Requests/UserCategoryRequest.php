<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Traits\ApiResponse;

class UserCategoryRequest extends FormRequest
{
  use ApiResponse;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
          'categories.*.id' => 'required|integer|exists:categories,id',
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
