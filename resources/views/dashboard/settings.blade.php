@extends('dashboard')

@section('title')
Application Settings | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		cog
	@endslot
	@slot('headerTitle')
		Application Settings
	@endslot
	@slot('content')

		<h4>Expiry Date Reporting Settings</h4>
		{!! Form::model($settings, ['route' => 'settings']) !!}
			{!! Form::hidden('field','report') !!}
			<div>		
			
			<span>Receive a notification </span>{!! Form::number('qid', old('qid')) !!}<span> days prior to QID expiry</span>
			@if ($errors->has('qid'))
                <span class="error">
                    <strong>{{ $errors->first('qid') }}</strong>
                </span>
            @endif
            </div>
			<div>		
			
			<span>Receive a notification </span>{!! Form::number('passport', old('passport')) !!}<span> days prior to Passport expiry</span>
			@if ($errors->has('passport'))
                <span class="error">
                    <strong>{{ $errors->first('passport') }}</strong>
                </span>
            @endif
            </div>
            <div>		
			
			<span>Receive a notification </span>{!! Form::number('hc', old('hc')) !!}<span> days prior to Health Card expiry</span>
			@if ($errors->has('hc'))
                <span class="error">
                    <strong>{{ $errors->first('hc') }}</strong>
                </span>
            @endif
            </div>
            <div>		
			
			<span>Receive a notification </span>{!! Form::number('license', old('license')) !!}<span> days prior to License expiry</span>
			@if ($errors->has('license'))
                <span class="error">
                    <strong>{{ $errors->first('license') }}</strong>
                </span>
            @endif
            </div>
            <div>		
			
			<span>Receive a notification </span>{!! Form::number('visa', old('visa')) !!}<span> days prior to Visa expiry</span>
			@if ($errors->has('visa'))
                <span class="error">
                    <strong>{{ $errors->first('visa') }}</strong>
                </span>
            @endif
            </div>

            <div>
            <span>Receive a notification </span>{!! Form::number('vac', old('vac')) !!}<span> days prior to Employee departure</span>
			@if ($errors->has('vac'))
                <span class="error">
                    <strong>{{ $errors->first('vac') }}</strong>
                </span>
            @endif
            </div>

			{!! Form::submit('Update') !!}
		{!! Form::close() !!}

		<h4>Access Restriction Settings</h4>
		{!! Form::model($settings, ['route' => 'settings']) !!}
			{!! Form::hidden('field','ip') !!}
			<div>		
			{!! Form::label('intranet', 'Enable Intranet') !!}
			<input name="intranet" type="checkbox" value="enabled" id="intranet" {{$settings->ip != "..."?'checked':''}}>
            </div>

			<div id="public_ip-wrap" style="{{$settings->ip != "..."?'':'display:none;'}}">
			{!! Form::label('public_ip1', 'Public IP Address') !!}
			{!! Form::number('public_ip1', old('public_ip1')) !!}.
			@if ($errors->has('public_ip1'))
                <span class="error">
                    <strong>{{ $errors->first('public_ip1') }}</strong>
                </span>
            @endif
			{!! Form::number('public_ip2', old('public_ip2')) !!}.
			@if ($errors->has('public_ip2'))
                <span class="error">
                    <strong>{{ $errors->first('public_ip2') }}</strong>
                </span>
            @endif
			{!! Form::number('public_ip3', old('public_ip3')) !!}.
			@if ($errors->has('public_ip3'))
                <span class="error">
                    <strong>{{ $errors->first('public_ip3') }}</strong>
                </span>
            @endif
			{!! Form::number('public_ip4', old('public_ip4')) !!}
			@if ($errors->has('public_ip4'))
                <span class="error">
                    <strong>{{ $errors->first('public_ip4') }}</strong>
                </span>
            @endif
			</div>
			{!! Form::submit('Update') !!}
		{!! Form::close() !!}
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
		$('#intranet').change(function(){
			if ($('#intranet').is(':checked')){
				$('#public_ip-wrap').show();
			}
			else{
				$('#public_ip-wrap').hide();
			}
		});
	});
@endsection