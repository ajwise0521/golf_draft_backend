<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	//if the proper account is found, sign the user in with Google
	function signInWithGoogle(Request $request) {
		$user = User::where('google_id', $request->input('googleId'))->first();
		if($user) {
			$user->is_signed_in = 1;
			$user->save();
			return response()->json([
				'success' => true,
				'user_id' => $user->id
			]);
		}

		return response()->json([
				'success' => false,
		]);
	}

	function signOutOfGoogle(Request $request) {
		$user = User::where('google_id', $request->input('googleId'))->first();

		if($user) {
			$user->is_signed_in = 0;
			$user->save();
		}

		return response()->json(true);
	}

	function createUser(Request $request) 
	{

		$newUser = new User();

		$newUser->email = $request->input('email');
		$newUser->name = $request->input('name');
		$newUser->google_id = $request->input('googleId');
		$newUser->is_signed_in = 1;

		$newUser->save();
	}

	public function login(Request $request) {
		$credentials = $request->only('email', 'password');
		if(Auth::attempt($credentials)) {
			return response()->json([
				'authenticate' => true,
				'name' => Auth::user()->name,
				'access_token' => Auth::user()->api_token,
				'user_id' => Auth::user()->id
			]);
		}

		return response()->json([
			'authenticate' => false,
		], 200);
	}
}
