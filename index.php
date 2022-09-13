<?php


include 'template.php';
include 'router.php';



    Route::add('/', function () {
        include 'apps/musica/index.php';
    });

    // Accept only numbers as parameter. Other characters will result in a 404 error
    Route::add('/([a-z-0-9-]*)', function ($var1) {
        $dir = './apps';
        if (file_exists($dir . '/' . $var1 . '/index.php')) {
            include $dir . '/' . $var1 . '/index.php';
        } else {
            include 'error/404.php';
        }
    });

Route::run('/');
