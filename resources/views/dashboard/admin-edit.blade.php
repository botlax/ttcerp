@extends('dashboard')

@section('title')
Edit {{$admin->name}} | {{config('app.name')}}
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
		Edit {{$admin->name}}
	@endslot
	@slot('content')

	<div id="admins">
	{!! Form::model($admin,['route' => ['admin-update',$admin->id],'id'=>'admins-edit']) !!}
		<div>
		{!! Form::label('name', 'Name') !!}
		{!! Form::text('name', old('name')) !!}
		@if ($errors->has('name'))
            <span class="error">
                <strong>{{ $errors->first('name') }}</strong>
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
        {!! Form::label('old_password', 'Old password') !!}
		{!! Form::password('old_password') !!}
		@if ($errors->has('old_password'))
            <span class="error">
                <strong>{{ $errors->first('old_password') }}</strong>
            </span>
        @endif
        </div>
        <div>
		{!! Form::label('new_password', 'New password') !!}
		{!! Form::password('new_password') !!}
		@if ($errors->has('new_password'))
            <span class="error">
                <strong>{{ $errors->first('new_password') }}</strong>
            </span>
        @endif
        </div>
        <div>
		{!! Form::label('new_password_confirmation', 'Retype password') !!}
		{!! Form::password('new_password_confirmation') !!}
		@if ($errors->has('new_password_confirmation'))
            <span class="error">
                <strong>{{ $errors->first('new_password_confirmation') }}</strong>
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