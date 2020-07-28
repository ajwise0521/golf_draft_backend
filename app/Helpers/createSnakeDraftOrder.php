<?php

namespace App\Helpers;

use App\Models\Draft;
use App\Models\DraftPick;
use App\Models\LeagueMember;
class createSnakeDraftOrder {
	
	function getLeaguePlayers($leagueId) {
		$members = LeagueMember::where('league_id', $leagueId)->get()->toArray();

		return $members;
	}

	function createDraftOrder($numRounds, $tournamentId, $leagueId) {

		$members = $this->getLeaguePlayers($leagueId);

		$draft = new Draft();
		$draft->tournament_id = $tournamentId;
		$draft->save();

		$draftNumber = 1;
		for($i = 0; $i < $numRounds; $i++) {
			foreach($members as $member) {
				$draftPick = new DraftPick();
				$draftPick->draft_id = $draft->id;
				$draftPick->user_id = $member['id'];
				$draftPick->draft_pick = $draftNumber;
				$draftPick->save();
				$draftNumber++;
			}

			$members = array_reverse($members);
		}
	}
}