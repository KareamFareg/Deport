<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Validation\Rule;
use App\Traits\ApiResponse;

class RateRequest extends FormRequest
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
            {

            }
            case 'POST':
            {
              return [
        
                'user_id' => 'required|integer|exists:users,id',
                'order_id' => 'required|integer|exists:orders,id',
                'rate' => 'required|integer|between:1,5',
                'comment' => 'nullable|string|max:3000',
              ];
            }
            case 'DELETE':
            case 'PUT':
            case 'PATCH':
            default:break;
        }


    }

    protected function prepareForValidation()
    {

      $this->merge([ 'table_name' => '' ]);

      if ($this->type == 'user') {
        $this->merge([ 'table_name' => \App\User::TABLE_NAME ]) ;
      }
      // if ($request->type == 'shop') {
      //   $request->merge([ 'table_name' => \App\item::TABLE_NAME ]) ;
      // }

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
