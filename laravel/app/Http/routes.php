<?php
//View routes
Route::get('/','horseRaceC@horseRaceShow');

Route::get('raceOverviewV','horseRaceC@raceOverviewShow');
Route::get('raceSurplusV','horseRaceC@raceSurplusShow');
Route::get('raceOddsV','horseRaceC@raceOddsShow');

Route::get('accountManageV','memberC@accountManageShow');
Route::get('accountStoredValueV','memberC@accountStoredValueShow');
Route::get('memberInsertV','memberC@memberInsertShow');
Route::get('memberManageV','memberC@memberManageShow');
Route::get('memberUpdateV','memberC@memberUpdateShow');

Route::get('horseIntroduceV','horseC@horseIntroduceShow');
Route::get('horseInsertV','horseC@horseInsertShow');
Route::get('horseManageV','horseC@horseManageShow');
Route::get('horseUpdateV','horseC@horseUpdateShow');

Route::get('poIntroduceV','positionGameC@poIntroduceShow');
Route::get('poBettingV','positionGameC@poBettingShow');
Route::get('poBettingOverviewV','positionGameC@poBettingOverviewShow');

Route::get('bsIntroduceV','bigOrSmallGameC@bsIntroduceShow');
Route::get('bsBettingV','bigOrSmallGameC@bsBettingShow');
Route::get('bsBettingOverviewV','bigOrSmallGameC@bsBettingOverviewShow');

//Controller routes
Route::post('action_member', 'memberC@memberActionControl');
Route::get('action_memberDel', 'memberC@memberActionControlDel');
Route::post('action_horse', 'horseC@horseActionControl');
Route::get('action_horseDel', 'horseC@horseActionControlDel');
Route::post('action_horseRace', 'horseRaceC@horseRaceActionControl');
Route::get('action_open', 'horseRaceC@openActionControl');

//Authority
Route::auth();
Route::get('noAuthV', 'Controller@authUrl');
Route::get('limitActionV', 'Controller@limitActionUrl');
Route::get('limitAccountV', 'Controller@limitAccountUrl');

//Test
Route::get('testHTML','testC@testF');