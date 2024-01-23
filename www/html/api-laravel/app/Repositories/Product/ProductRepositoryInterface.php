<?php

namespace App\Repositories\Product;

use App\Models\Product;
use PhpParser\Node\Expr\Cast\Bool_;

interface ProductRepositoryInterface
{
    /**
     * Insert new product into database
     */
    public function create(array $data): ?Product;

    /**
     * get one product by id into database
     */
    public function getById(int $id): ?Product;

    /**
     * Update one product by id into database
     */
    public function update(int $id, array $data): ?Product;

    /**
     * get all product into database
     */
    public function getAll(): ?object;

    /**
     * Delete one product by id into database
     */
    public function delete(int $id): bool;
}
