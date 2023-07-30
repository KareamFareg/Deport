<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class PlaceRequest extends FormRequest
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

        switch ($this->method()) {
            case 'GET':
            case 'POST':
                {
                    return [
                        'user_id' => 'required|integer|exists:users,id',
                        'lng' => 'required|numeric',
                        'lat' => 'required|numeric',
                        'name' => 'required|string',
                        'note' => 'nullable|string',
                    ];
                }
            case 'DELETE':
                {
                    return [
                        'id' => 'required|exists:fav_places,id'
                    ];
                }
            case 'PUT':
                {
                    return [
                        'user_id' => 'required|integer|exists:users,id',
                        'lng' => 'required|numeric',
                        'lat' => 'required|numeric',
                        'name' => 'required|string',
                        'id' => 'required|exists:fav_places,id',
                        'note' => 'nullable|string',

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
                $this->responseFaild(['errors' => $errors], 422)
            );
        }
    }
}
