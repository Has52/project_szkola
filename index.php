<?php

session_start(
    [
        'cookie_lifetime' => 86400,
        'gc_maxlifetime' => 86400,
    ]
);

$request = $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['username'])) {

    if ($request == '/' || $request == '/index.php') {
        require __DIR__ . '/views/index.php';
    } else {
        http_response_code(404);
        require __DIR__ . '/views/404.php';
    }

} else {
 
    if ($pos = strpos($request, '?') !== false) {
        $request = substr($request, 0, $pos);
    }

    switch ($request) {

        case '':
        case '/':
            require __DIR__ . '/views/index.php';
            break;
        
        case '/index.php':
            require __DIR__ . '/views/index.php';
            break;

        case '/logout':
            require __DIR__ . '/views/logout.php';
            break;

        default:
            http_response_code(404);
            require __DIR__ . '/views/404.php';
            break;
    }

}


?>