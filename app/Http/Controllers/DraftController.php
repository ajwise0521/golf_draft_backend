<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Models\Draft;
use App\Models\DraftPick;
use Illuminate\Http\Request;
use App\Events\PlayerDrafted;

class DraftController extends Controller
{

	public function getDraft(Draft $draft, Request $request) 
	{
		return response()->json($draft);
	}

	function getCurrentDraftPick(Draft $draft, Request $request) 
	{
		$currentPick = DraftPick::whereNull('player_id')
			->where('draft_id', $draft->id)
			->orderBy('draft_pick')
			->with('Player')
			->first();
		return response()->json($currentPick);
	}

	function draftPlayer(DraftPick $draftPick, Request $request) {
		$draftPick->player_id = $request->id;
		$draftPick->save();

		event(new PlayerDrafted($request->name . ' has been drafted by ' . $request->user()->name));

		return response()->json('success', 200);
	}


	public function getDrafts(Request $request)
	{
		return response()->json(Draft::available()->get());
	}

	public function createDraftOrder(Draft $draft, Request $request) 
	{	
		$leagueMembers = $draft->LeagueMembers->shuffle();
		$pick = 1;
		for($round = 1; $round <= $draft->player_count; $round++) {
			foreach($leagueMembers as $leagueMember) {
				$draftPick = new DraftPick();
				$draftPick->draft_id = $draft->id;
				$draftPick->user_id = $leagueMember->user_id;
				$draftPick->draft_pick = $pick;
				$draftPick->save();
				$pick++;
			}
			$leagueMembers = $leagueMembers->reverse();
		}
		return response()->json('success');
	}

	public function getFinishedDraftPicks(Draft $draft, Request $request) 
	{
		$draftPicks = DraftPick::whereNotNull('player_id')
			->where('draft_id', $draft->id)
			->orderBy('draft_pick', 'DESC')
			->with('Player')
			->get();
	}

	public function getMemberDraftedPlayers(Draft $draft, User $user, Request $request) 
	{
		return response()->json(DraftPick::where('draft_id', $draft->id)->where('user_id', $user->id)->orderBy('draft_pick')->with('Player')->get());
	}

	public function createDraft(Request $request) {
		\Log::debug('request', (array)$request->all());
		$draft = new Draft();
		// $draft
	}
}
