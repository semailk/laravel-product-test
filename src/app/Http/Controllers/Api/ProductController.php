<?php

namespace App\Http\Controllers\Api;

use App\DTO\ProductDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository
    )
    {
    }

    public function index(): JsonResponse
    {
        $products = $this->productRepository->getAllStatusAvailable();

        return \response()->json(
            new ProductCollection($products),
            Response::HTTP_OK
        );
    }

    public function store(Request $request): JsonResponse
    {
       Validator::validate($request->input(), (new ProductRequest())->rules());

        $productDto = new ProductDto($request);

        $product = $this->productRepository->create([
            Product::PRODUCT_NAME => $productDto->getName(),
            Product::PRODUCT_ARTICLE => $productDto->getArticle(),
            Product::PRODUCT_STATUS => $productDto->getStatus(),
            Product::PRODUCT_DATA => $productDto->getData()
        ]);

        return response()->json(
            ProductResource::make($product),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Product $product)
    {
        $this->productRepository->delete($product);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function show(Product $product): JsonResponse
    {
        return \response()->json(
            ProductResource::make($product)
        );
    }

    public function update(
        Product $product,
        ProductRequest $productRequest
    ): JsonResponse
    {
        $product = $this->productRepository->update($product, $productRequest);

        return \response()->json(
            ProductResource::make($product)
        );
    }
}
