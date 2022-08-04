<?php

namespace App\Http\Requests;

use App\Traits\AddsCategoryIdToValidatedArrayBag;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    use AddsCategoryIdToValidatedArrayBag;
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
            'category_uuid' => ['required', 'string', 'uuid', Rule::exists('categories', 'uuid')],
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'metadata' => ['required', 'array'],
            'metadata.brand' => ['required', 'string', 'uuid', Rule::exists('brands', 'uuid')],
            'metadata.image' => ['required', 'string', 'uuid', Rule::exists('files', 'uuid')],
        ];
    }
}
