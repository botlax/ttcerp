@extends('dashboard')

@section('title')
Add Visa | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	@slot('visaClass')
		active
	@endslot
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		file-text
	@endslot
	@slot('headerTitle')
		Add Visa
	@endslot
	@slot('content')
		{!! Form::open(['route' => 'visa-add','id' => 'emp-add']) !!}
        <div class="row clearfix">
            <div class="5u">
        		<div>
        			{!! Form::label('interior', 'MOI Ref No.') !!}
        			{!! Form::text('interior', old('interior')) !!}
        			@if ($errors->has('interior'))
                        <span class="error">
                            <strong>{{ $errors->first('interior') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
        			{!! Form::label('app_num', 'Application No.') !!}
        			{!! Form::text('app_num', old('app_num')) !!}
        			@if ($errors->has('app_num'))
                        <span class="error">
                            <strong>{{ $errors->first('app_num') }}</strong>
                        </span>
                    @endif
                </div>
                <div>            
                    {!! Form::label('year', 'Year') !!}
                    {!! Form::select('year', $years,old('year')) !!}
                    @if ($errors->has('year'))
                        <span class="error">
                            <strong>{{ $errors->first('year') }}</strong>
                        </span>
                    @endif
                </div>

                <div>            
                    {!! Form::label('visa_expiry_date', 'Expiration Date') !!}
                    {!! Form::text('visa_expiry_date', old('visa_expiry_date')) !!}
                    @if ($errors->has('visa_expiry_date'))
                        <span class="error">
                            <strong>{{ $errors->first('visa_expiry_date') }}</strong>
                        </span>
                    @endif
                </div>
                <div>            
                    {!! Form::label('gender', 'Gender') !!}
                    {!! Form::select('gender', ['male' => 'Male','female' => 'Female'], old('gender')) !!}
                    @if ($errors->has('gender'))
                        <span class="error">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                    @endif
                </div>
                
            </div>
            <div class="5u">
        		<div>            
                    {!! Form::label('occupation', 'Occupation') !!}
                    {!! Form::select('occupation', ['' => '--Select Occupation--', 
						'Accountant' => 'Accountant',
						'Arch. Engineer' => 'Arch. Engineer',
						'Assist. Foreman' => 'Assist. Foreman',
						'A/C Technician' => 'A/C Technician',
						'Carpenter' => 'Carpenter', 
						'Civil Engineer' => 'Civil Engineer', 
						'Clerk' => 'Clerk',
						'Draftsman' => 'Draftsman', 
						'Driver' => 'Driver', 
						'Electrician' => 'Electrician',
						'Engineer' => 'Engineer',
						'Equipment Operator' => 'Equipment Operator',
						'Foreman' => 'Foreman', 
						'Labor' => 'Labor',
						'Marble Technician' => 'Marble Technician',
						'Mason' => 'Mason',
						'Mechanic' => 'Mechanic',
						'MEP Engineer' => 'MEP Engineer',
						'Painter' => 'Painter',
						'Plumber' => 'Plumber',
						'Representative' => 'Representative',
						'Secretary' => 'Secretary',
						'Steel Fixer' => 'Steel Fixer',
						'Technician' => 'Technician',
						'Tiles Maker' => 'Tiles Maker'], old('occupation')) !!}
                    @if ($errors->has('occupation'))
                        <span class="error">
                            <strong>{{ $errors->first('occupation') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div>            
                    {!! Form::label('nationality', 'Nationality') !!}
                    {!! Form::select('nationality', $nats, old('nationality')) !!}
                    @if ($errors->has('nationality'))
                        <span class="error">
                            <strong>{{ $errors->first('nationality') }}</strong>
                        </span>
                    @endif
                </div>

                <div>            
                    {!! Form::label('nums', 'Number of Entry') !!}
                    {!! Form::number('nums', old('nums'),['min'=>'1']) !!}
                    @if ($errors->has('nums'))
                        <span class="error">
                            <strong>{{ $errors->first('nums') }}</strong>
                        </span>
                    @endif
                </div>

        			{!! Form::submit('Add') !!}
            </div>
        </div>
		{!! Form::close() !!}
	@endslot
@endcomponent

@endsection

@section('script')
$(document).ready(function(){
	$('#visa_expiry_date').datepicker();
    $('#visa_expiry_date').datepicker("option", "dateFormat", "yy-mm-dd");
    if($('#visa_expiry_date').attr('value') != undefined){
        $('#visa_expiry_date').val($('#visa_expiry_date').attr('value').replace(' 00:00:00',''));
    }

});
@endsection