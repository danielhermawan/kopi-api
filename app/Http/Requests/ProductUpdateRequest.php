<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 8/30/2017
 * Time: 5:29 PM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
            'image' => 'filled|image',
            'category_id' => 'required',
            'min_stock' => 'filled|numeric|min:0|required_with:min_stock_unit',
            'per_stock' => 'filled|numeric|min:0',
            'purchase_price' => 'filled|numeric|min:0',
            'min_stock_unit' => [
                'filled',
                'required_with:min_stock_unit',
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