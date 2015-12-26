@if ($alert = Session::get('welcome-notification'))
  <div class="alert alert-info alert-dimissable" id="fail-action-message">
    {{ $alert }}
  </div>
@endif
@if ($alert = Session::get('sendingmail-notification'))
  <div class="alert {!! Session::get('alert-type') !!} alert-dimissable" id="fail-action-message">
    {{ $alert }}
  </div>
@endif
@if ($alert = Session::get('register-retailer'))
  <div class="alert {!! Session::get('alert-type') !!} alert-dimissable" id="fail-action-message">
    {{ $alert }}

  </div>
@endif
