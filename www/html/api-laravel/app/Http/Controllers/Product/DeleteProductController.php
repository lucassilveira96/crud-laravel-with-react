<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Controller responsible for delete a product by ID.
 */
class DeleteProductController extends Controller
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
     * Update a product by ID.
     *
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Delete product by id",
     *     description="Delete product by id",
     *     operationId="deleteProduct",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Product",
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
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        try {
            $idProduct = (int) $request->route('id');
            if ($idProduct > 0) {
                $data = $this->productService->deleteProduct($idProduct);
                if ($data) {
                    return response()->json(
                        [
                            'data' => 'Deleted product',
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
