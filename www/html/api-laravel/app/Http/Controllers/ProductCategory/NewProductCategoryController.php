<?php

namespace App\Http\Controllers\ProductCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategory\NewProductCategoryRequest;
use App\Services\ProductCategory\ProductCategoryService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

/**
 * Controller responsible for creating a new product category.
 */
class NewProductCategoryController extends Controller
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
     * Create a new product category.
     *
     * @OA\Post(
     *     path="/api/product/categories",
     *     tags={"Product Categories"},
     *     summary="Create one product category",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *             required={"product_category_name"},
     *             @OA\Property(property="product_category_name", type="string", example="technology"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response="201",
     *         description="Categoria de Produto cadastrada com sucesso",
     *     ),
     * )
     */
    public function __invoke(NewProductCategoryRequest $request)
    {
        try {
            $data = $this->productCategoryService->createProductCategory($request->validated());

            return response()->json(
                [
                    'data' => $data,
                    'status' => Response::HTTP_CREATED,
                ],
                Response::HTTP_CREATED
            );

        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::error(
                $e->getMessage,
                [
                    'code' => 'product_category_api_log',
                    'exception' => $exception,
                    'context' => $request,
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
