<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getProducts()
    {
        return Product::all();
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function findProduct(int $id)
    {
        return Product::find($id);
    }

    public function updateProduct(int $id, array $data)
    {
        $product = Product::find($id);

        if (!$product) {
            return null;
        }

        $product->update($data);
        return $product;
    }

    public function deleteProduct(int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return false;
        }

        return $product->delete();
    }
}