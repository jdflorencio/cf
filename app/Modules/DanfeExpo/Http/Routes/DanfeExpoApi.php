<?php

use Illuminate\Http\Request;


Route::get('/danfe', 'DanfeExpoController@teste');
Route::post('/upload', 'DanfeExpoController@uploadXml');
