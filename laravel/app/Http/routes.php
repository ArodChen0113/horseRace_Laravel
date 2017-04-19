<?php
//View routes
Route::get('/','horseRaceC@horseRaceShow');

Route::get('raceOverviewV','horseRaceC@raceOverviewShow');
Route::get('bsBettingOverviewV','horseRaceC@bsBettingOverviewShow');
Route::get('sdBettingOverviewV','horseRaceC@sdBettingOverviewShow');
Route::get('poBettingOverviewV','horseRaceC@poBettingOverviewShow');
Route::get('raceSurplusV','horseRaceC@raceSurplusShow');
Route::get('raceOddsV','horseRaceC@raceOddsShow');

Route::get('accountManageV','memberC@accountManageShow');
Route::get('accountStoredValueV','memberC@accountStoredValueShow');
Route::get('memberInsertV','memberC@memberInsertShow');
Route::get('memberManageV','memberC@memberManageShow');
Route::get('memberUpdateV','memberC@memberUpdateShow');

Route::get('horseInsertV','horseC@horseInsertShow');
Route::get('horseManageV','horseC@horseManageShow');
Route::get('horseUpdateV','horseC@horseUpdateShow');

Route::get('poIntroduceV','positionGameC@poIntroduceShow');
Route::get('poBettingV','positionGameC@poBettingShow');

Route::get('bsIntroduceV','bigOrSmallGameC@bsIntroduceShow');
Route::get('bsBettingV','bigOrSmallGameC@bsBettingShow');


Route::auth();

Route::get('/home', 'HomeController@index');
