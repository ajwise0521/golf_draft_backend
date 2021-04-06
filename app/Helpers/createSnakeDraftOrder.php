<?php

namespace App\Helpers;

use App\Models\Draft;
use App\Models\DraftPick;
use App\Models\LeagueMember;
class createSnakeDraftOrder {
	
	function getLeaguePlayers($leagueId) {
		$members = LeagueMember::where('league_id', $leagueId)->whereNull('deleted_at')->inRandomOrder()->get()->toArray();

		return $members;
	}

	function createDraftOrder($numRounds, $tournamentId, $leagueId) {


		print('randomizing Draft order' . PHP_EOL);
		$members = $this->getLeaguePlayers($leagueId);

		$draft = new Draft();
		$draft->tournament_id = $tournamentId;
		$draft->league_id = $leagueId;
		$draft->save();

		$draftNumber = 1;
		for($i = 0; $i < $numRounds; $i++) {
			foreach($members as $member) {
				$draftPick = new DraftPick();
				$draftPick->draft_id = $draft->id;
				$draftPick->user_id = $member['user']['id'];
				$draftPick->draft_pick = $draftNumber;
				$draftPick->save();
				$draftNumber++;
			}

			$members = array_reverse($members);
		}

		$membersCount = count($members);

		$picks = DraftPick::where('draft_id', $draft->id)->orderBy('draft_pick')->limit($membersCount)->get();

		foreach($picks as $pick) {
			print($pick->draft_pick . '. ' . $pick->userName . PHP_EOL);
		}
	}
}