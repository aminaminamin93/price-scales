<?php

use App\Message;


$messages = \DB::table('messages')
		->where('message_status', '=', 0)
		->get();
?>

@foreach($messages as $message)
	<li>{!! $message->message_content !!}</li>
@endforeach


<li>message</li>
