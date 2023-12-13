<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->method() == 'PATCH'){
            /** @var Product $product */
            $product = $this->route('product');
            return [
                'article' => ['regex:/^[a-zA-Z0-9]+$/i', Rule::unique('products')->ignore($product->id)],
                'name' => 'min:10',
                'status' => 'in:available,unavailable'
            ];
        }

        return [
            'article' => ['required', 'regex:/^[a-zA-Z0-9]+$/i', 'unique:products'],
            'name' => 'required|min:10',
            'status' => 'required|in:available,unavailable'
        ];
    }
}
