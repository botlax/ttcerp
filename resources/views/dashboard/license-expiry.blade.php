@extends('dashboard')

@section('title')
License Expiry | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	@slot('licClass')
		active
	@endslot
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		car
	@endslot
	@slot('headerTitle')
		License Expiry
	@endslot
	@slot('content')
		<div id="heading" class="nh ps">
		<h4>TALAL TRADING and CONTRACTING COMPANY</h4>
		<h5>LIST DRIVING LICENSES EXPIRING IN 30 DAYS</h5>
		</div>

		<div id="tools" class="ph">
		{!! Form::open(['route' => 'lic-search','id' => 'searchForm']) !!}
			{!! Form::label('from','From') !!}
			{!! Form::text('from') !!}
			@if ($errors->has('from'))
                <span class="error">
                    <strong>{{ $errors->first('from') }}</strong>
                </span>
            @endif
			{!! Form::label('to','To') !!}
			{!! Form::text('to') !!}
			@if ($errors->has('to'))
                <span class="error">
                    <strong>{{ $errors->first('to') }}</strong>
                </span>
            @endif
			{!! Form::submit('search') !!}
		{!! Form::close() !!}

		<a href="{{url('license-expiry')}}">Summary</a>
		</div>

		@if(!empty($lics->toArray()))
			<table id="employees" class="table7">
				<thead>
	  				<tr>
					    <th rowspan="2">SN</th>
					    <th rowspan="2">Staff No.</th>
					    <th rowspan="2">Name</th>
					    <th rowspan="2">Nationality</th>
					    <th rowspan="2">Join Date</th>
					    <th colspan="2">License</th>
	  				</tr>
	  				<tr>
					    <th>License No.</th>
					    <th>Exp Date</th>
	  				</tr>
				</thead>
				<tbody>
					<?php $x=1; ?>
					@foreach($lics as $lic)
					<tr>
						<td>{{$x}}</td>
						<td>{{$lic->user()->first()->emp_id}}</td>
						<td><a href="{{url('employees/'.$lic->user()->first()->id)}}">{{$lic->user()->first()->name}}</a></td>
						<td>{{$lic->user()->first()->nationality?$lic->user()->first()->nationality:'--'}}</td>
						<td>{{$lic->user()->first()->joined?$lic->user()->first()->joined->format('d/m/Y'):'--'}}</td>
						<td>{{$lic->license}}</td>
						<td>{{$lic->expiry_date->format('d/m/Y')}}</td>
					</tr>
					<?php $x++; ?>
					@endforeach
				</tbody>
			</table>
		@else
		<p>Empty list.</p>
		@endif

	@endslot
@endcomponent

@endsection

@section('modal')

@endsection

@section('script')
	$(document).ready(function(){
		$('#from,#to').datepicker();
		$('#from,#to').datepicker("option", "dateFormat", "yy-mm-dd");

		if($('#from').attr('value') != undefined){
			$('#from').val($('#from').attr('value').replace(' 00:00:00',''));
		}
		if($('#to').attr('value') != undefined){
			$('#to').val($('#to').attr('value').replace(' 00:00:00',''));
		}
	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection