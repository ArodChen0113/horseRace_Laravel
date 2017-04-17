<?php

//View routes
Route::get('/','horseC@horseInsertShow');

Route::get('purchaseHotOrderV','orderC@purchaseHotOrderShow');

Route::get('testHTML', function () {
    return view('testHTML');
});
