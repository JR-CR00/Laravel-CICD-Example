<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Services\ProductImage\ProductImageService;
use App\Http\Requests\ProductImage\StoreProductImageRequest;
use App\Http\Requests\ProductImage\UpdateProductImageRequest;
use App\Http\Resources\ProductImageResource;
use Illuminate\Http\JsonResponse;

class ProductImageController extends Controller
{
    protected $imageService;

    public function __construct(ProductImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function store(StoreProductImageRequest $request): JsonResponse
    {
        $image = $this->imageService->uploadImage($request->file('image'), $request->validated());
        return response()->json(new ProductImageResource($image), 201);
    }

    public function show(ProductImage $productImage): JsonResponse
    {
        return response()->json(new ProductImageResource($productImage));
    }

    public function update(UpdateProductImageRequest $request, ProductImage $productImage): JsonResponse
    {
        $image = $this->imageService->updateImage($productImage, $request->validated());
        return response()->json(new ProductImageResource($image));
    }

    public function destroy(ProductImage $productImage): JsonResponse
    {
        $this->imageService->deleteImage($productImage);
        return response()->json(null, 204);
    }
}
