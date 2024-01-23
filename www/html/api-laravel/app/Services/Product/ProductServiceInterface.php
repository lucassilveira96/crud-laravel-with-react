<?php

namespace App\Services\Product;

use App\Models\Product;

/**
 * Interface ProductServiceInterface
 */
interface ProductServiceInterface
{
    /**
     * Insert a new product into the database.
     *
     * @param  array  $data The data for the new product.
     * @return Product|null The created product instance or null if the creation fails.
     */
    public function createProduct(array $data): ?Product;

    /**
     * Get a product by ID from the database.
     *
     * @param  int  $id The ID of the product.
     * @return Product|null The product instance or null if the product is not found.
     */
    public function getProduct(int $id): ?Product;

    /**
     * Get all products from the database.
     *
     * @return object|null The collection of products or null if no products are found.
     */
    public function getAllProducts(): ?object;

    /**
     * Update a product by ID in the database.
     *
     * @param  int  $id The ID of the product to update.
     * @param  array  $data The updated data for the product.
     * @return Product|null The updated product instance or null if the update fails.
     */
    public function updateProduct(int $id, array $data): ?Product;

      /**
     * Delete a product by ID in the database.
     *
     * @param  int  $id The ID of the product to delete.
     */
    public function deleteProduct(int $id): bool;
}
