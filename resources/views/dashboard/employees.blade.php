@extends('dashboard')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/assets/css/print.css" />
@endsection

@section('title')
Employees | {{config('app.name')}}
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
		Employees
	@endslot
	@slot('content')
		<div id="heading" class="nh ps">
		<h4>TALAL TRADING and CONTRACTING COMPANY</h4>
		<h5>NAME LIST OF EMPLOYEES WORKING WITH COMPANY<br/>AS OF {{date('d/m/Y')}}</h5>
		</div>
		<div id="tools" class="ph">
			{!! Form::open(['method' => 'GET','route' => 'emp-search','id' => 'searchForm']) !!}
				{!! Form::text('q','') !!}
				{!! Form::select('designation',['' => '--Select Designation--', 'plumber' => 'Plumber', 'carpenter' => 'Carpenter', 'steel fixer' => 'Steel Fixer', 'leadman' => 'Leadman','foreman' => 'Foreman', 'mason' => 'Mason','driver' => 'Driver','cleaner' => 'Cleaner','painter' => 'Painter','labor' => 'Labor','mechanic' => 'Mechanic','watchman' => 'Watchman','project engineer' => 'Project Engineer','project manager' => 'Project Manager','safety officer' => 'Safety Officer','office staff' => 'Office Staff']) !!}
				{!! Form::submit('search') !!}
			{!! Form::close() !!}

			<a href="#" class="adv-search-toggle">Advance Search</a>
			<div id="adv-search">
			{!! Form::open(['method' => 'GET','route' => 'emp-advsearch','id' => 'searchForm']) !!}
				{!! Form::label('adj', 'Employees ') !!}
				{!! Form::select('adj',['' => '--Select--', '1' => 'with', '0' => 'without']) !!}

				{!! Form::select('attr',['' => '--Select Attribute--', 'photo' => 'Photo', 'cv' => 'CV', 'contract' => 'Contract', 'qid' => 'QID', 'passport' => 'Passport', 'visa' => 'Visa', 'job_offer' => 'Job Offer', 'blood_group' => 'Blood Group','license' => 'License', 'salary' => 'Salary Details']) !!}
				{!! Form::submit('search') !!}
			{!! Form::close() !!}
			</div>

			<a href="{{url('employees')}}">All</a>
			<a href="{{url('cancelled')}}">Cancelled Employees</a>
			<a href="{{url('employees/summary')}}">Summary</a>
			<a href="{{url('employees/add')}}"><i class="fa fa-plus"></i>Add Employee</a>
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
				    <th rowspan="2">Join Date</br><span style="display:inline-block; font-size:10px;">(dd-mm-yyyy)</span></th>
				    <th rowspan="2">DoB</br><span style="display:inline-block; font-size:10px;">(dd-mm-yyyy)</span></th>
				    <th colspan="2">Residency Permit</th>
				    <th colspan="2">Passport</th>
				    <th colspan="2">Total Monthly Salary</th>
				    <td rowspan="2" class="ph">Tools</td>
  				</tr>
  				<tr>
				    <th>RP No.</th>
				    <th>Exp Date</br><span style="display:inline-block; font-size:10px;">(dd-mm-yyyy)</span></th>
				    <th>PPT No.</th>
				    <th>Exp Date</br><span style="display:inline-block; font-size:10px;">(dd-mm-yyyy)</span></th>
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
					<td>{{$emp->joined?$emp->joined->format('d/m/Y'):'--'}}</td>
					<td>{{$emp->dob?$emp->dob->format('d/m/Y'):'--'}}</td>
					<td>{{$emp->qid?$emp->qid:'--'}}</td>
					<td>{{$emp->qid_expiry?$emp->qid_expiry->format('d/m/Y'):'--'}}</td>
					<td>{{$emp->passport?$emp->passport:'--'}}</td>
					<td>{{$emp->passport_expiry?$emp->passport_expiry->format('d/m/Y'):'--'}}</td>
					<td>{{$emp->salary()->first()?$emp->salary()->first()->basic:'--'}}</td>
					<td>{{$emp->salary()->first()?$emp->salary()->first()->subTotal:'--'}}</td>
					<td class="ph">
						<a href="{{url('employees/'.$emp->id.'/edit')}}"><i class="fa fa-wrench"></i></a>
						<a href="#delete-leanmodal" data-id="{{$emp->id}}" class="delete" rel="leanModal" title="delete"><i class="fa fa-remove"></i></a>
						{!! Form::open(['route' => ['emp-delete',$emp->id],'style' => 'display: none;','id' => 'delete'.$emp->id]) !!}{!! Form::close() !!}
					</td>
				</tr>
				<?php $x++; ?>
				@endforeach

			@if(count($vacation->toArray()))
				<tr><th colspan="13">On Vacation</th></tr>	
				<?php $x=1; ?>
				@foreach($vacation as $vac)
				<tr>
					<td>{{$x}}</td>
					<td>{{$vac->user()->first()->emp_id}}</td>
					<td><a href="{{url('employees/'.$emp->id)}}">{{$vac->user()->first()->name}}</a></td>
					<td>{{$vac->user()->first()->nationality}}</td>
					<td>{{$vac->user()->first()->joined?$vac->user()->first()->joined->format('d/m/Y'):'--'}}</td>
					<td>{{$vac->user()->first()->dob?$vac->user()->first()->dob->format('d/m/Y'):'--'}}</td>
					<td>{{$vac->user()->first()->qid}}</td>
					<td>{{$vac->user()->first()->qid_expiry?$vac->user()->first()->qid_expiry->format('d/m/Y'):'--'}}</td>
					<td>{{$vac->user()->first()->passport}}</td>
					<td>{{$vac->user()->first()->passport_expiry?$vac->user()->first()->passport_expiry->format('d/m/Y'):'--'}}</td>
					<td>{{$vac->user()->first()->salary()->first()?$vac->user()->first()->salary()->first()->basic:'--'}}</td>
					<td>{{$vac->user()->first()->salary()->first()?$vac->user()->first()->salary()->first()->subTotal:'--'}}</td>
					<td class="ph">
						<a href="{{url('employees/'.$emp->id.'/edit')}}"><i class="fa fa-wrench"></i></a>
						<a href="#delete-leanmodal" data-id="{{$emp->id}}" class="delete" rel="leanModal" title="delete"><i class="fa fa-remove"></i></a>
						{!! Form::open(['route' => ['emp-delete',$emp->id],'style' => 'display: none;','id' => 'delete'.$emp->id]) !!}{!! Form::close() !!}
					</td>
				</tr>
				<?php $x++; ?>
				@endforeach
			@endif
			</tbody>
		</table>
		
		@else
			<p>No Employees.</p>
		@endif
	@endslot
@endcomponent

@endsection

@section('modal')
<div id="delete-leanmodal">
	<a class="modal_close" href="#"><i class="fa fa-close"></i></a>
	<p>This will put <em>"cancelled"</em> status to this employee. Continue?</p>
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

		$('.options .yes').click(function(){
			$('#delete'+empId).submit();
		});
		
	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection