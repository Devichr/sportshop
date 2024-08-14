<?php

if (!function_exists('show_403')) {
    function show_403() {
        echo view('errors/html/error_403');
        exit;
    }
}
