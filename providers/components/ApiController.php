<?php
namespace helpers;

use Yii;
use yii\filters\Cors;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use helpers\iam\SessionAuth;

/**
 * ApiController is the base controller for REST API endpoints in RestoCore.
 * It provides standardized response formatting matching the Dukapal project.
 */
class ApiController extends \yii\rest\Controller
{
    use \helpers\traits\Keygen;
    use \helpers\traits\Dropdown;

    public $enableCsrfValidation = false;
    
    public function init() {
        parent::init();
        // Enable session for Swagger/Browser access if needed
        Yii::$app->user->enableSession = true;
    }

    public function behaviors() {
        $auth     = isset(Yii::$app->params['activateAuth']) ? Yii::$app->params['activateAuth'] : FALSE;
        $origins  = isset(Yii::$app->params['allowedDomains']) ? Yii::$app->params['allowedDomains'] : "*";
        
        $behaviors = parent::behaviors();
        
        // Remove default authenticator
        unset($behaviors['authenticator']);

        // Configure CORS
        // If Origin is *, credentials must be false to avoid yii\base\InvalidConfigException
        $allowCredentials = true;
        // if ($origins === '*') {
        //     $allowCredentials = false;
        // }

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors'  => [
                'Origin'                           => (array)$origins,
                'Access-Control-Allow-Origin'      => (array)$origins,  
                'Access-Control-Request-Headers'   => ['*'],         
                'Access-Control-Request-Method'    => ['POST', 'PUT', 'PATCH', 'GET', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => $allowCredentials,
                'Access-Control-Max-Age'           => 3600,                
                'Access-Control-Allow-Headers'     => ['Authorization', 'Content-Type', 'X-Requested-With'],
                'Access-Control-Expose-Headers'    => ['X-Pagination-Total-Count', 'X-Pagination-Page-Count'],
            ],
        ]; 

        if($auth){
            $behaviors['authenticator'] = [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                    SessionAuth::class, // Support session-based auth for browser/Swagger access
                ],
            ];

            $behaviors['authenticator']['except'] = Yii::$app->params['safeEndpoints'] ?? ['login', 'docs', 'json-docs', 'register'];
        }
        
        return $behaviors;
    }

    /**
     * Standardized error response matching Dukapal
     * 
     * @param int|array $errors HTTP status code or validation errors array
     * @param array|false $acidErrors Additional model errors to include
     * @param string|false $message Custom error message
     * @return array Formatted error response
     */
    public function errorResponse($errors, $acidErrors = false, $message = false): array
    {
        // Handle HTTP status code errors (e.g. 401, 404)
        if (!is_array($errors)) {
            Yii::$app->response->statusCode = $errors;
            $payload = $this->getErrorPayload($errors);
            if ($message) {
                $payload['errors']['message'] = $message;
            }
            return ['errorPayload' => $payload];
        }

        // Handle validation errors (422)
        Yii::$app->response->statusCode = 422;
        $formattedErrors = [];
        foreach ($errors as $key => $value) {
            $formattedErrors[$key] = is_array($value) ? $value[0] : $value;
        }

        // Append additional model errors if provided (acidErrors)
        if (is_array($acidErrors)) {
            // Check if it's the old restocore format or dukapal format
            if (isset($acidErrors['acidErrorModel'])) {
                // Old restocore format
                foreach ($acidErrors['acidErrorModel'] as $key => $model) {
                    foreach ($model->getErrors() as $k => $errs) {
                        $formattedErrors[$acidErrors['errorKey']][$key][$k] = $errs[0];
                    }
                }
            } else {
                // Dukapal format
                foreach ($acidErrors as $modelKey => $models) {
                    foreach ($models as $index => $model) {
                        if (method_exists($model, 'hasErrors') && $model->hasErrors()) {
                            $formattedErrors[$modelKey][$index] = $model->getErrors();
                        }
                    }
                }
            }
        }

        $payload = ['errors' => $formattedErrors];

        if ($message) {
            $payload = array_merge($payload, $this->alertifyResponse([
                'message' => $message,
                'theme'   => 'danger',
                'statusCode' => 422
            ])['alertifyPayload']);
        }

        return ['errorPayload' => $payload];
    }

    /**
     * Standardized success response with data matching Dukapal
     * 
     * @param mixed $data Response data (model, array, or DataProvider)
     * @param array $options Response options (statusCode, oneRecord, message, theme)
     * @return array Formatted data response
     */
    public function payloadResponse($data, array $options = []): array
    {
        $options = array_merge([
            'statusCode' => 200,
            'oneRecord'  => true,
            'message'    => false,
            'theme'      => 'success',
        ], $options);

        Yii::$app->response->statusCode = $options['statusCode'];

        // Handle paginated data providers
        if (!$options['oneRecord'] && $data instanceof \yii\data\DataProviderInterface) {
            $payload = [
                'data' => $data->getModels() ?: [],
            ];

            if ($data->pagination !== false) {
                $payload = array_merge($payload, [
                    'countOnPage'    => $data->count,
                    'totalCount'     => $data->totalCount,
                    'perPage'        => $data->pagination->pageSize,
                    'totalPages'     => $data->pagination->pageCount,
                    'currentPage'    => $data->pagination->page + 1,
                    'paginationLinks' => $data->pagination->getLinks(false),
                ]);
            } else {
                $payload = array_merge($payload, [
                    'totalCount' => $data->totalCount,
                ]);
            }

            return ['dataPayload' => $payload];
        }

        // Handle single record or simple data
        $response = ['dataPayload' => ['data' => $data]];

        // Add alertify notification if message provided
        if ($options['message']) {
            $response['dataPayload']['alertify'] = $this->alertifyResponse($options)['alertifyPayload'];
        }

        return $response;
    }

    /**
     * Generate alertify notification response matching Dukapal
     */
    public function alertifyResponse(array $options = []): array
    {
        $defaults = [
            'statusCode' => 200,
            'theme'      => 'info',      // info, success, warning, danger
            'type'       => 'alert',     // alert, notify, confirm
            'message'    => null,
        ];

        $options = array_merge($defaults, $options);
        Yii::$app->response->statusCode = $options['statusCode'];

        unset($options['statusCode']);
        if (isset($options['oneRecord'])) {
            unset($options['oneRecord']);
        }

        return [
            'alertifyPayload' => $options,
        ];
    }

    /**
     * Get error message payload for HTTP status code
     */
    protected function getErrorPayload($code): array
    {
        $codes = [
            '400' => ['message' => 'Bad Request'],
            '401' => ['message' => 'Unauthorized'],
            '403' => ['message' => 'Forbidden'],
            '404' => ['message' => 'Not Found'],
            '422' => ['message' => 'Validation Failed'],
            '440' => ['message' => 'Session Expired'],
            '500' => ['message' => 'Server Error'],
        ];

        return ['errors' => $codes[$code] ?? $codes['500']];
    }

    /**
     * Query parameters cleanup (restocore specific)
     */
    public function queryParameters($query, $modelId) {   
        if(!$query){
            $data = null;
        }
        foreach($query as $key=>$value){
            if(substr($key,0,1) == '_'){
                $data[$modelId][ltrim($key,"_")]=$value;
            }else{
                $data[$key]=$value;
            }
        }
        return $data;
    }

    public function baseUrl(): string
    {
        return \yii\helpers\Url::base(true);
    }
}