<?php

namespace App\Http\Controllers\ProductCategory;

use App\Http\Controllers\Controller;
use App\Services\ProductCategory\ProductCategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Controller responsible for delete a product category by ID.
 */
class DeleteProductCategoryController extends Controller
{
    /**
     * @var ProductCategoryService
     */
    private $productCategoryService;

    /**
     * Constructor.
     *
     * @param  ProductCategoryService  $productCategoryService The product service.
     */
    public function __construct(ProductCategoryService $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }

    /**
     * Update a product by ID.
     *
     * @OA\Delete(
     *     path="/api/product/categories/{id}",
     *     tags={"Product Categories"},
     *     summary="Delete product category by id",
     *     description="Delete product category by id",
     *     operationId="deleteProductCategory",
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
     *     @OA\Response(
     *         response=400,
     *         description="Product Category not found"
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        try {
            $idProductCategory = (int) $request->route('id');
            if ($idProductCategory > 0) {
                $data = $this->productCategoryService->deleteProductCategory($idProductCategory);
                if ($data) {
                    return response()->json(
                        [
                            'data' => 'Deleted product category',
                            'status' => Response::HTTP_OK,
                        ],
                        Response::HTTP_OK
                    );
                } else {
                    return response()->json(
                        [
                            'data' => 'Error when deleting',
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
