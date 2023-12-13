<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository
    )
    {
    }

    public function index(): View
    {
        return \view('products.index', [
            'products' => $this->productRepository->getAllStatusAvailable()
        ]);
    }
}
