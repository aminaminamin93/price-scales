<?php


$messages = \DB::table('messages')
		->get();

$unreads = \DB::table('messages')
	->where('message_status', '=', 0)
	->count();
?>
