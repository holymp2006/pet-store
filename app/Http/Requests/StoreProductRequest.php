<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
