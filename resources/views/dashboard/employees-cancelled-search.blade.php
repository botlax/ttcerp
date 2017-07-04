@extends('dashboard')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/assets/css/print.css" />
@endsection

@section('title')
Cancelled Employees | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	@slot('empClass')
		active
	@endslot
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		users
	@endslot
	@slot('headerTitle')
		Cancelled Employees
	@endslot
	@slot('content')
		<div id="heading" class="nh ps">
		<h4>TALAL TRADING and CONTRACTING COMPANY</h4>
		<h5>NAME LIST OF CANCELLED EMPLOYEES<br/>AS OF {{date('d/m/Y')}}</h5>
		</div>
		<div id="tools" class="ph">
			{!! Form::open(['method' => 'GET','route' => 'cancel-search','id' => 'searchForm']) !!}
				{!! Form::text('q','') !!}
				{!! Form::select('designation',['' => '--Select Designation--', 'plumber' => 'Plumber', 'carpenter' => 'Carpenter', 'steel fixer' => 'Steel Fixer', 'leadman' => 'Leadman','foreman' => 'Foreman', 'mason' => 'Mason','driver' => 'Driver','cleaner' => 'Cleaner','painter' => 'Painter','labor' => 'Labor','mechanic' => 'Mechanic','watchman' => 'Watchman','project engineer' => 'Project Engineer','project manager' => 'Project Manager','safety officer' => 'Safety Officer','office staff' => 'Office Staff']) !!}
				{!! Form::submit('search') !!}
			{!! Form::close() !!}
			<a href="{{url('cancelled')}}">All Cancelled Employees</a>
			<a href="{{url('employees')}}">Employees</a>
			<p>Total: {{count($employees)}}</p>
		</div>
		@if(count($employees->toArray()))
		<table id="employees" class="emp-list">
			<thead>
  				<tr>
				    <th rowspan="2">SN</th>
				    <th rowspan="2">Staff No.</th>
				    <th rowspan="2">Name</th>
				    <th rowspan="2">Nationality</th>
				    <th rowspan="2">Join Date</th>
				    <th rowspan="2">DoB</th>
				    <th colspan="2">Residency Permit</th>
				    <th colspan="2">Passport</th>
				    <th colspan="2">Total Monthly Salary</th>
				    <td rowspan="2" class="ph">Tools</td>
  				</tr>
  				<tr>
				    <th>RP No.</th>
				    <th>Exp Date</th>
				    <th>PPT No.</th>
				    <th>Exp Date</th>
				    <th>Basic</th>
				    <th>Allowance</th>
  				</tr>
			</thead>
			<tbody>
				<?php $x=1; ?>
				@foreach($employees as $emp)
				<tr>
					<td>{{$x}}</td>
					<td>{{$emp->emp_id}}</td>
					<td><a href="{{url('employees/'.$emp->id)}}">{{$emp->name}}</a></td>
					<td>{{$emp->nationality?$emp->nationality:'--'}}</td>
					<td>{{$emp->joined?$emp->joined->format('M d, Y'):'--'}}</td>
					<td>{{$emp->dob?$emp->dob->format('M d, Y'):'--'}}</td>
					<td>{{$emp->qid?$emp->qid:'--'}}</td>
					<td>{{$emp->qid_expiry?$emp->qid_expiry->format('M d, Y'):'--'}}</td>
					<td>{{$emp->passport?$emp->passport:'--'}}</td>
					<td>{{$emp->passport_expiry?$emp->passport_expiry->format('M d, Y'):'--'}}</td>
					<td>{{$emp->salary()->first()?$emp->salary()->first()->basic:'--'}}</td>
					<td>{{$emp->salary()->first()?$emp->salary()->first()->subTotal:'--'}}</td>
					<td class="ph">
						<a href="{{url('employees/'.$emp->id.'/edit')}}"><i class="fa fa-wrench"></i></a>
						<a href="#revive-leanmodal" data-id="{{$emp->id}}" class="revive" rel="leanModal" title="revive"><i class="fa fa-check"></i></a>
						{!! Form::open(['route' => ['emp-revive',$emp->id],'style' => 'display: none;','id' => 'revive'.$emp->id]) !!}{!! Form::close() !!}
					</td>
				</tr>
				<?php $x++; ?>
				@endforeach
			</tbody>
		</table>
		
		@else
			<p>No Employees.</p>
		@endif


	@endslot
@endcomponent

@endsection

@section('modal')
<div id="revive-leanmodal">
	<a class="modal_close" href="#"><i class="fa fa-close"></i></a>
	<p>This <em>"uncancelled"</em> this employee. Continue?</p>
	<div class="options">
		<button class="option yes">Yes</button>
		<button class="option cancel">Cancel</button>
	</div>
</div>
@endsection

@section('script')
	$(document).ready(function(){
		var empId;
		$(document).on('click','a[rel=leanModal]',function(){
			empId = $(this).data('id');
		});

		$('#revive-leanmodal .options .yes').click(function(){
			$('#revive'+empId).submit();
		});

	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection