<?php

namespace App\Http\Resources;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            Product::PRODUCT_ARTICLE => $this->article,
            Product::PRODUCT_NAME => $this->name,
            Product::PRODUCT_DATA => $this->data,
            Product::PRODUCT_STATUS => $this->status,
            Product::PRODUCT_ID => $this->id,
            Product::PRODUCT_CREATED_AT => Carbon::make($this->created_at)->format('d-m-Y H:i:s'),
            Product::PRODUCT_UPDATED_AT => Carbon::make($this->updated_at)->format('d-m-Y H:i:s'),
        ];
    }
}
