@extends('dashboard')

@section('title')
Edit Visa | {{config('app.name')}}
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
		Edit Visa
	@endslot
	@slot('content')
		{!! Form::model($visa,['route' => ['visa-update',$visa->id],'id' => 'emp-add']) !!}
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
                    {!! Form::select('year', $years, old('year')) !!}
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
                    {!! Form::select('occupation', ['Accountant' => 'Accountant', 'Carpenter' => 'Carpenter', 'Civil Engineer' => 'Civil Engineer', 'Draftsman' => 'Draftsman', 'Driver' => 'Driver', 'Engineer' => 'Engineer','Foreman' => 'Foreman', 'Labor' => 'Labor','Marble Technician' => 'Marble Technician','Mason' => 'Mason','Steel Fixer' => 'Steel Fixer','Tiles Maker' => 'Tiles Maker'], old('occupation')) !!}
                    @if ($errors->has('occupation'))
                        <span class="error">
                            <strong>{{ $errors->first('occupation') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div>            
                    {!! Form::label('nationality', 'Nationality') !!}
                    {!! Form::select('nationality', $nats, $visa->nationality?strtolower($visa->nationality):null) !!}
                    @if ($errors->has('nationality'))
                        <span class="error">
                            <strong>{{ $errors->first('nationality') }}</strong>
                        </span>
                    @endif
                </div>

                <div>
                    {!! Form::label('status', 'Assign to Employee') !!}
                    <select id="status" name="status">
                        <option value="">--Select Employee--</option>
                        @foreach($emps as $emp)
                        <option 
                        @if($emp->visa()->first())
                            @if($emp->visa()->first()->id == $visa->id)
                                selected
                            @endif
                        @endif
                        value="{{$emp->id}}">{{$emp->emp_id}} - {{$emp->name}}</option>
                        @endforeach
                    </select>
                </div>

        			{!! Form::submit('Update') !!}
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