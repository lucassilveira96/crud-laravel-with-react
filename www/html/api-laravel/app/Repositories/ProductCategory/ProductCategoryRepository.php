<?php

namespace App\Repositories\ProductCategory;

use App\Models\ProductCategory;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface
{
    /**
     * @var ProductCategory
     */
    private $productCategoryModel;

    public function __construct(ProductCategory $productCategory)
    {
        $this->productCategoryModel = $productCategory;
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): ?ProductCategory
    {
        return $this->productCategoryModel->create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $id): ?ProductCategory
    {
        return $this->productCategoryModel->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): ?ProductCategory
    {
        $productCategory = $this->getById($id);
        $productCategory->update($data);

        return $productCategory;
    }

    /**
     * {@inheritDoc}
     */
    public function getAll(): ?object
    {
        return $this->productCategoryModel->all();
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): bool
    {
        $productCategory = $this->getById($id);
        if(!is_null($productCategory)){
            return $productCategory->delete();
        }

        return false;
    }
}
