<?php

namespace app\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

/**
 * Controller responsible for retrieving one product by ID.
 */
class GetOneProductController extends Controller
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
     * Retrieves one product by ID.
     *
     * @OA\Get(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Get one products by id",
     *
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *
     *     @OA\Response(response="200", description="Get one product by id"),
     * )
     */
    public function __invoke(Request $request)
    {
        try {
            $data = $this->productService->getProduct($request->route('id'));

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
