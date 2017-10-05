<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Conversation;
use App\PrivateMessage;
use App\Notifications\UserFollowed;

class UsersController extends Controller
{
	public function show($username){
		$user =  $this->findByUsername($username);
		return view('user.show',compact('user'));
	}
	
	public function follow($username,Request $request){
		$user =  $this->findByUsername($username);
		$me = $request->user();
		$me->follows()->attach($user);
		$user->notify(new UserFollowed($me));
		return redirect('/'.$username)->withSuccess('Followed!');
	}
	public function unfollow($username,Request $request){
		$user =  $this->findByUsername($username);
		$me = $request->user();
		$me->follows()->detach($user);
		return redirect('/'.$username)->withDanger('Unfollowed!');
	}
	public function follows($username){
		$user =  $this->findByUsername($username);

		return view('user.follows',[
			'user' => $user, 
			'follows' => $user->follows,
		]);
	}
	public function followers($username,Request $request){
		$user = $this->findByUsername($username);
		return view('user.follows',[
			'user' => $user, 
			'follows' => $user->followers,
		]);
	}

	public function sendPrivateMessage($username,Request $request){
		$user  = $this->findByUsername($username);

		$me = $request->user();
		$message = $request->input('message');

		$conversation = Conversation::between($me,$user);

		// $conversation = Conversation::create();
		// $conversation->users()->attach($me);
		// $conversation->users()->attach($user);

		$privateMessage = PrivateMessage::create([
			'user_id' => $me->id,
			'message' => $message,
			'conversation_id' => $conversation->id,
		]);
		return redirect('/conversations/'.$conversation->id);
	}

	public function showConversation(Conversation $conversation){
		$conversation->load('users','privateMessages');
		return view('user.conversation',['conversation' => $conversation , 'user' => auth()->user()]);
	}
	private function findByUsername($username){
		return  User::where('username',$username)->firstOrFail();
	}
	public function notifications(Request $request){
		return $request->user()->notifications;
	}
}
