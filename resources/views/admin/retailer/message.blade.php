@extends('admin.layouts.default')
@section('content')
	<div class="container">
		<div class="retailer" style="margin-left:150px; margin-top:100px; margin-right:150px;">
			<div class="row">
				<div class="col-md-6">
					{!! Form::open(array('url'=>'/sending/'.$retailer->id, 'method'=>'post'),['class'=>'form-control']) !!}
					<div>
					{!! Form::text('subject', null, ['class'=>'form-control', 'placeholder'=>'Subject']) !!}
					</div><span class="help-block"></span><div>
					{!! Form::textarea('message', null, ['class'=>'form-control', 'placeholder'=>'Message here']) !!}
					</div>
				</div>
				<div class="col-md-5">
					{!! Html::image('/admin-bootstrap/img/retailers/'.$retailer->picture_link) !!}
					<div>
						<p>{!! $retailer->retailer_description !!}</p>
					</div>
				</div>
			</div>
			<div class="row" style="margin-left:10px; margin-top:50px; margin-right:150px;">

				{!! Form::submit('Send', ['class'=>'btn btn-primary btn-small']) !!}
				{!! Form::reset('Reset',['class'=>'btn btn-warning btn-small']) !!}

			</div>

		</div>
	</div>
@endsection