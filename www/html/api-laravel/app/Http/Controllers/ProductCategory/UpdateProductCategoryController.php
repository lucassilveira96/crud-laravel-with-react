<?php

namespace App\Http\Controllers\ProductCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategory\NewProductCategoryRequest;
use App\Services\ProductCategory\ProductCategoryService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Controller responsible for updating a product category by ID.
 */
class UpdateProductCategoryController extends Controller
{
    /**
     * @var ProductCategoryService
     */
    private $productCategoryService;

    /**
     * Constructor.
     *
     * @param  ProductService  $productCategoryService The product category service.
     */
    public function __construct(ProductCategoryService $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }

    /**
     * Update a product category by ID.
     *
     * @OA\Patch(
     *     path="/api/product/categories/{id}",
     *     tags={"Product Categories"},
     *     summary="Update product category by id",
     *     description="Update product by id",
     *     operationId="updateProductCategory",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Product Category",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="product_category_name",
     *                 type="string",
     *                 example="t"
     *             ),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Update Product by id",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 format="int64",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="product_category_name",
     *                 type="string",
     *                 example="technologies"
     *             ),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Product Category not found"
     *     )
     * )
     */
    public function __invoke(NewProductCategoryRequest $request)
    {
        try {
            $idProductCategory = (int) $request->route('id');
            if ($idProductCategory > 0) {
                $data = $this->productCategoryService->updateProductCategory($idProductCategory, $request->validated());

                if ($data) {
                    return response()->json(
                        [
                            'data' => $data,
                            'status' => Response::HTTP_OK,
                        ],
                        Response::HTTP_OK
                    );
                } else {
                    return response()->json(
                        [
                            'data' => 'Error',
                            'status' => Response::HTTP_BAD_REQUEST,
                        ],
                        Response::HTTP_BAD_REQUEST
                    );
                }
            }

        } catch (Exception $e) {
            $exception = $e->getMessage();
            Log::error(
                $e->getMessage,
                [
                    'code' => 'product_api_log',
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
