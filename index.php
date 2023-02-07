<?php

session_start(
    [
        'cookie_lifetime' => 86400,
        'gc_maxlifetime' => 86400,
    ]
);

$request = $_SERVER['REQUEST_URI'];
$path = '/BartosikK/Projekt/';
$con = new mysqli("localhost","root","","mecze");

if (!isset($_SESSION['username'])) {

    if ($request == $path  . '/' || $request == $path || $request == $path  . 'index.php') {
        require __DIR__ . '/views/index.php';
    } else {
        http_response_code(404);
        require __DIR__ . '/views/404.php';
    }

} else {
 
    if ($pos = strpos($request, '?') !== false) {
        $request = substr($request, 0, $pos);
    }


    if (dirname($request) == $path . 'api') {
        require $_SERVER['DOCUMENT_ROOT'] . $request;
        return;
    }

    switch ($request) {

        case '/':
        case $path . '':
        case $path . '/':
            require __DIR__ . '/views/index.php';
            break;
        
        case $path . 'index.php':
            require __DIR__ . '/views/index.php';
            break;

        case $path . 'logout':
            require __DIR__ . '/views/logout.php';
            break;

        default:
            http_response_code(404);
            require __DIR__ . '/views/404.php';
            break;
    }

}

        $con->close();

?>