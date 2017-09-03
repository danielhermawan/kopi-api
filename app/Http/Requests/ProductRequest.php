<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ProductRequest extends ApiFormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'filled|string',
            'image' => 'required|image',
            'category_id' => 'required',
            'min_stock' => 'filled|numeric|min:0',
            'per_stock' => 'filled|numeric|min:0',
            'purchase_price' => 'filled|numeric|min:0',
            'min_stock_unit' => [
                'filled',
                Rule::in(['pcs', 'carton', 'pack'])
            ],
            'type' => [
                'filled',
                Rule::in(['order', 'stock', 'stock_order', 'stock_kg'])
            ],
            'recipe' => [
                'filled',
                'json'
            ]
        ];
    }
}
