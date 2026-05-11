<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $title = 'Home';
    return view('welcome');
});
Route::get('/about', function () {
    $title = 'About Us';
    return view('welcome',compact('title'));
});
Route::get('/contact', function () {
    $title = 'Contact Us';
    return view('welcome',compact('title'));
});