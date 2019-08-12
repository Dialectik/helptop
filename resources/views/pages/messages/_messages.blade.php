@foreach($messages as $message)
	@if(Auth::user()->id == $message->user_id)
		<div class="form-group alert alert-success col-sm-9" style="margin-top: 10px; margin-bottom: 10px; margin-left: 10px; margin-right: 10px;">
			<a href="" style="">{{ Auth::user()->name }}</a> (Вы) &nbsp;&nbsp; {{ $message->getDateAttribute($message->created_at, $date_offset) }}
			<p><?php echo $message->message ?></p>
		</div>
	@endif
	
	@if(Auth::user()->id != $message->user_id)
		<div class="form-group alert alert-info col-sm-9" style="margin-top: 10px; margin-bottom: 10px; margin-left: 100px; margin-right: 10px; align-self: right">
			<a href="" style="">{{ Auth::user()->id == $deal->author ? $deal->initiatorUser->name : $deal->authorUser->name }}</a> (контрагент) &nbsp;&nbsp; {{ $message->getDateAttribute($message->created_at, $date_offset) }}
			<p><?php echo $message->message ?></p>
		</div>
	@endif
@endforeach

<p>&nbsp; </p>
<p>&nbsp; </p>