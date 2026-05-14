<?php

namespace App\Services\ProductImage;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Exception;

class ProductImageService
{
    public function uploadImage(UploadedFile $file, array $data)
    {
        try {
            // Guardar el archivo en el disco 'public' dentro de la carpeta 'products'
            $path = $file->store('products', 'public');

            // Si es la imagen primaria, desactivar las otras imágenes primarias del mismo producto
            if (isset($data['is_primary']) && $data['is_primary']) {
                $this->resetPrimaryImages($data['product_id']);
            }

            return ProductImage::create([
                'product_id' => $data['product_id'],
                'image_url' => $path,
                'alt_text' => $data['alt_text'] ?? null,
                'sort_order' => $data['sort_order'] ?? 0,
                'is_primary' => $data['is_primary'] ?? false,
            ]);
        } catch (Exception $e) {
            Log::error('Error uploading product image: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function updateImage(ProductImage $productImage, array $data)
    {
        try {
            if (isset($data['is_primary']) && $data['is_primary']) {
                $this->resetPrimaryImages($productImage->product_id);
            }

            $productImage->update($data);
            return $productImage;
        } catch (Exception $e) {
            Log::error('Error updating product image ID ' . $productImage->id . ': ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function deleteImage(ProductImage $productImage)
    {
        try {
            // Eliminar el archivo físico del storage
            if (Storage::disk('public')->exists($productImage->image_url)) {
                Storage::disk('public')->delete($productImage->image_url);
            }

            return $productImage->delete();
        } catch (Exception $e) {
            Log::error('Error deleting product image ID ' . $productImage->id . ': ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    protected function resetPrimaryImages(int $productId)
    {
        ProductImage::where('product_id', $productId)
            ->where('is_primary', true)
            ->update(['is_primary' => false]);
    }
}
