<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

/**
 * Controller responsible for retrieving information about a Product.
 *
 * @OA\Info(
 *     title="API LARAVEL PRODUCTS AND PRODUCT CATEGORIES",
 *     version="1.0.0",
 *     description="api of products and product categories"
 * )
 */
class GetAllProductsController extends Controller
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * Constructor.
     *
     * @param  ProductService  $productService The product service.
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Retrieves all products.
     *
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Get all products",
     *
     *     @OA\Response(response="200", description="Get all products"),
     * )
     */
    public function __invoke()
    {
        try {
            $data = $this->productService->getAllProducts();

            return response()->json(
                [
                    'data' => $data,
                    'status' => Response::HTTP_OK,
                ],
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::error(
                $e->getMessage,
                [
                    'code' => 'product_api_log',
                    'exception' => $exception,
                ]
            );

            return response()->json(
                [
                    'data' => 'Error',
                    'status' => Response::HTTP_BAD_REQUEST,
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
