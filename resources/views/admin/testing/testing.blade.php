@extends('admin.layouts.default')


@section('content')
	<div class="container" ng-controller="ajaxController">
		{!! Form::open(array('url'=>'/angularajax/test', 'method'=>'POST', 'ng-submit'=>'angularAjax($event)')) !!}
		{!! Form::text('name', null , array('ng-model'=>'info.name')) !!}
		<input type="checkbox" ng-model="edit" ng-change="editable()" >
		<div >
			<p ng-show="edited" ng-click="edited = false">Edit here!</p>
		</div>
		{!! Form::submit('Submit') !!}
		{!! Form::close() !!}
	</div>
@endsection