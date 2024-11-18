<?php
    require_once 'libs/router.php';
    require_once 'api/controllers/AerolineasApiController.php';
    require_once 'api/controllers/PersonasApiController.php';
    require_once 'api/controllers/UserApiController.php';
    require_once 'api/middlewares/jwt.auth.middlewares.php';

    $router = new Router();

    $router->addMiddleware(new JWTAuthMiddleware());

    $router->addRoute('aerolinea', 'GET', 'AerolineasApiController','getAllAerolineas');
    $router->addRoute('aerolinea/:id', 'GET', 'AerolineasApiController','getAerolinea');
    $router->addRoute('aerolinea/:id','DELETE', 'AerolineasApiController','delete');
    $router->addRoute('aerolinea','POST', 'AerolineasApiController','create');
    $router->addRoute('aerolinea/:id', 'PUT', 'AerolineasApiController', 'edit');

    $router->addRoute('persona', 'GET', 'PersonasApiController','getAllPersona');
    $router->addRoute('persona/:id', 'GET', 'PersonasApiController','getPersona');
    $router->addRoute('persona/:id','DELETE', 'PersonasApiController','delete');
    $router->addRoute('persona','POST', 'PersonasApiController','create');
    $router->addRoute('persona/:id', 'PUT', 'PersonasApiController', 'edit');

    $router->addRoute('usuarios/token', 'GET', 'UserApiController', 'getToken');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

?>