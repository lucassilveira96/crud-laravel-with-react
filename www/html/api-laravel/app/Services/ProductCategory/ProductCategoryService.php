<?php

namespace App\Services\ProductCategory;

use App\Models\ProductCategory;
use App\Repositories\ProductCategory\ProductCategoryRepository;

/**
 * Class ProductService
 */
class ProductCategoryService implements ProductCategoryServiceInterface
{
    /**
     * @var ProductCategoryRepository
     */
    private $productCategoryRepository;

    /**
     * ProductService constructor.
     */
    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function createProductCategory(array $data): ?ProductCategory
    {
        return $this->productCategoryRepository->create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getProductCategory(int $id): ?ProductCategory
    {
        return $this->productCategoryRepository->getById($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllProductCategories(): ?object
    {
        return $this->productCategoryRepository->getAll();
    }

    /**
     * {@inheritDoc}
     */
    public function updateProductCategory(int $id, array $data): ?ProductCategory
    {
        return $this->productCategoryRepository->update($id, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteProductCategory(int $id): bool
    {
        return $this->productCategoryRepository->delete($id);
    }
}
