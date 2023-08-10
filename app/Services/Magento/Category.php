<?php

namespace App\Services\Magento;

use Illuminate\Support\Facades\Log;

class Category extends Client
{
    // Fetch Categories
    public function getCategories(): ?array
    {
        $response = $this->client()->get("/categories");
        if ($response->failed()) {
            Log::error("Failed to get categories. Err: {$response->body()}");
            return null;
        }

        return $response->json();
    }

    // Create Category
    public function createCategory(array $category): ?string
    {
        $response = $this->client()->post("/category", $category);
        if ($response->failed()) {
            Log::error("Failed to create category. Err: {$response->body()}");
            return null;
        }

        return $response->json("id");
    }
}