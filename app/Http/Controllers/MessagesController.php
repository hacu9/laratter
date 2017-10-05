<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Http\Requests\CreateMessageRequest;

class MessagesController extends Controller
{
	public function show(Message $message){
		// $message = Message::FindOrFail();
		return view('messages.show',compact('message'));
	}
	public function create(CreateMessageRequest $request){
		$user = $request->user();
		$image = $request->file('image');

		$message = Message::create([
			'user_id' => $user->id,
			'content' => $request->input('message'),
			'image' => $image->store('messages','public')
		]);
		return redirect('/messages/'.$message->id);
	}
	public function search(Request $request){
		$query = $request->input('query');
		$messages = Message::search($query)->get();
		$messages->load('user');
		// $messages = Message::with('user')->search($query)->get();
		// where('content','LIKE',"%$query%")->
		// return view('messages.index',compact('messages')
		return view('messages.index', [
			'messages' => $messages,
		]);
	}
	public function responses(Message $message){
		return $message->responses->load('user');
	}
}
