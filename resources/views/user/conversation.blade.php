@extends('layouts.app')
@section('content')

<h1>Conversacion con {{$conversation->users->except($user->id)->implode('name',', ')}}</h1>

@foreach ($conversation->privateMessages as $msg)
<div class="card">
	<div class="card-header">
		{{$msg->user->name}} said...
	</div>
	<div class="card-block">
		{{$msg->message}}
	</div>
	<div class="card-footer">
		<p>{{$msg->created_at->diffForHumans()}}</p>
	</div>




</div>
@endforeach


@stop