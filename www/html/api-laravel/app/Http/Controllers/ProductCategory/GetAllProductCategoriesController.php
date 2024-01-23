<?php

namespace App\Http\Controllers\ProductCategory;

use App\Http\Controllers\Controller;
use App\Services\ProductCategory\ProductCategoryService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;


/**
 * Controller responsible for retrieving all product categories.
 */
class GetAllProductCategoriesController extends Controller
{
    /**
     * @var ProductCategoryService
     */
    private $productCategoryService;

    /**
     * Constructor.
     *
     * @param  ProductCategoryService  $productCategoryService The product category service.
     */
    public function __construct(ProductCategoryService $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }

    /**
     * Retrieves all product categories.
     *
     * @OA\Get(
     *     path="/api/product/categories",
     *     tags={"Product Categories"},
     *     summary="Get all product categories",
     *
     *     @OA\Response(response="200", description="Get all product categories"),
     * )
     */
    public function __invoke()
    {
        try {
            $data = $this->productCategoryService->getAllProductCategories();

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
                    'code' => 'product_category_api_log',
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
