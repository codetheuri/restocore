<?php
return [
    /**
     * @OA\Get(
     *     path="/restaurant/menu/categories",
     *     tags={"Restaurant"},
     *     summary="List food categories",
     *     security={{}},
     *     @OA\Response(
     *         response=200, 
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="dataPayload", type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *             )
     *         )
     *     )
     * )
     */
    'GET categories' => 'categories',

    /**
     * @OA\Get(
     *     path="/restaurant/menu/menu",
     *     tags={"Restaurant"},
     *     summary="List all food items",
     *     security={{}},
     *     @OA\Parameter(name="category_id", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200, 
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="dataPayload", type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *             )
     *         )
     *     )
     * )
     */
    'GET menu' => 'menu',

    /**
     * @OA\Get(
     *     path="/restaurant/menu/{id}",
     *     tags={"Restaurant"},
     *     summary="Get specific food item details",
     *     security={{}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    'GET {id}' => 'view',

    /**
     * @OA\Get(
     *     path="/restaurant/menu/search",
     *     tags={"Restaurant"},
     *     summary="Filter menu items by name",
     *     security={{}},
     *     @OA\Parameter(name="query", in="query", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    'GET search' => 'search',

    /**
     * @OA\Get(
     *     path="/restaurant/menu/offers",
     *     tags={"Restaurant"},
     *     summary="Fetch promotional banners/offers",
     *     security={{}},
     *     @OA\Response(response=200, description="Success")
     * )
     */
    'GET offers' => 'offers',
];
