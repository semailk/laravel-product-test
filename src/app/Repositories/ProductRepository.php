<?php

namespace App\Repositories;

use App\Jobs\SendProductCreatedNotification;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class ProductRepository
{
    public function __construct(
        protected Product $model
    )
    {
    }

    public function getAllStatusAvailable(): LengthAwarePaginator
    {
        return $this->model->available()->paginate(50);
    }

    public function create(array $data)
    {
        $product = $this->model->create($data);
        SendProductCreatedNotification::dispatch($product);

        return $product;
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function update(Product $product, Request $request): Product
    {
        $articleEditPermission = Gate::inspect('update', $product);

        if ($articleEditPermission->allowed()){
            $product->update(json_decode($request->getContent(), true));
       }else{
            $data = json_decode($request->getContent(), true);
            unset($data['article']);
            $product->update($data);
        }

        return $product;
    }
}
