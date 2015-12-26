@extends('layouts.default')

@section('content')
    <div class="omb_login">

       <h1 style="text-align:center; margin-top:50px;">Reset Password</h1><br/>
       @include('layouts.alert')

        <div class="row omb_row-sm-offset-3">
            <div class="col-xs-12 col-sm-6">
                {!! Form::open(array('url'=>'reset', 'class'=> 'omb_loginForm', 'autocomplete'=>'off')) !!}

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder'=>'Email'] )!!}
                </div>
                <div class="error"><span class="help-block">{!! $errors->first('email') !!}</span></div>

                <span class="help-block"></span>

                {!! Form::submit('SUBMIT', ['class'=>'btn btn-lg btn-primary btn-block']) !!}

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

        <div class="row omb_row-sm-offset-3 omb_loginOr">
            <div class="col-xs-12 col-sm-6">
                Don't have account yet?? {!! Html::link('auth/register', 'Create Account?', true) !!}
            </div>
        </div>

    </div>
@endsection
