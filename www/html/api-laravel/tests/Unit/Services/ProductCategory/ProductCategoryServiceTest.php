<?php

namespace Tests\Unit\Services\ProductCategory;

use App\Models\ProductCategory;
use App\Repositories\ProductCategory\ProductCategoryRepository;
use App\Services\ProductCategory\ProductCategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCategoryServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var ProductCategoryRepository
     */
    private $productCategoryRepository;

    /**
     * @var ProductCategoryService
     */
    private $productCategoryService;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up the dependencies
        $this->productCategoryRepository = new ProductCategoryRepository(new ProductCategory());
        $this->productCategoryService = new ProductCategoryService($this->productCategoryRepository);
    }

    public function testCreateProductCategory()
    {
        // Create test data
        $data = [
            'product_category_name' => $this->faker->name,
        ];

        // Create a new instance of the Product factory
        $productCategoryFactory = ProductCategory::factory();

        // Create a new Product using the factory
        $product = $productCategoryFactory->make($data);

        // Call the method being tested
        $result = $this->productCategoryService->createProductCategory($data);

        // Assert the result
        $this->assertInstanceOf(ProductCategory::class, $result);
        $this->assertDatabaseHas('product_categories', $data);
    }

    public function testGetProductCategory()
    {
        // Create a test product category
        $productCategory = ProductCategory::factory()->create();

        // Call the method being tested
        $result = $this->productCategoryService->getProductCategory($productCategory->id);

        // Assert the result
        $this->assertInstanceOf(ProductCategory::class, $result);
        $this->assertEquals($productCategory->id, $result->id);
    }

    public function testGetAllProductCategories()
    {
        // Create test clients
        $productCategories = ProductCategory::factory()->count(5)->create();

        // Call the method being tested
        $result = $this->productCategoryService->getAllProductCategories();

        // Assert the result
        $this->assertInstanceOf(ProductCategory::class, $result->first());
        $this->assertCount(5, $result);
    }

    public function testUpdateProductCategory()
    {
        // Create a test product category
        $productCategory = ProductCategory::factory()->create();

        // Update the product category data
        $data = [
            'product_category_name' => $this->faker->name,
        ];

        // Call the method being tested
        $result = $this->productCategoryService->updateProductCategory($productCategory->id, $data);

        // Assert the result
        $this->assertInstanceOf(ProductCategory::class, $result);
        $this->assertDatabaseHas('product_categories', array_merge(['id' => $productCategory->id], $data));
    }

    public function testDeleteProductCategory()
    {
        // Create a test product category
        $productCategory = ProductCategory::factory()->create();

        // Call the method being tested
        $result = $this->productCategoryService->deleteProductCategory($productCategory->id);

        // Assert the result
        $this->assertEquals(true, $result);
    }
}
