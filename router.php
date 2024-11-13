<?php
    require_once "libs/router.php";
    require_once "app/controllers/clubes.controller.php";
    require_once "app/controllers/user.controller.php";
    require_once "app/middlewares/middleware.jwt.php";

    $router=new Router();

    $router->addMiddleware(new JWTmiddleware());

    $router->addRoute('clubes','GET','ClubController','getAll');
    $router->addRoute("clubes/:id","GET","ClubController","get");
    $router->addRoute("clubes","POST","ClubController","add");
    $router->addRoute("clubes/:id","DELETE","ClubController","delete");
    $router->addRoute("clubes/:id","PUT","ClubController","update");

    $router->addRoute("token",'GET','UserController','getToken');

    $router->route($_GET['resource'],$_SERVER['REQUEST_METHOD']);