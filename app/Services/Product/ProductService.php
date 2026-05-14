<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductService
{
    public function getAllProducts()
    {
        return Product::with(['category', 'images'])->get();
    }

    public function createProduct(array $data)
    {
        try {
            return Product::create($data);
        } catch (Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function updateProduct(Product $product, array $data)
    {
        try {
            $product->update($data);
            return $product;
        } catch (Exception $e) {
            Log::error('Error updating product ID ' . $product->id . ': ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function deleteProduct(Product $product)
    {
        try {
            return $product->delete();
        } catch (Exception $e) {
            Log::error('Error deleting product ID ' . $product->id . ': ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
