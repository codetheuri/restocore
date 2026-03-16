<?php

namespace restaurant;

/**
 * @OA\Info(
 *     description="API documentation for Restaurant module",
 *     version="1.0.0",
 *     title="Restaurant Module",
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
    public $controllerNamespace = 'restaurant\controllers';
    public $name = 'Restaurant';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
