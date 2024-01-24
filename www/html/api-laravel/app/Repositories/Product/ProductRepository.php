<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var Products
     */
    private $productModel;

    public function __construct(Product $product)
    {
        $this->productModel = $product;
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): ?Product
    {
        return $this->productModel->create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $id): ?Product
    {
        return $this->productModel::with('ProductCategory')->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): ?Product
    {
        $product = $this->getById($id);
        $product->update($data);

        return $product;
    }

    /**
     * {@inheritDoc}
     */
    public function getAll(): ?object
    {
        return $this->productModel::with('ProductCategory')->get();
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): bool
    {
        $product = $this->getById($id);
        if(!is_null($product)){
            return $product->delete();
        }

        return false;
    }

}
