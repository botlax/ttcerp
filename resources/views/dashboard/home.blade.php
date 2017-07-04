@extends('dashboard')

@section('title')
Dashboard | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	@slot('dbClass')
		active
	@endslot
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		home
	@endslot
	@slot('headerTitle')
		Dashboard
	@endslot
	@slot('content')
		<div class="row clearfix">
			<div class="6u">
				<a href="{{url('employees')}}" style="background:#2ecc71;-webkit-box-shadow: 0px 8px 0px 0px rgba(39,174,96,1);
-moz-box-shadow: 0px 8px 0px 0px rgba(39,174,96,1);
box-shadow: 0px 8px 0px 0px rgba(39,174,96,1);" class="dashboard-button"><i class="fa fa-users"></i> Employees</a>
			</div>
			<div class="6u">
				<a href="{{url('vacation')}}" style="background:#3498db;-webkit-box-shadow: 0px 8px 0px 0px rgba(41,128,185,1);
-moz-box-shadow: 0px 8px 0px 0px rgba(41,128,185,1);
box-shadow: 0px 8px 0px 0px rgba(41,128,185,1);" class="dashboard-button"><i class="fa fa-paper-plane"></i> Vacation</a>
			</div>
			<div class="6u">
				<a href="{{url('qid-expiry')}}" style="background:#e67e22;-webkit-box-shadow: 0px 8px 0px 0px rgba(211,84,0,1);
-moz-box-shadow: 0px 8px 0px 0px rgba(211,84,0,1);
box-shadow: 0px 8px 0px 0px rgba(211,84,0,1);" class="dashboard-button"><i class="fa fa-id-badge"></i> QID Expiry</a>
			</div>
			<div class="6u">
				<a href="{{url('passport-expiry')}}" style="background:#e74c3c;-webkit-box-shadow: 0px 8px 0px 0px rgba(192,57,43,1);
-moz-box-shadow: 0px 8px 0px 0px rgba(192,57,43,1);
box-shadow: 0px 8px 0px 0px rgba(192,57,43,1);" class="dashboard-button"><i class="fa fa-drivers-license"></i> Passport Expiry</a>
			</div>
			<div class="6u">
				<a href="{{url('hc-expiry')}}" style="background:#9b59b6;-webkit-box-shadow: 0px 8px 0px 0px rgba(142,68,173,1);
-moz-box-shadow: 0px 8px 0px 0px rgba(142,68,173,1);
box-shadow: 0px 8px 0px 0px rgba(142,68,173,1);" class="dashboard-button"><i class="fa fa-medkit"></i> Health Card Expiry</a>
			</div>
			<div class="6u">
				<a href="{{url('license-expiry')}}" style="background:#f1c40f;-webkit-box-shadow: 0px 8px 0px 0px rgba(243,156,18,1);
-moz-box-shadow: 0px 8px 0px 0px rgba(243,156,18,1);
box-shadow: 0px 8px 0px 0px rgba(243,156,18,1);" class="dashboard-button"><i class="fa fa-car"></i> License Expiry</a>
			</div>
			<div class="6u">
				<a href="{{url('visa')}}" style="background:#34495e;-webkit-box-shadow: 0px 8px 0px 0px rgba(44,62,80,1);
-moz-box-shadow: 0px 8px 0px 0px rgba(44,62,80,1);
box-shadow: 0px 8px 0px 0px rgba(44,62,80,1);" class="dashboard-button"><i class="fa fa-file-text"></i> Visas</a>
			</div>
		</div>
	@endslot
@endcomponent

@endsection
