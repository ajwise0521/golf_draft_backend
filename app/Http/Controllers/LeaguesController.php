<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class LeaguesController extends Controller
{
    public function getUserLeagues(User $user)
    {
    	return $user->Leagues->makeHidden('User');
    }
}
