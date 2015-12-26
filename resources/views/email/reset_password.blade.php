@extends('email.index')

@section('content')
  {!! Html::link('http://localhost:8000/auth/recover_password/'.$provider_id, 'Click this link to change your password'); !!}

@endsection
