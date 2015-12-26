@if(Session::has('message'))
    <div id="action-message" class="alert alert-danger alert-dismissible">
        {!! Session::get('message') !!}
    </div>
@endif
@if(Session::has('alert-success'))
  <div id="action-message" class="alert alert-success alert-dismissible">
      {!! Session::get('alert-success') !!}
  </div>
@endif
@if(Session::has('alert-warning'))
  <div id="action-message" class="alert alert-warning alert-dismissible">
      {!! Session::get('alert-warning') !!}
  </div>
@endif

@if(Session::has('alert-danger'))
  <div id="action-message" class="alert alert-danger alert-dismissible">
      {!! Session::get('alert-danger') !!}
  </div>
@endif


@if ($email_confirmation = Session::get('email_confirmation'))
    <div class="alert alert-success alert-dimissable">
        {!! $email_confirmation !!}{!! Html::link('http://www.'.$mailserver, 'Confirm now', true) !!}
    </div>
@endif
