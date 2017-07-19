@extends('dashboard')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/assets/css/print.css" />
@endsection

@section('title')
Health Card Expiry | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	@slot('hcClass')
		active
	@endslot
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		medkit
	@endslot
	@slot('headerTitle')
		Health Card Expiry
	@endslot
	@slot('content')
		<div id="heading" class="nh ps">
		<h4>TALAL TRADING and CONTRACTING COMPANY</h4>
		<h5>LIST HEALTH CARDS EXPIRING BETWEEN<br/>{{$from->format('F d, Y')}} TO {{$to->format('F d, Y')}}</h5>
		</div>

		<div id="tools" class="ph">
		{!! Form::open(['route' => 'hc-search','id' => 'searchForm']) !!}
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

		<a href="{{url('hc-expiry')}}">Summary</a>
		<a href="{{url('hc-expiry/expired')}}">Expired</a>
		</div>

		@if(!empty($emps->toArray()))
			<table id="employees" class="table8">
				<thead>
	  				<tr>
					    <th rowspan="2">SN</th>
					    <th rowspan="2">Staff No.</th>
					    <th rowspan="2">Name</th>
					    <th rowspan="2">Nationality</th>
					    <th rowspan="2">Join Date</th>
					    <th rowspan="2">QID</th>
					    <th colspan="2">Health Card</th>
	  				</tr>
	  				<tr>
					    <th>Health Card No.</th>
					    <th>Exp Date</th>
	  				</tr>
				</thead>
				<tbody>
					<?php $x=1; ?>
					@foreach($emps as $emp)
					<tr>
						<td>{{$x}}</td>
						<td>{{$emp->emp_id}}</td>
						<td><a href="{{url('employees/'.$emp->id)}}">{{$emp->name}}</a></td>
						<td>{{$emp->nationality?$emp->nationality:'--'}}</td>
						<td>{{$emp->joined?$emp->joined->format('d/m/Y'):'--'}}</td>
						<td>{{$emp->qid?$emp->qid:'--'}}</td>
						<td>{{$emp->health_card}}</td>
						<td>{{$emp->hc_expiry->format('d/m/Y')}}</td>
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