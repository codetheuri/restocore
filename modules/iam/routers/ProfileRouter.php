<?php
return [
    /**
     * @OA\Get(
     *     path="/iam/profile",
     *     tags={"Profile"},
     *     summary="Fetch current user's profile details",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="dataPayload", type="object",
     *                 @OA\Property(property="data", type="object",
     *                     @OA\Property(property="user_id", type="string"),
     *                     @OA\Property(property="username", type="string"),
     *                     @OA\Property(property="profile", type="object",
     *                         @OA\Property(property="first_name", type="string"),
     *                         @OA\Property(property="last_name", type="string"),
     *                         @OA\Property(property="mobile_number", type="string"),
     *                         @OA\Property(property="physical_address", type="string")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    'GET ' => 'index',

    /**
     * @OA\Put(
     *     path="/iam/profile/update",
     *     tags={"Profile"},
     *     summary="Update current user's profile",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProfileUpdate")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="dataPayload", type="object",
     *                 @OA\Property(property="data", type="object"),
     *                 @OA\Property(property="alertify", type="object")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    'PUT update' => 'update',
];
