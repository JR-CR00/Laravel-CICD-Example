<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Exception;

class CategoryService
{
    public function getAllCategories()
    {
        return Category::with(['parent', 'children'])->get();
    }

    public function createCategory(array $data)
    {
        try {
            return Category::create($data);
        } catch (Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function updateCategory(Category $category, array $data)
    {
        try {
            $category->update($data);
            return $category;
        } catch (Exception $e) {
            Log::error('Error updating category ID ' . $category->id . ': ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function deleteCategory(Category $category)
    {
        try {
            return $category->delete();
        } catch (Exception $e) {
            Log::error('Error deleting category ID ' . $category->id . ': ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
