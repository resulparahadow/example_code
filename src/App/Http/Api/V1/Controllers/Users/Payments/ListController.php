<?php

namespace App\Http\Api\V1\Controllers\Users\Payments;

use App\Http\Api\V1\Controllers\Controller;
use App\Http\Api\V1\Resources\PaginatorCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = currentUser();

        $payments = $user->bankPayments()->whereHas('payment')->with('payment')->paginate();

        $results = PaginatorCollection::collection($payments)->response()->getData(true);

        return $this->response($results['data']);
    }
}
/**
 * @OA\Get(
 *     path="payments",
 *     operationId="PaymentsList",
 *     tags={"Payments"},
 *     summary="Display a listing of payments",
 *     security={
 *       {"bearer_token": {}},
 *     },
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="The page number",
 *         required=false,
 *         @OA\Schema(
 *             type="integer",
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="List of payments created by client",
 *         @OA\JsonContent(
 *          @OA\Property(
 *            property="success",
 *            title="status",
 *            type="boolean",
 *            description="result status"
 *           ),
 *           @OA\Property(
 *              property="data",
 *              title="Data",
 *              type="array",
 *              description="list of entity",
 *              @OA\Items(
 *               @OA\Property(
 *                property="id",
 *                title="Payment Id",
 *                type="integer",
 *                description="Payment Id",
 *                example="1"
 *               ),
 *               @OA\Property(
 *                property="state",
 *                ref="#components/schemas/PaymentStateBank",
 *               ),
 *               @OA\Property(
 *                property="service",
 *                ref="#components/schemas/ServicesEnum"
 *               ),
 *               @OA\Property(
 *                property="service_type",
 *                ref="#components/schemas/ServicesTypeEnum"
 *                ),
 *               @OA\Property(
 *                property="amount",
 *                type="string",
 *                description="Payment amount",
 *                example="12",
 *              ),
 *             ),
 *           ),
 *           @OA\Property(
 *             property="meta",
 *             ref="#/components/schemas/PaginatorMeta"
 *           ),
 *           @OA\Property(
 *             property="links",
 *             ref="#/components/schemas/PaginatorLinks"
 *           )
 *         )
 *     ),
 * )
*/
