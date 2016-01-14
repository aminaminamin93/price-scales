@extends('layouts.default')

@section('content')
    <div class="omb_login" style="margin-bottom:50px">
        <h1 class="omb_authTitle" style="margin-top:50px">Registration</h1>

        <div class="row omb_row-sm-offset-3">
            <div class="col-xs-12 col-sm-6">

                {!! Form::open(array('url'=>'create', 'class'=> 'omb_loginForm')) !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    {!! Form::text('firstname', null, ['class' => 'form-control', 'placeholder'=>'First Name'] )!!}
                    <span class="input-group-addon" style="border:0;background-color:white; "></span>
                    {!! Form::text('lastname', null, ['class' => 'form-control', 'placeholder'=>'Last Name'] )!!}
                </div>
                @if($errors->has('firstname') || $errors->has('lastname')) <div class="alert alert-danger alert-dimissable"><span class="">{!! $errors->first('firstname') !!}   {!! $errors->first('lastname') !!}</span></div>@endif

                <span class="help-block"></span>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    {!! Form::text('user_email', null, ['class' => 'form-control', 'placeholder'=>'Email'] )!!}
                </div>
                @if($errors->has('user_email')) <div class="alert alert-danger alert-dimissable"><span class="">{!! $errors->first('user_email') !!}</span></div>@endif
                <span class="help-block"></span>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    {!! Form::password('password',['class'=>'form-control', 'placeholder'=>'Password']) !!}

                </div>
                @if($errors->has('password')) <div class="alert alert-danger alert-dimissable"><span class="">{!! $errors->first('password') !!}</span></div>@endif
                <span class="help-block"></span>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    {!! Form::password('password_confirmation',['class'=>'form-control', 'placeholder'=>'Confirmation Password']) !!}

                </div>
                @if($errors->has('password_confirmation')) <div class="alert alert-danger alert-dimissable"><span class="">{!! $errors->first('password_confirmation') !!}</span></div>@endif
                <span class="help-block"></span>
                <div class="input-group">
                  <div style="margin-left:20px">
                    <label class="checkbox">
                      <input type="checkbox" value="newsletter" checked>Subscbe Newsletter
                    </label>
                  </div>
                </div>
                
                <span class="help-block"></span>
                {!! Form::submit('Register', ['class'=>'btn btn-lg btn-primary btn-block']) !!}
                {{--</form>--}}
                {!! Form::close() !!}
            </div>
        </div>

        <div class="row omb_row-sm-offset-3 omb_loginOr">
            <div class="col-xs-12 col-sm-6">
                <hr class="omb_hrOr">
                <span class="omb_spanOr">or</span>
            </div>
        </div>

        <div class="row omb_row-sm-offset-3 omb_loginOr">
            <div class="col-xs-12 col-sm-6"  style="text-align:center">
                <h3 style="color:black">Connected To</h3>
            </div>

        </div>
        <!-- Login using social account like facebook, twitter, and gmail-->
        <div class="row omb_row-sm-offset-3 omb_socialButtons">
            <div class="col-xs-4 col-sm-2">
                <a href="#" class="btn btn-lg btn-block omb_btn-facebook">
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
                <a href="#" class="btn btn-lg btn-block omb_btn-google">
                    <i class="fa fa-google-plus visible-xs"></i>
                    <span class="hidden-xs">Google+</span>
                </a>
            </div>
        </div>


    </div>
@endsection
