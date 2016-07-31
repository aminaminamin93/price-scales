@extends('layouts.default')

@section('content')
        <!--login modal-->

<div class="omb_login">
    <h3 class="omb_authTitle">Login or {!! Html::link('auth/register', 'Sign Up', true) !!}</h3>
    {!! Form::open(array('route'=>'sessions.store', 'class'=> 'omb_loginForm')) !!}
    @include('layouts.alert')
    <div class="row omb_row-sm-offset-3">

        <div class="col-xs-12 col-sm-6">

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    @if($email = Session::get('email'))
                      {!! Form::text('email',$email, ['class' => 'form-control', 'placeholder'=>'Email'] )!!}
                    @else
                      {!! Form::text('email',null, ['class' => 'form-control', 'placeholder'=>'Email'] )!!}
                    @endif


                </div>
            @if($errors->has('email')) <div class="alert alert-danger alert-dimissable"><span class="">{!! $errors->first('email') !!}</span></div>@endif

                <span class="help-block"></span>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    {!! Form::password('password',['class'=>'form-control', 'placeholder'=>'Password']) !!}

                </div>




              <span class="help-block"></span>
            @if($errors->has('password'))<div class="alert alert-danger alert-dimissable"><span class="">{!! $errors->first('password') !!}</span></div>@endif
                {!! Form::submit('Login', ['class'=>'btn btn-lg btn-primary btn-block']) !!}


        </div>



    </div>



    <div class="row omb_row-sm-offset-3" style="margin-left:10px;">
        <div class="col-xs-12 col-sm-3">
            <label class="checkbox">
                <input type="checkbox" value="remember-me">Remember Me
            </label>
        </div>

        <div class="col-xs-12 col-sm-3">
            <p class="omb_forgotPwd">
                {!! Html::link('auth/reset', 'Forget Password', true) !!}
            </p>
        </div>
    </div>

    {!! Form::close() !!}

    <div class="row omb_row-sm-offset-3 omb_loginOr">
        <div class="col-xs-12 col-sm-6">
            Don't have account?? {!! Html::link('auth/register', 'Create Account?', true) !!}
        </div>
    </div>

    <div class="row omb_row-sm-offset-3 omb_loginOr">
        <div class="col-xs-12 col-sm-6">
            <hr class="omb_hrOr">
            <span class="omb_spanOr">or</span>
        </div>

    </div>
    <!-- Login using social account like facebook, twitter, and gmail-->
    <div class="row omb_row-sm-offset-3 omb_socialButtons">
        <div class="col-xs-4 col-sm-2">
          
          <a href="/login/facebook" class="btn btn-lg btn-block omb_btn-facebook">
              <i class="fa fa-facebook visible-xs"></i>
              <span class="hidden-xs">Facebook</span>
          </a>
        </div>
        <div class="col-xs-4 col-sm-2">
            <a href="#" class="btn btn-lg btn-block omb_btn-twitter">
                <i class="fa fa-twitter visible-xs"></i>
                <span class="hidden-xs">Twitter</span>
            </a>
        </div>
        <div class="col-xs-4 col-sm-2">
            <a href="/login/google" class="btn btn-lg btn-block omb_btn-google">
                <i class="fa fa-google-plus visible-xs"></i>
                <span class="hidden-xs">Google+</span>
            </a>
        </div>
    </div>




</div>
@endsection
