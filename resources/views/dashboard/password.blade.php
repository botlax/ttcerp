@extends('dashboard')

@section('title')
Password | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent

@component('dashboard.partials.content')
	@slot('headerFA')
		lock
	@endslot
	@slot('headerTitle')
		Password
	@endslot
	@slot('content')
		<div id="admins">
		{!! Form::open(['route' => 'change-pass']) !!}
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
			{!! Form::submit('Change Password') !!}
		{!! Form::close() !!}
		</div>
	@endslot
@endcomponent

@endsection
