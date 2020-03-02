<?php

$request = $_SERVER['REQUEST_URI'];
print_r($request);
if($request=='/api/detect')
{
    $method = $_SERVER['REQUEST_METHOD'];
    require __DIR__ . "/api/detectAPI.php?method=abc";
    exit(0);
}
else
{
    switch ($request) {
        case '/' :
            require __DIR__ . '/views/index.php';
            break;
        case '' :
            require __DIR__ . '/views/index.php';
            break;    
        case '/about' :
            require __DIR__ . '/views/about.php';
            break;
        default:
            http_response_code(404);
            require __DIR__ . '/views/404.php';
            break;
    }
}