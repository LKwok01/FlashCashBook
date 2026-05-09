<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $title = 'Home';
    return view('welcome', compact('title'));
});
