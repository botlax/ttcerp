@extends('dashboard')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/assets/css/print.css" />
@endsection

@section('title')
Vacation | {{config('app.name')}}
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
		Vacation
	@endslot
	@slot('content')
		<div id="heading" class="nh ps">
		<h4>TALAL TRADING and CONTRACTING COMPANY</h4>
		<h5>LIST OF EMPLOYEES ON VACATION<br/>FROM {{$from->format('F d, Y')}} TO {{$to->format('F d, Y')}}</h5>
		</div>

		<div id="tools" class="ph">
		{!! Form::open(['route' => 'vac-search','id' => 'searchForm']) !!}
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

		<a href="{{url('vacation')}}">Summary</a>
		</div>
		
		@if(!empty($vacation->toArray()))
			<table id="employees" class="table9">
				<thead>
	  				<tr>
					    <th rowspan="2">SN</th>
					    <th rowspan="2">Staff No.</th>
					    <th rowspan="2">Name</th>
					    <th rowspan="2">Airlines</th>
					    <th rowspan="2">Departure</th>
					    <th rowspan="2">Arrival</th>
					    <th colspan="2">Vacation Duration</th>
	  				</tr>
	  				<tr>
					    <th>From</th>
					    <th>To</th>
	  				</tr>
				</thead>
				<tbody>
					<?php $x=1; ?>
					@foreach($vacation as $vac)
					<tr>
						<td>{{$x}}</td>
						<td>{{$vac->user()->first()->emp_id}}</td>
						<td><a href="{{url('employees/'.$vac->user()->first()->id)}}">{{$vac->user()->first()->name}}</a></td>
						<td>{{$vac->airlines?$vac->airlines:'--'}}</td>
						<td>{{$vac->vac_from_time?$vac->vac_from_time->format('d/m/Y g:i a'):'--'}}</td>
						<td>{{$vac->vac_to_time?$vac->vac_to_time->format('d/m/Y g:i a'):'--'}}</td>
						<td>{{$vac->vac_from->format('d/m/Y')}}</td>
						<td>{{$vac->vac_from->diffInDays($vac->vac_to) == 171?'Open':$vac->vac_to->format('d/m/Y')}}</td>
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