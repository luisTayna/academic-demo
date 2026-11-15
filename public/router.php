<?php
// Only this explicitly authored stylesheet can be served as a static file.
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($path === '/demo.css') {
    header('Content-Type: text/css; charset=utf-8');
    readfile(__DIR__.'/demo.css');
    return true;
}
require __DIR__.'/index.php';
