<?php

namespace Tests\Unit\Services\Product;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ProducttService
     */
    private $productService;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up the dependencies
        $this->productRepository = new ProductRepository(new Product());
        $this->productService = new ProductService($this->productRepository);
    }

    public function testCreateProduct()
    {
        $productCategory = ProductCategory::factory()->create();

        // Create test data
        $data = [
            'product_category_id' => $productCategory->id,
            'product_name' => $this->faker->name,
            'product_value' => $this->faker->randomFloat(2, 1, 1000),
        ];

        // // Create a new instance of the Product factory
        $productFactory = Product::factory();

        // Create a new Product using the factory
        $product = $productFactory->make($data);

        // Call the method being tested
        $result = $this->productService->createProduct($data);

        // Assert the result
        $this->assertInstanceOf(Product::class, $result);
        $this->assertDatabaseHas('products', $data);
    }

    public function testGetProduct()
    {
        $productCategory = ProductCategory::factory()->create();

        // Create test data
        $data = [
            'product_category_id' => $productCategory->id,
            'product_name' => $this->faker->name,
            'product_value' => $this->faker->randomFloat(2, 1, 1000),
        ];

        // // Create a new instance of the Product factory
        $productFactory = Product::factory();

        // Create a new Product using the factory
        $product = $productFactory->make($data);

        // Call the method being tested
        $product = $this->productService->createProduct($data);

        // Call the method being tested
        $result = $this->productService->GetProduct($product->id);

        // Assert the result
        $this->assertInstanceOf(Product::class, $result);
        $this->assertEquals($product->id, $result->id);
    }

    public function testGetAllProducts()
    {
        // Create test products
        $productCategory = ProductCategory::factory()->create();

        // Create test data
        $data = [
            'product_category_id' => $productCategory->id,
            'product_name' => $this->faker->name,
            'product_value' => $this->faker->randomFloat(2, 1, 1000),
        ];

        // // Create a new instance of the Product factory
        $productFactory = Product::factory();

        // Create a new Product using the factory
        $product = $productFactory->make($data);

        // Call the method being tested
        $product = $this->productService->createProduct($data);
        $product = $this->productService->createProduct($data);
        $product = $this->productService->createProduct($data);
        $product = $this->productService->createProduct($data);
        $product = $this->productService->createProduct($data);

        // Call the method being tested
        $result = $this->productService->GetAllProducts();

        // Assert the result
        $this->assertInstanceOf(Product::class, $result->first());
        $this->assertCount(5, $result);
    }

    public function testUpdateProduct()
    {
        $productCategory = ProductCategory::factory()->create();

        // Create test data
        $data = [
            'product_category_id' => $productCategory->id,
            'product_name' => $this->faker->name,
            'product_value' => $this->faker->randomFloat(2, 1, 1000),
        ];

        // Create a new instance of the Product factory
        $productFactory = Product::factory();

        // Create a new Product using the factory
        $product = $productFactory->make($data);

        // Call the method being tested
        $product = $this->productService->createProduct($data);

        // update test data
        $dataUpdate = [
            'product_name' => $this->faker->name,
            'product_value' => $this->faker->randomFloat(2, 1, 1000),
        ];

        // Call the method being tested
        $result = $this->productService->updateProduct($product->id, $dataUpdate);

        // Assert the result
        $this->assertInstanceOf(Product::class, $result);
        $this->assertDatabaseHas('products', array_merge(['id' => $product->id], $dataUpdate));
    }

    public function testDeleteProduct()
    {
        $productCategory = ProductCategory::factory()->create();

        // Create test data
        $data = [
            'product_category_id' => $productCategory->id,
            'product_name' => $this->faker->name,
            'product_value' => $this->faker->randomFloat(2, 1, 1000),
        ];

        // Create a new instance of the Product factory
        $productFactory = Product::factory();

        // Create a new Product using the factory
        $product = $productFactory->make($data);

        // Call the method being tested
        $product = $this->productService->createProduct($data);

        // Call the method being tested
        $result = $this->productService->deleteProduct($product->id);

        // Assert the result
        $this->assertEquals(true, $result);
    }
}
