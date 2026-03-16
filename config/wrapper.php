<?php
class ConfigWrapper
{
    public $_aliases;
    public $_modules;
    public $_tokens;
    public $_params;
    public function __construct()
    {
        $this->_aliases = [
            '@bower' => '@vendor/bower-asset',
            '@npm'   => '@vendor/npm-asset',
            '@helpers' => '@app/providers/components',
            '@coder' => '@app/providers/code',
            '@swagger' => '@app/providers/swagger',
            '@ui' => '@app/providers/interface',
            '@cmd' => '@app/providers/console',
            '@modules' => '@app/modules',
        ];
        $this->_modules = [
            'admin' => [
                'class' => 'mdm\admin\Module',
                'controllerMap' => [
                    'assignment' => [
                        'class' => 'mdm\admin\controllers\AssignmentController',
                        /* 'userClassName' => 'app\models\User', */
                        'idField' => 'user_id',
                        'usernameField' => 'username',
                        //'searchClass' => 'app\models\UserSearch'
                    ],
                ],
            ]
        ];
        $this->_tokens = [
            '{id}' => '<id:\\d[\\d,]*>',
            '{key}' => '<key:[a-zA-Z0-9_\-\/]+>',
            '{crypt_id}' => '<crypt_id:[a-zA-Z0-9\\-]+>',
        ];
        //    $this->_tokens = [
        //     '{uid}' => '<uid:\\d[\\d,]*>',
        //     '{id}' => '<id:[a-zA-Z0-9\\-]+>',
        //     '{username}' => '<username:[a-zA-Z0-9\\-]+>',
        //     '{type}' => '<type:[a-zA-Z0-9\\-]+>',
        // ];
        $this->_params = [
            'pageSize' => [10 => 10, 25 => 25, 50 => 50, 100 => 100],
            'pageSizeLimit' => 100,
            'defaultPageSize' => 25,
            'activateAuth' => true,
            'allowedDomains' => (isset($_SERVER['APP_SAFE_DOMAINS'])) ? explode(',', $_SERVER['APP_SAFE_DOMAINS']) : ['*'],
            'safeEndpoints' => ['login', 'docs', 'json-docs', 'register', 'categories', 'menu', 'search', 'offers', 'view'],
        ];
    }
    // public function load($item)
    // {
    //     $wrapper = [];
    //     $wrapper['aliases'] = $this->_aliases;
    //     $wrapper['modules'] = $this->_modules;
    //     $wrapper['params'] = $this->_params;
    //     foreach (new DirectoryIterator(dirname(__DIR__) . '/modules') as $index => $fileinfo) {
    //         if ($fileinfo->isDir() && !$fileinfo->isDot()) {
    //             $wrapper['aliases']['@' . $fileinfo->getFilename()] = '@app/modules/' . $fileinfo->getFilename();
    //             $wrapper['migrationPaths'][] = '@' . $fileinfo->getFilename() . '/migrations';
    //             if ($fileinfo->getFilename() !== 'website') {
    //                 $wrapper['modules'][$fileinfo->getFilename()] = [
    //                     'class' => $fileinfo->getFilename() . '\\Module'
    //                 ];
    //             }
    //         }
    //     }
    //     return $wrapper[$item];
    // }
    public function load($item)
    {
        $wrapper = $routes = [];
        $wrapper['aliases'] = $this->_aliases;
        $wrapper['modules'] = $this->_modules;
        $wrapper['tokens'] = $this->_tokens;
        $wrapper['params'] = $this->_params;
        foreach (new DirectoryIterator(dirname(__DIR__) . '/modules') as $index => $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                $moduleName = $fileinfo->getFilename();
                $wrapper['aliases']['@' . $moduleName] = '@app/modules/' . $moduleName;

                // Dynamically discover controllers in this module if it has routers (API module)
                $routerPath = dirname(__DIR__) . '/modules/' . $moduleName . '/routers';
                $controllerPath = dirname(__DIR__) . '/modules/' . $moduleName . '/controllers';
                if ($moduleName !== 'dashboard' && is_dir($routerPath) && is_dir($controllerPath)) {
                    foreach (new DirectoryIterator($controllerPath) as $ctrFile) {
                        if ($ctrFile->isFile() && $ctrFile->getExtension() === 'php') {
                            $className = $ctrFile->getBasename('.php');
                            $ctrId = strtolower(preg_replace('/Controller$/', '', $className));
                            if ($ctrId === 'default') {
                                $wrapper['controllers'][$moduleName] = $moduleName . '/default';
                            } else {
                                $wrapper['controllers'][$moduleName . '/' . $ctrId] = $moduleName . '/' . $ctrId;
                            }
                        }
                    }
                }

                $wrapper['migrationPaths'][] = '@' . $moduleName . '/migrations';
                if ($moduleName !== 'main') {
                    $wrapper['modules'][$moduleName] = [
                        'class' => $moduleName . '\\Module'
                    ];
                    if ($moduleName !== 'dashboard') {
                        $dir = dirname(__DIR__) . "/modules/" . $moduleName . "/routers";
                        foreach (glob("{$dir}/*.php") as $filename) {
                            $route = require($filename);
                            $routes = array_merge($routes, $route);
                        }
                        $wrapper['routes'] = $routes;
                    }
                }

                // Add to API Docs menu if module has a $name property
                $moduleClass = '\\' . $moduleName . '\\Module';
                if (class_exists($moduleClass) && property_exists($moduleClass, 'name')) {
                    // Try to get name without full instantiation if possible, or use a dummy instance
                    try {
                        $reflect = new \ReflectionClass($moduleClass);
                        $props = $reflect->getDefaultProperties();
                        $moduleTitle = isset($props['name']) ? $props['name'] : $moduleName;
                    } catch (\Throwable $e) {
                        $moduleTitle = $moduleName;
                    }

                    $wrapper['apiMenus'][] = [
                        'title' => strtoupper($moduleTitle),
                        'url' => 'site/docs',
                        'param' => ['mod' => $moduleName]
                    ];
                }
            }
        }
        if (!empty($wrapper['apiMenus'])) {
            $wrapper['apiMenus'] = [['title' => 'API Docs', 'icon' => 'code', 'submenus' => $wrapper['apiMenus']]];
        }
        return $wrapper[$item];
    }
    public function dbDriver($selector = null)
    {
        $connection = [
            'class' => 'yii\db\Connection',
        ];
        switch ($_SERVER[$selector . '_DRIVER']) {
            case "mssql":
                $connection = array_merge($connection, [
                    'driverName' => 'sqlsrv',
                    'dsn' => "sqlsrv:Server={$_SERVER[$selector . '_HOST']};Database={$_SERVER[$selector . '_DATABASE']}",
                ]);
                break;
            case "pgsql":
                $connection = array_merge($connection, [
                    'dsn' => "pgsql:host={$_SERVER[$selector . '_HOST']};port={$_SERVER[$selector . '_PORT']};dbname={$_SERVER[$selector . '_DATABASE']}",
                ]);
                break;
            default: // mysql
                $connection = array_merge($connection, [
                    'dsn' => "mysql:host={$_SERVER[$selector . '_HOST']};port={$_SERVER[$selector . '_PORT']};dbname={$_SERVER[$selector . '_DATABASE']}",
                ]);
        }
        $connection = array_merge($connection, [
            'username' => $_SERVER[$selector . '_USERNAME'],
            'password' => $_SERVER[$selector . '_PASSWORD'],
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ]);
        return $connection;
    }
}
