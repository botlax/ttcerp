@extends('dashboard')

@section('title')
Administration Management | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		key
	@endslot
	@slot('headerTitle')
		Administration Management
	@endslot
	@slot('content')
	<div id="admins">
	<h4>Admin List</h4>
	@if(count($admins))
		<ul id="admin-list">
		@foreach($admins as $admin)
			<li><span>{{$admin->name}} - {{$admin->role}}</span><a href="{{url('admins/'.$admin->id.'/edit')}}" class="edit" title="edit"><i class="fa fa-wrench"></i></a><a href="#delete-leanmodal" data-id="{{$admin->id}}" class="delete" rel="leanModal" title="delete"><i class="fa fa-remove"></i></a></li><br/>
			{!! Form::open(['route' => ['admin-delete',$admin->id],'style' => 'display: none;','id' => 'delete'.$admin->id]) !!}{!! Form::close() !!}
		@endforeach()
		</ul>
	@else
		<p class="note">No admins other than you.</p>
	@endif

	<h4>Add Admin</h4>
		{!! Form::open(['route' => 'admin-add']) !!}
			<div>		
			{!! Form::label('emp', 'Name') !!}
			{!! Form::select('emp', $emps, old('emp')) !!}
			@if ($errors->has('emp'))
                <span class="error">
                    <strong>{{ $errors->first('emp') }}</strong>
                </span>
            @endif
            </div>
			<div>
            {!! Form::label('role', 'Role') !!}
			{!! Form::select('role', ['admin'=>'Power User','god'=>'Administrator','spectator'=>'Spectator'], old('role')) !!}
			@if ($errors->has('role'))
                <span class="error">
                    <strong>{{ $errors->first('role') }}</strong>
                </span>
            @endif
            </div>
			<div>
            {!! Form::label('password', 'Password') !!}
			{!! Form::password('password') !!}
			@if ($errors->has('password'))
                <span class="error">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            </div>
			<div>
            {!! Form::label('password_confirmation', 'Repeat password') !!}
			{!! Form::password('password_confirmation') !!}
			@if ($errors->has('password_confirmation'))
                <span class="error">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
            </div>
			{!! Form::submit('Add') !!}
		{!! Form::close() !!}
		</div>
	@endslot
@endcomponent

@endsection

@section('modal')
<div id="delete-leanmodal">
	<a class="modal_close" href="#"><i class="fa fa-close"></i></a>
	<p>This will permanently delete this admin. Continue?</p>
	<div class="options">
		<button class="option yes">Yes</button>
		<button class="option cancel">Cancel</button>
	</div>
</div>
@endsection

@section('script')
	$(document).ready(function(){
		var adminId;
		$('a[rel=leanModal]').click(function(){
			adminId = $(this).data('id');
		});
		$('.options .yes').click(function(){
			$('#delete'+adminId).submit();
		});
	});
@endsection