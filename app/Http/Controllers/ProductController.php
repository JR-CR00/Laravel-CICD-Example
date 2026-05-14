<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Product\ProductService;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        return response()->json(ProductResource::collection($products));
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->validated());
        return response()->json(new ProductResource($product), 201);
    }

    public function show(Product $product): JsonResponse
    {
        $product->load(['category', 'images']);
        return response()->json(new ProductResource($product));
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product = $this->productService->updateProduct($product, $request->validated());
        return response()->json(new ProductResource($product));
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->productService->deleteProduct($product);
        return response()->json(null, 204);
    }
}
