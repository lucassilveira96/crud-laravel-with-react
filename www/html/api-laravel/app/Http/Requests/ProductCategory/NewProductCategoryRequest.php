<?php

namespace App\Http\Requests\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request class for validating the data when creating a new product.
 */
class NewProductCategoryRequest extends FormRequest
{
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
     * Get the validation rules that apply to the post request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_category_name' => 'required|string|max:150',
        ];


    }
}
