<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\NewProductRequest;
use App\Services\Product\ProductService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

/**
 * Controller responsible for creating a new product.
 */
class NewProductController extends Controller
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
     * Create a new product.
     *
     * @OA\Post(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Create one product",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *             required={"product_category_id", "product_name", "product_value"},
     *
     *             @OA\Property(property="product_category_id", type="integer", example="1"),
     *             @OA\Property(property="product_name", type="string", example="mouse gamer"),
     *             @OA\Property(property="product_value", type="float", example="105.50")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response="201",
     *         description="Produto cadastrado com sucesso",
     *     ),
     * )
     */
    public function __invoke(NewProductRequest $request)
    {
        try {
            $data = $this->productService->createProduct($request->validated());

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
