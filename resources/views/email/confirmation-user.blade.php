@extends('email.index')

@section('content')
	<h1>Email Confirmation :</h1>
	{!! Html::link('http://localhost:8000/user_register_confirm/?firstname='.$firstname.'&lastname='.$lastname.'&email='.$email.'&password='.$password, 'Click this link to confirm your account'); !!}
@endsection
