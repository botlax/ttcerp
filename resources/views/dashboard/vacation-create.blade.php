@extends('dashboard')

@section('title')
Add Vacation | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	@slot('vacClass')
		active
	@endslot
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		paper-plane
	@endslot
	@slot('headerTitle')
		Add Vacation
	@endslot
	@slot('content')
        <div id="admins">
		{!! Form::open(['route' => ['vac-store',$emp->id],'files' => true,'id' => 'vac-add']) !!}
			<div>
            {!! Form::label('vac_from','From') !!}
            {!! Form::text('vac_from',old('vac_from'),['placeholder'=>'yyyy-mm-dd','id'=>'vac_from']) !!}
            @if ($errors->has('vac_from'))
                <span class="error">
                    <strong>{{ $errors->first('vac_from') }}</strong>
                </span>
            @endif
            </div>
            <div>
            {!! Form::label('vac_to','To') !!}
            {!! Form::text('vac_to',old('vac_to'),['placeholder'=>'yyyy-mm-dd','id'=>'vac_to']) !!}
            @if ($errors->has('vac_to'))
                <span class="error">
                    <strong>{{ $errors->first('vac_to') }}</strong>
                </span>
            @endif
            </div>
            <div>
            {!! Form::label('ticket','Upload Ticket',['class'=>'vac-upload']) !!}
            {!! Form::file('ticket',['class'=>'inputfile']) !!}
            @if ($errors->has('ticket'))
                <span class="error">
                    <strong>{{ $errors->first('ticket') }}</strong>
                </span>
            @endif
            </div>
            <div>
            {!! Form::label('exit_permit','Upload Exit Permit',['class'=>'vac-upload']) !!}
            {!! Form::file('exit_permit',['class'=>'inputfile']) !!}
            @if ($errors->has('exit_permit'))
                <span class="error">
                    <strong>{{ $errors->first('exit_permit') }}</strong>
                </span>
            @endif
            </div>
            <div>
            {!! Form::label('original_form','Upload Original Form',['class'=>'vac-upload']) !!}
            {!! Form::file('original_form',['class'=>'inputfile']) !!}
            @if ($errors->has('original_form'))
                <span class="error">
                    <strong>{{ $errors->first('original_form') }}</strong>
                </span>
            @endif
            </div>
            <div>
            {!! Form::label('vacation_form','Upload Vacation Form',['class'=>'vac-upload']) !!}
            {!! Form::file('vacation_form',['class'=>'inputfile']) !!}
            @if ($errors->has('vacation_form'))
                <span class="error">
                    <strong>{{ $errors->first('vacation_form') }}</strong>
                </span>
            @endif
            </div>
            <div>
            {!! Form::label('leave_wpay','Days Payable') !!}
            {!! Form::text('leave_wpay') !!}
            @if ($errors->has('leave_wpay'))
                <span class="error">
                    <strong>{{ $errors->first('leave_wpay') }}</strong>
                </span>
            @endif
            </div>
           	
            {!! Form::submit('add') !!}
		{!! Form::close() !!}
        </div>
	@endslot
@endcomponent

@endsection

@section('script')
	$(document).ready(function(){
		$('#vac_from,#vac_to').datepicker();
		$('#vac_from,#vac_to').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#vac_from').attr('value') != undefined){
			$('#vac_from').val($('#vac_from').attr('value').replace(' 00:00:00',''));
		}
		if($('#vac_to').attr('value') != undefined){
			$('#vac_to').val($('#vac_to').attr('value').replace(' 00:00:00',''));
		}
	});
@endsection