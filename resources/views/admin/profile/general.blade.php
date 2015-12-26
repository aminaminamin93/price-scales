@extends('admin.layouts.default')

@section('content')
	<div class="container">
	<div class="profile" style="margin-left:200px; margin-top:100px;">
		<div class="row">

			<table>
				<tr><td rowspan="2">{!! Html::image('/admin-bootstrap/img/'.$users->picture_link , 'alt', array( 'style'=>'border-radius:10px','width' =>70, 'height' => 70 )) !!}</td><td colspan="2"></td><td>sffdsf     d  </td></tr>

				<tr><td></td><td>{!! Html::link('//', 'General', array('class'=>'btn btn-default btn-sm', 'disabled'=>'true')) !!}</td>
					<td>{!! Html::link('//', 'Task', array('class'=>'btn btn-info btn-sm btn-block')) !!}
					</td></tr>
			</table>
			{{--<div class="col-sm-1">--}}
				{{--dsfsdfsd--}}
			{{--</div>--}}
			{{--<div class="col-sm-1">--}}
				{{--dsfsdfsd--}}
			{{--</div>--}}
			{{--<div class="col-sm-1">--}}
				{{--dsfsdfsd--}}
			{{--</div>--}}
		</div>
		<hr>
		<div class="row">
			<table class="">
				<tr>
					<td rowspan="2" style="padding:20px 20px 20px 20px;">
						<div class="profile-picture">
							{!! Html::image('/admin-bootstrap/img/avatar5.png', 'alt' ,array( 'style'=>'border-radius:10px' )) !!}
						</div>
					</td>
					<td style="padding:20px 20px 20px 20px;">
						<table>
							<tr><th colspan="3">Contact Information</th></tr>
							<tr><td>Email</td><td>&nbsp;:&nbsp;&nbsp;</td><td>{!! $users->user_email !!}</td></tr>
							<tr><td>Mobile/office No</td><td>&nbsp;:&nbsp;&nbsp;</td><td>{!! $users->user_phone !!}</td></tr>
							<tr><td colspan="3"><hr style="color:black;"></td></tr>
							<tr><th colspan="3">General Information</th></tr>
							<tr><td>Name</td><td>&nbsp;:&nbsp;&nbsp;</td><td>{!! $users->user_firstname !!}&nbsp;&nbsp;{!! $users->user_lastname !!}</td></tr>
							<tr><td>Status</td><td>&nbsp;:&nbsp;&nbsp;</td><td>Super Admin</td></tr>
						</table>
					</td>
					<td rowspan="2" style="padding:20px 20px 20px 20px;">
						{!! Html::link('editProfile', 'Edit Profile', ['class'=>'btn btn-primary btn-block']) !!}
						{!! Html::link('adminMode', 'Admin Mode', ['class'=>'btn btn-primary btn-block']) !!}

					</td></tr>

			</table>
		</div>
	</div>
	</div>
@stop