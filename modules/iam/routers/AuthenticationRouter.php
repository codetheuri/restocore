<?php
return [
    /**
     * @OA\Post(
     * path="/iam/auth/register",
     * summary="Register",
     * description="Register a new user account",
     * security={{}},
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide Username & Password",
     *    @OA\JsonContent(
     *       required={"first_name","last_name","email_address","mobile_number","username","password","confirm_password"},
     *       @OA\Property(property="first_name", type="string", example="John"),
     *       @OA\Property(property="middle_name", type="string", example="Michael", nullable=true),
     *       @OA\Property(property="last_name", type="string", example="Doe"),
     *       @OA\Property(property="email_address", type="string", format="email", example="john.doe@example.com"),
     *       @OA\Property(property="mobile_number", type="string", example="+2541700000000"),
     *       @OA\Property(property="username", type="string", example="johndoe"),
     *       @OA\Property(property="password", type="string", format="password", example="@dmiN1234$"),
     *       @OA\Property(property="confirm_password", type="string", format="password", example="@dmiN1234$")
     *    ),
     * ),
     * @OA\Response(response=201, description="Successful Operation"),
     * @OA\Response(response=422, description="Validation Error")
     *),
     */
    'POST register' => 'register',

    /**
     * @OA\Post(
     * path="/iam/auth/login",
     * summary="Login",
     * description="Authenticate user and generate access token",
     * security={{}},
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"username","password"},
     *       @OA\Property(property="username", type="string", example="admin"),
     *       @OA\Property(property="password", type="string", example="@dmiN123"),
     *    ),
     * ),
     * @OA\Response(response=200, description="Login Successful")
     *),
     */
    'POST login' => 'login',

    /**
     * @OA\Get(
     *     path="/iam/auth/me",
     *     tags={"Authentication"},
     *     summary="Logged In User",
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    'GET me' => 'me',

    /**
     * @OA\Post(
     * path="/iam/auth/refresh",
     * tags={"Authentication"},
     * summary="Refresh Token",
     * @OA\Response(response=200, description="Token Refreshed")
     *),
     */
    'POST refresh' => 'refresh',

    /**
     * @OA\Post(
     * path="/iam/auth/logout",
     * tags={"Authentication"},
     * summary="Logout",
     * @OA\Response(response=200, description="Logged Out")
     *),
     */
    'POST logout' => 'logout',
];
