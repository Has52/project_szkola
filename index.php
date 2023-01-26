<?php

session_start(
    [
        'cookie_lifetime' => 86400,
        'gc_maxlifetime' => 86400,
    ]
);

if (!isset($_SESSION['username'])) {
    require __DIR__ . '/views/index.php';
} else {

    $request = $_SERVER['REQUEST_URI'];

    if ($pos = strpos($request, '?') !== false) {
        $request = substr($request, 0, $pos);
    }

    // remove trailing slash
    if ($request != '/' && substr($request, -1) == '/') {
        $request = substr($request, 0, -1);
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