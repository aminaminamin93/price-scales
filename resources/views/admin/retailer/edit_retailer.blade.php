@extends('admin.layouts.default')
@section('content')
	<div class="container">
		<div class="profile" style="margin-left:150px; margin-top:100px;">
			<div class="row">
				{!! Form::open(array('url'=>'/retailer/save/'.$retailer->id , 'method'=>'post','novalidate' => 'novalidate','files' => true), ['class'=>'form-control'] ) !!}
				<div class="col-sm-6">

					<div>
						<div>{!! Form::label('retailer_name', 'Retailer Name') !!}</div>
							<span>
							{!! Form::text('retailer_name', $retailer->retailer_name  ,['class'=>'form-control input-sm']) !!}
						</span>
					</div>
					@if($errors->has('retailer_name'))<div class="alert alert-danger alert-dimissable"><span class="">{!! $errors->first('retailer_name') !!}</span></div>@endif
					<div>
						{!! Form::label('retailer_email', 'Retailer Email') !!}
						<span>
							{!! Form::text('retailer_email', $retailer->retailer_email  ,['class'=>'form-control input-sm', 'placeholder'=>'example@mail.com']) !!}
						</span>
					</div>
					@if($errors->has('retailer_email'))<div class="alert alert-danger alert-dimissable"><span class="">{!! $errors->first('retailer_email') !!}</span></div>@endif
					<div>
						{!! Form::label('retailer_site', 'Retailer Site') !!}
						<span>
							{!! Form::text('retailer_site', $retailer->retailer_site  ,['class'=>'form-control input-sm', 'placeholder'=>'http@https://www.example.com']) !!}
						</span>
					</div>
					@if($errors->has('retailer_site'))<div class="alert alert-danger alert-dimissable"><span class="">{!! $errors->first('retailer_site') !!}</span></div>@endif

					<div>
						{!! Html::image('/admin-bootstrap/img/retailers/'.$retailer->picture_link) !!}
					</div>

					<div>
						{!! Form::label('file', 'Retailer Image') !!}
						<span>
							{!! Form::file('file') !!}
						</span>
					</div>
					@if($errors->has('file'))<div class="alert alert-danger alert-dimissable"><span class="">{!! $errors->first('file') !!}</span></div>@endif
					<br/>

				</div>
				<div class="col-sm-5">
					<div>

						<span>
							{!! Form::textarea('retailer_description', $retailer->retailer_description , ['class'=>'form-control', 'placeholder'=>'About Retailer']) !!}
						</span>
					</div>
					@if($errors->has('retailer_description'))<div class="alert alert-danger alert-dimissable"><span class="">{!! $errors->first('retailer_site') !!}</span></div>@endif
					<br/>
				</div>
				<div style="clear:both; margin-left:20px;">
					{!! Form::submit('Edit', ['class'=>'btn btn-success btn-large']) !!}
					{!! Form::reset('Reset', ['class'=>'btn btn-warning btn-large']) !!}
				</div>
				{!! Form::close() !!}
			</div>



		</div>
	</div>
@endsection