<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\NewProductRequest;
use App\Services\Product\ProductService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Controller responsible for updating a product by ID.
 */
class UpdateProductController extends Controller
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
     * @OA\Patch(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Update product by id",
     *     description="Update product by id",
     *     operationId="updateProduct",
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
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="product_category_id",
     *                 type="integer",
     *                  format="int64",
     *                 example="1"
     *             ),
     *             @OA\Property(
     *                 property="product_name",
     *                 type="string",
     *                 example="mouse gamer usado"
     *             ),
     *             @OA\Property(
     *                 property="product_value",
     *                 type="float",
     *                 example="108.95"
     *             )
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
     *                 property="product_category_id",
     *                 type="integer",
     *                  format="int64",
     *                 example="1"
     *             ),
     *             @OA\Property(
     *                 property="product_name",
     *                 type="string",
     *                 example="mouse gamer usado"
     *             ),
     *             @OA\Property(
     *                 property="product_value",
     *                 type="float",
     *                 example="108.95"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function __invoke(NewProductRequest $request)
    {
        try {
            $idProduct = (int) $request->route('id');
            if ($idProduct > 0) {
                $data = $this->productService->updateProduct($idProduct, $request->validated());

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
