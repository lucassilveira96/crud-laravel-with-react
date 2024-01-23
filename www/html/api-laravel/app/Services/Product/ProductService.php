<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;

/**
 * Class ProductService
 */
class ProductService implements ProductServiceInterface
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * ProductService constructor.
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function createProduct(array $data): ?Product
    {
        return $this->productRepository->create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getProduct(int $id): ?Product
    {
        return $this->productRepository->getById($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllProducts(): ?object
    {
        return $this->productRepository->getAll();
    }

    /**
     * {@inheritDoc}
     */
    public function updateProduct(int $id, array $data): ?Product
    {
        return $this->productRepository->update($id, $data);
    }

     /**
     * {@inheritDoc}
     */
    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->delete($id);
    }
}
