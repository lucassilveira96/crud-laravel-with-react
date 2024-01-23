<?php

namespace App\Services\ProductCategory;

use App\Models\ProductCategory;

/**
 * Interface ProductCategoryServiceInterface
 */
interface ProductCategoryServiceInterface
{
    /**
     * Insert a new product category into the database.
     *
     * @param  array  $data The data for the new product category.
     * @return Product|null The created product category instance or null if the creation fails.
     */
    public function createProductCategory(array $data): ?ProductCategory;

    /**
     * Get a product by ID from the database.
     *
     * @param  int  $id The ID of the product category.
     * @return ProductCategory|null The product instance or null if the product category is not found.
     */
    public function getProductCategory(int $id): ?ProductCategory;

    /**
     * Get all product categories from the database.
     *
     * @return object|null The collection of product categories or null if no product categories are found.
     */
    public function getAllProductCategories(): ?object;

    /**
     * Update a product category by ID in the database.
     *
     * @param  int  $id The ID of the product category to update.
     * @param  array  $data The updated data for the product category.
     * @return Category|null The updated product category instance or null if the update fails.
     */
    public function updateProductCategory(int $id, array $data): ?ProductCategory;

          /**
     * Delete a product category by ID in the database.
     *
     * @param  int  $id The ID of the product category to delete.
     */
    public function deleteProductCategory(int $id): bool;
}
