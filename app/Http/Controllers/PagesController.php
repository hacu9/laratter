<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
class PagesController extends Controller
{
	public function home() {
		$messages = Message::latest()->paginate(10);
		// dd($messages);
		return view('welcome',compact('messages' ));
	}

	public function about(){
		return view('about');
	}
	
}
