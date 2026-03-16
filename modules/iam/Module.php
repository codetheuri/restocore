<?php
namespace iam;

/**
 * @license Apache 2.0
 */
/**
 * @OA\Info(
 *     description="API documentation for IAM module",
 *     version="1.0.0",
 *     title="IAM Module",
 *     @OA\Contact(
 *         email="theurij113@gmail.com",
 *         name="Joseph Theuri"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */ 

class Module extends \helpers\ApiModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'iam\controllers';
    public $name = 'IAM';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

    }
}

/**
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 * )
 */

/**
 * @OA\OpenApi(
 *   security={
 *      {
 *          "bearerAuth":{}
 *      }
 *   }
 * )
 */

/**
 * @OA\Tag(
 *     name="IAM",
 *     description="Endpoints for the IAM module"
 * )
 */

/**
 * @OA\Get(path="/about",
 *   summary="Module Info. ",
 *   tags={"IAM"},
 *   security={{}},
 *   @OA\Response(
 *     response=200,
 *     description="success",
 *      @OA\JsonContent(
 *          @OA\Property(property="data", type="array",@OA\Items(ref="#/components/schemas/About")),
 *          
 *      )
 *   ),
 * )
 */
/**
 *@OA\Schema(
 *  schema="About",
 *  @OA\Property(property="id", type="string",title="Module ID", example="IAM"),
 *  @OA\Property(property="name", type="string",title="Module Name", example="IAM Module"),
 * )
 */