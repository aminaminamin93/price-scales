{!! Form::open(array('url'=>'/upload', 'method'=>'post', 'files'=> true)) !!}
<div>
	{!! Form::label('image', 'Retailer Image') !!}
	<span>
							{!! Form::file('image') !!}
						</span>
</div>
<div>
	{!! Form::submit('upload') !!}
</div>
{!! Form::close() !!}