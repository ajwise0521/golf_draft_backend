<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/get-players/{draft}/{user}', 'TournamentPlayersController@getAvailablePlayers');

Route::middleware('auth:api')->get('/league-members/{league}', 'LeagueMembersController@getLeagueMembers');


Route::middleware('auth:api')->get('draft/{draft}', 'DraftController@getDraft');
Route::middleware('auth:api')->post('draft-player/{draftPick}', 'DraftController@draftPlayer');
Route::middleware('auth:api')->get('drafts', 'DraftController@getDrafts');
Route::middleware('auth:api')->get('create-draft-order/{draft}', 'DraftController@createDraftOrder');
Route::middleware('auth:api')->get('current-pick/{draft}', 'DraftController@getCurrentDraftPick');
Route::middleware('auth:api')->get('players/{draft}/{user}', 'DraftController@getMemberDraftedPlayers');
Route::middleware('auth:api')->post('draft/create', 'DraftController@createDraft');

Route::middleware('auth:api')->get('user/leagues/{user}', 'LeaguesController@getUserLeagues');


Route::middleware('auth:api')->get('tournaments/available', 'TournamentsController@getAvailableTournaments');