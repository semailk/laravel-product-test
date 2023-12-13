<?php

namespace App\Http\Resources;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($product) {
                return [
                    Product::PRODUCT_ID => $product->id,
                    Product::PRODUCT_ARTICLE => $product->article,
                    Product::PRODUCT_NAME => $product->name,
                    Product::PRODUCT_STATUS => $product->status,
                    Product::PRODUCT_DATA => $product->data,
                    Product::PRODUCT_CREATED_AT => Carbon::make($product->created_at)->format('d-m-Y H:i:s'),
                    Product::PRODUCT_UPDATED_AT => Carbon::make($product->updated_at)->format('d-m-Y H:i:s'),
                ];
            }),
            'meta' => [
                'current_page' => $this->resource->currentPage(),
                'from' => $this->resource->firstItem(),
                'last_page' => $this->resource->lastPage(),
                'path' => $this->resource->path(),
                'per_page' => $this->resource->perPage(),
                'to' => $this->resource->lastItem(),
                'total' => $this->resource->total(),
            ],
        ];
    }
}
