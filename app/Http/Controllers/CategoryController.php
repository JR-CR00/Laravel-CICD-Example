<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\Category\CategoryService;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();
        return response()->json(CategoryResource::collection($categories));
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->createCategory($request->validated());
        return response()->json(new CategoryResource($category), 201);
    }

    public function show(Category $category): JsonResponse
    {
        $category->load(['parent', 'children']);
        return response()->json(new CategoryResource($category));
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category = $this->categoryService->updateCategory($category, $request->validated());
        return response()->json(new CategoryResource($category));
    }

    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->deleteCategory($category);
        return response()->json(null, 204);
    }
}
