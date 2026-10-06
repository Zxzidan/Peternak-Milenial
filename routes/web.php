<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/pelatihan', function () {
    return view('pelatihan');
})->name('pelatihan');

Route::get('/marketplace', function () {
    return view('marketplace');
})->name('marketplace');

Route::get('/harga-komoditas', function () {
    return view('harga-komoditas');
})->name('harga-komoditas');

Route::get('/darurat', function () {
    return view('darurat');
})->name('darurat');

Route::get('/konsultasi', function () {
    return view('konsultasi');
})->name('konsultasi');

Route::get('/pameran', function () {
    return view('pameran');
})->name('pameran');
