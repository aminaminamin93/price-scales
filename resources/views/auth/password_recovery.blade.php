@extends('layouts.default')

@section('content')
    <div class="omb_login">

        <div class="row omb_row-sm-offset-3 omb_loginOr" style="margin-top:25px;">
            <div class="col-xs-12 col-sm-6">
               <h3>Change Your Password</h3>
            </div>
        </div>
            @include('layouts.alert')
        <div class="row omb_row-sm-offset-3" >
            <div class="col-xs-12 col-sm-6">
                {!! Form::open(array('url'=>'/password/recover/'.$users->provider_id, 'method'=>'POST', 'class'=> 'omb_loginForm')) !!}


                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    {!! Form::text('user_email', $users->user_email, ['class' => 'form-control', 'placeholder'=>'Email'] )!!}
                </div>

                <span class="help-block">{!! $errors->first('user_email') !!}</span>
                <span class="help-block"></span>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    {!! Form::password('password',['class'=>'form-control', 'placeholder'=>'Password']) !!}

                </div>
                <span class="help-block">{!! $errors->first('password') !!}</span>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    {!! Form::password('password_confirmation',['class'=>'form-control', 'placeholder'=>'Confirmation Password']) !!}

                </div>
                <span class="help-block">{!! $errors->first('password_confirmation') !!}</span>
                {!! Form::submit('Change Password', ['class'=>'btn btn-lg btn-primary btn-block']) !!}
                {{--</form>--}}
                {!! Form::close() !!}
            </div>
        </div>



    </div>
    <br/><br/>
@endsection
