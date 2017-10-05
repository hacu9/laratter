@extends('layouts.app')

@section('content')
<h1>{{ $user->name }}</h1>
<a href="/{{$user->username}}/follows" class="btn btn-link">
	Following <span class="badge badge-default">{{$user->follows->count()}}</span>
</a>
<a href="/{{$user->username}}/followers" class="btn btn-link">
	Followers <span class="badge badge-default">{{$user->followers->count()}}</span>
</a>
@if(Auth::check() && Auth::user()->username != $user->username )
@if (Gate::allows('dms',$user))
<form action="/{{$user->username }}/dms" method="POST">
	{{csrf_field()}}
	<input class="form-control" name="message"></input>
	<button class="btn btn-success" type="submit">Send DM</button>
</form>
@endif


@if (Auth::user()->isFollowing($user))
<form action="/{{$user->username}}/unfollow" method="POST">
	@if (session('danger'))
	<span class="text-danger">{{session('danger')}}</span>
	@endif
	{{csrf_field()}}
	<button class="btn btn-danger">Un Follow</button>
</form>
@else
<form action="/{{$user->username}}/follow" method="POST">
	@if (session('success'))
	<span class="text-success">{{session('success')}}</span>
	@endif
	{{csrf_field()}}
	<button class="btn btn-primary">Follow</button>
</form>
@endif

@endif
<div class="row">
	@foreach($user->messages as $message)
	<div class="col-6">
		@include('messages.message')
	</div>
	@endforeach
</div>

@endsection