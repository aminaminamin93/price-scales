@extends('admin.layouts.default')
@section('content')
	<div class="container">
		<div class="profile" style="margin-left:150px; margin-top:100px;">
			<div class="row">
				{!! Form::open(array('url'=>'/retailer/register', 'method'=>'post','novalidate' => 'novalidate','files' => true), ['class'=>'form-control'] ) !!}
				<div class="col-sm-6">

					<div>
						<div>{!! Form::label('retailer_name', 'Retailer Name') !!}</div>
							<span>
							{!! Form::text('retailer_name', null  ,['class'=>'form-control input-sm']) !!}
						</span>
					</div>
					@if($errors->has('retailer_name'))<div class="alert alert-danger alert-dismissable"><span class="">{!! $errors->first('retailer_name') !!}</span></div>@endif
					<div>
						{!! Form::label('retailer_email', 'Retailer Email') !!}
						<span>
							{!! Form::text('retailer_email', null  ,['class'=>'form-control input-sm', 'placeholder'=>'example@mail.com']) !!}
						</span>
					</div>
					@if($errors->has('retailer_email'))<div class="alert alert-danger alert-dismissable"><span class="">{!! $errors->first('retailer_email') !!}</span></div>@endif
					<div>
						{!! Form::label('retailer_site', 'Retailer Site') !!}
						<span>
							{!! Form::text('retailer_site', null  ,['class'=>'form-control input-sm', 'placeholder'=>'http@https://www.example.com']) !!}
						</span>
					</div>
					@if($errors->has('retailer_site'))<div class="alert alert-danger"><span class="">{!! $errors->first('retailer_site') !!}</span></div>@endif

					<div>
						{!! Form::label('retailer_image', 'Retailer Image') !!}
						<span>
							{!! Form::file('retailer_image') !!}
						</span>
					</div>
					@if($errors->has('retailer_image'))<div class="alert alert-danger"><span class="">{!! $errors->first('retailer_image') !!}</span></div>@endif
					<br/>

				</div>
				<div class="col-sm-5">
					<div>

						<span>
							{!! Form::textarea('retailer_description', null, ['class'=>'form-control', 'placeholder'=>'About Retailer']) !!}
						</span>
					</div>
					@if($errors->has('retailer_description'))<div class="alert alert-danger alert-dismissable"><span class="">{!! $errors->first('retailer_description') !!}</span></div>@endif
					<br/>
				</div>
				<div style="clear:both; margin-left:20px;">
					{!! Form::submit('Register', ['class'=>'btn btn-success btn-large']) !!}
					{!! Form::reset('Reset', ['class'=>'btn btn-warning btn-large']) !!}
				</div>
				{!! Form::close() !!}
			</div>
			<hr>
			<div class="row">
				<h3>Retailer Information</h3>
				<div class="table-responsive">
					<table class="table">
						<tr><th>Retailer Name</th><th>Retailer Contact</th><th>Retailer Site</th><th>Manage</th></tr>
						@foreach($retailers as $retailer)
						<tr>
							<td>{!!$retailer->retailer_name !!}</td><td>{!! Html::link('/retailer/contact/'.$retailer->id , $retailer->retailer_email) !!}</td><td>{!! Html::link('http://'.$retailer->retailer_site, $retailer->retailer_site, ['target'=>'_blank']) !!}</td>
							<td>
								{!! Html::link('retailer/edit/'.$retailer->id , 'Edit', ['class'=>'btn btn-warning btn-xs']) !!}
								{!! Html::link('retailer/delete/'.$retailer->id , 'Delete', ['class'=>'btn btn-danger btn-xs']) !!}
								{!! Html::link('retailer/view/'.$retailer->id , 'View', ['class'=>'btn btn-info btn-xs']) !!}
							</td>
						</tr>
						@endforeach
					</table>
				</div>
			</div>


		</div>
	</div>
@endsection