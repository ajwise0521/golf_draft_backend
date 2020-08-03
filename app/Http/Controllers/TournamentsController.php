<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentsController extends Controller
{
    public function getAvailableTournaments()
    {
    	return response()->json(Tournament::all());
    }
}
