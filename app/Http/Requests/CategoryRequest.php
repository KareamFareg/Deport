<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\UtilHelper;

class CategoryRequest extends FormRequest
{

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
                'language' => 'required|string|exists:languages,locale',
                'title' => 'required|string|max:100',
                'alias' => 'nullable|string|max:150',
                'parents' => 'required|integer',
                'sort' => 'nullable|integer|gt:0',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',
              ];
            }
            case 'DELETE':
            case 'PUT':
            {
              return [
                'language' => 'required|string|exists:languages,locale',
                'title' => 'required|string|max:100',
                'alias' => 'nullable|string|max:150',
                'parents' => 'required|integer',
                'sort' => 'nullable|integer|gt:0',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',
              ];
            }
            case 'PATCH':
            default:break;
        }


    }

    protected function prepareForValidation()
    {

      $title = UtilHelper::formatNormal($this->title);
      $this->merge([ 'title' => $title ]);
      $this->merge([ 'alias' => UtilHelper::validateAlias(UtilHelper::convertToLower($title)) ]);
      $this->merge([ 'description' => UtilHelper::formatNormal($this->description) ]);


      // return array_merge($this->all(), ['user_id' => $this->user()->id ]);

    }


}
