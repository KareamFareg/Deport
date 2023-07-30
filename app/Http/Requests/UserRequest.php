<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use CommonHelper;
use Illuminate\Validation\Rule;
use App\User;
use App\Traits\ApiResponse;

class UserRequest extends FormRequest
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
                'name' => 'required_if:loginField,==,"name"|string|max:150|unique:users',
                'email' => 'required_if:loginField,==,"email"|string|email|max:50|unique:users',
                'phone' => 'required_if:loginField,==,"phone"|numeric|digits:9|gt:0|unique:users',
                'password' => 'nullable|string|min:8|max:12',
                'type_id' => [ 'required', Rule::in([ 2 , 5 ]) ], // 'exists:user_type,id',
                'role' => [ 'required', Rule::in([ User::SITE_ROLE , User::DELEGATE_ROLE ]), ],
              ];
            }
            case 'DELETE':
            case 'PUT':
            {
              return [
                  'name' => 'required|string|max:150|unique:users,name,'.$this->id,
                  'email' => 'required|string|email|max:50|unique:users,email,'.$this->id,
                  'phone' => 'required|numeric|digits:9|gt:0|unique:users,phone,'.$this->id,
                  'phone' => 'nullable|numeric|gt:0|unique:users,phone,'.$this->id,
                  'password' => 'nullable|string|min:8|max:12|confirmed',
                  'gender_id' => [ 'required', Rule::in([ 1 , 2 ]) ],
                  'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg|max:1024',
                 
                ];
            }
            case 'PATCH':
            default:break;
        }


    }

    protected function prepareForValidation()
    {

      $loginField = CommonHelper::getLoginField()['field'];
      $this->merge([ 'loginField' => $loginField ]);
      // return array_merge($this->all(), ['user_id' => $this->user()->id ]);
      // UtilHelper::formatNormal()

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
