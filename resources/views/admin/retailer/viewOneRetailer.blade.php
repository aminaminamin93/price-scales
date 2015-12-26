@extends('admin.layouts.default')
@section('content')
	<div class="container">
		<div class="retailer" style="margin-left:150px; margin-top:100px; margin-right:150px;">
			<div class="row">
				<div class="col-md-5">
					<table class="table table-striped">
						<tr><th colspan="2" style="text-align:center; background-color:grey">Retailer</th></tr>
						<tr><td>Name<span style="float:right;"><b>:</b></span></td><td >{!! $retailer->retailer_name !!}</td></tr>
						<tr><td>Contact<span style="float:right;"><b>:</b></span></td><td>{!! $retailer->retailer_email !!}</td></tr>
						<tr><td>Website<span style="float:right;"><b>:</b></span></td><td>{!! $retailer->retailer_site !!}</td></tr>
					</table>
				</div>
				<div class="col-md-6">
					<div>
						{!! Html::image('/admin-bootstrap/img/retailers/'.$retailer->picture_link) !!}
					</div>
					<div>
						<p>{!! $retailer->retailer_description !!}</p>
					</div>
				</div>
			</div>
			<div class="row" style="margin-left:10px; margin-top:50px; margin-right:150px;">

				<div style="float:left;">
					{!! Html::link('http://'.$retailer->retailer_site,'Go to website',['class'=>'btn btn-primary btn-block', 'target'=>'_blank']) !!}
				</div>
				<span>&nbsp;</span>
				<div style="float:left; margin-left:10px;">
					{!! Html::link('/view/product/'.$retailer->id ,'All Product From '.$retailer->retailer_name ,['class'=>'btn btn-info btn-block']) !!}
				</div>
				<div style="float:right;">
					{!! Html::link('retailer/edit/'.$retailer->id ,'Edit',['class'=>'btn btn-warning btn-small']) !!}
					{!! Html::link('retailer/delete/'.$retailer->id ,'Delete' , ['class'=>'btn btn-danger btn-small']) !!}
					{!! Html::link('/retailer/contact/'.$retailer->id,'Message', ['class'=>'btn btn-success btn-small']) !!}
				</div>
			</div>

		</div>
	</div>
@endsection