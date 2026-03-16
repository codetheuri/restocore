<?php
return [
    /**
     * @OA\Post(
     *     path="/restaurant/orders/create",
     *     tags={"Orders"},
     *     summary="Submit a new order",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="phone_number", type="string", example="+254..."),
     *             @OA\Property(property="delivery_address", type="string", example="123 Street"),
     *             @OA\Property(property="payment_method", type="string", example="cash"),
     *             @OA\Property(property="notes", type="string", example="Extra spicy"),
     *             @OA\Property(property="items", type="array", @OA\Items(
     *                 @OA\Property(property="menu_id", type="integer", example=1),
     *                 @OA\Property(property="quantity", type="integer", example=2)
     *             ))
     *         )
     *     ),
     *     @OA\Response(response=201, description="Order created"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    'POST create' => 'create',

    /**
     * @OA\Get(
     *     path="/restaurant/orders/history",
     *     tags={"Orders"},
     *     summary="View order history",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Order history list")
     * )
     */
    'GET history' => 'history',

    /**
     * @OA\Get(
     *     path="/restaurant/orders/{id}",
     *     tags={"Orders"},
     *     summary="Get order status and details",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Order details"),
     *     @OA\Response(response=404, description="Order not found")
     * )
     */
    'GET {id}' => 'view',
];
