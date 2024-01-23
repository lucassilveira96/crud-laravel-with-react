<?php

namespace app\Http\Controllers\ProductCategory;

use App\Http\Controllers\Controller;
use App\Services\ProductCategory\ProductCategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

/**
 * Controller responsible for retrieving one product category by ID.
 */
class GetOneProductCategoryController extends Controller
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
     * Retrieves one product by ID.
     *
     * @OA\Get(
     *     path="/api/product/categories/{id}",
     *     tags={"Product Categories"},
     *     summary="Get one product category by id",
     *
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *
     *     @OA\Response(response="200", description="Get one product category by id"),
     * )
     */
    public function __invoke(Request $request)
    {
        try {
            $data = $this->productCategoryService->getProductCategory($request->route('id'));

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
