<?php

namespace App\Repositories\ProductCategory;

use App\Models\ProductCategory;

interface ProductCategoryRepositoryInterface
{
    /**
     * Insert new product category into database
     */
    public function create(array $data): ?ProductCategory;

    /**
     * get one product category by id into database
     */
    public function getById(int $id): ?ProductCategory;

    /**
     * Update one product category by id into database
     */
    public function update(int $id, array $data): ?ProductCategory;

    /**
     * get all product category into database
     */
    public function getAll(): ?object;

    /**
     * Delete one product category by id into database
     */
    public function delete(int $id): bool;
}
