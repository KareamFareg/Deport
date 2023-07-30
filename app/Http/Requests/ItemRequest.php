<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\UtilHelper;

class ItemRequest extends FormRequest
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
                'description' => 'required|string|max:200',
                'title' => 'nullable|string|max:100',
                'alias' => 'nullable|string|max:150',
                // 'price' => 'required|numeric',
                // 'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',
                'user_id' => 'nullable|integer|exists:users,id',
                'type_id' => 'required|integer|exists:item_types,id',
                'adv_period_id' => 'required_if:type_id,==,1|integer|exists:adv_periods,id',
                'links' => 'nullable|url|string|max:1000',
              ];
            }
            case 'DELETE':
            case 'PUT':
            {
              return [
                'description' => 'required|string|max:200',
                'title' => 'nullable|string|max:100',
                'alias' => 'nullable|string|max:150',
                // 'price' => 'required|numeric',
                // 'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',
                'user_id' => 'nullable|integer|exists:users,id',
                'type_id' => 'required|integer|exists:item_types,id',
                'adv_period_id' => 'required_if:type_id,==,1|integer|exists:adv_periods,id',
                'links' => 'nullable|url|string|max:1000',
              ];
            }
            case 'PATCH':
            default:break;
        }


    }

    protected function prepareForValidation()
    {

      $description = UtilHelper::formatNormal($this->description);
      $title = mb_substr($description,0,20,'utf-8');
      $this->merge([ 'title' => $title ]);
      $this->merge([ 'title_general' => $title ]);
      $this->merge([ 'alias' => UtilHelper::validateAlias(UtilHelper::convertToLower($title)) ]);
      $this->merge([ 'description' => $description ]);

      // return array_merge($this->all(), ['user_id' => $this->user()->id ]);

    }


}
