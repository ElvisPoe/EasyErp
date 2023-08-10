<?php

namespace App\Services\WordPress;

use Illuminate\Support\Facades\Log;

class Product extends Client
{
    // Fetch Products
    public function getProducts(): ?array
    {
        $response = $this->client()->get("/products");
        if ($response->failed()) {
            Log::error("Failed to get products. Err: {$response->body()}");
            return null;
        }

        return $response->json();
    }

    // Create Products
    public function createProduct(array $product): ?string
    {
        $response = $this->client()->post("/products", $product);
        if ($response->failed()) {
            Log::error("Failed to create product. Err: {$response->body()}");
            return null;
        }

        return $response->json("id");
    }
}