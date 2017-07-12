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
            {!! Form::label('vac_from_time','Departure') !!}
            {!! Form::text('vac_from_time',old('vac_from_time'),['class' => 'time-input']) !!}
            @if ($errors->has('vac_from_time'))
                <span class="error">
                    <strong>{{ $errors->first('vac_from_time') }}</strong>
                </span>
            @endif
            </div>
            <div>
            {!! Form::label('vac_to_time','Arrival') !!}
            {!! Form::text('vac_to_time',old('vac_to_time'),['class' => 'time-input']) !!}
            @if ($errors->has('vac_to_time'))
                <span class="error">
                    <strong>{{ $errors->first('vac_to_time') }}</strong>
                </span>
            @endif
            </div>
            <div>
            {!! Form::label('airlines','Airlines') !!}
            {!! Form::text('airlines',old('airlines'),['placeholder' => 'Type it.. :)']) !!}
            @if ($errors->has('airlines'))
                <span class="error">
                    <strong>{{ $errors->first('airlines') }}</strong>
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
		$('#vac_from,#vac_to,#vac_from_time,#vac_to_time').datepicker();
		$('#vac_from,#vac_to,#vac_from_time,#vac_to_time').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#vac_from').attr('value') != undefined){
			$('#vac_from').val($('#vac_from').attr('value').replace(' 00:00:00',''));
		}
		if($('#vac_to').attr('value') != undefined){
			$('#vac_to').val($('#vac_to').attr('value').replace(' 00:00:00',''));
		}
        if($('#vac_from_time').attr('value') != undefined){
            $('#vac_from_time').val($('#vac_from_time').attr('value').replace(' 00:00:00',''));
        }
        if($('#vac_to_time').attr('value') != undefined){
            $('#vac_to_time').val($('#vac_to_time').attr('value').replace(' 00:00:00',''));
        }

        $('.time-input').inputmask("yyyy-mm-dd hh:mm:ss", {
                mask: "y-1-2 h:s:s",
                placeholder: "yyyy-mm-dd hh:mm:ss",
                alias: "datetime",
                separator: "-",
                leapday: "-02-29",
                regex: {
                    val2pre: function(separator) {
                        var escapedSeparator = Inputmask.escapeRegex.call(this, separator);
                        return new RegExp("((0[13-9]|1[012])" + escapedSeparator + "[0-3])|(02" + escapedSeparator + "[0-2])");
                    },
                    val2: function(separator) {
                        var escapedSeparator = Inputmask.escapeRegex.call(this, separator);
                        return new RegExp("((0[1-9]|1[012])" + escapedSeparator + "(0[1-9]|[12][0-9]))|((0[13-9]|1[012])" + escapedSeparator + "30)|((0[13578]|1[02])" + escapedSeparator + "31)");
                    },
                    val1pre: new RegExp("[01]"),
                    val1: new RegExp("0[1-9]|1[012]")
                },
                onKeyDown: function(e, buffer, caretPos, opts) {}
            });
	});
@endsection