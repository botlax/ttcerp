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
				{!! Form::select('position',['' => '--Select Position--',
                    'Accountant'  =>  'Accountant',
                    'Administration Manager'   =>  'Administration Manager',
                    'Assist. Accountant'  =>  'Assist. Accountant',
                    'Assist. Foreman'  =>  'Assist. Foreman',
                    'Block Mason' =>  'Block Mason',
                    'Camp Boss'   =>  'Camp Boss',
                    'Camp Cleaner' =>  'Camp Cleaner',
                    'Camp Security'  =>  'Camp Security',
                    'Civil Engineer'   =>  'Civil Engineer',
                    'Contracts Manager'   =>  'Contracts Manager',
                    'Decorative Painter'  =>  'Decorative Painter',
                    'Draftsman'    =>  'Draftsman',
                    'Plumber'  =>  'Plumber',
                    'Electrician'  =>  'Electrician',
                    'Equipment Operator'   =>  'Equipment Operator',
                    'Executive Manager'   =>  'Executive Manager',
                    'Finance Manager' => 'Finance Manager',
                    'Foreman' => 'Foreman',
                    'General Manager'   =>  'General Manager',
                    'General Service Assistant'   =>  'General Service Assistant',
                    'General Service Manager'   =>  'General Service Manager',
                    'Head Of Tender Department'   =>  'Head Of Tender Department',
                    'Heavy Driver'  =>  'Heavy Driver',
                    'HR Manager'   =>  'HR Manager',
                    'HR Officer'   =>  'HR Officer',
                    'In-charge, Steel Fixer Grp' =>  'In-charge, Steel Fixer Grp',
                    'In-charge, Painter Grp' =>  'In-charge, Painter Grp',
                    'In-charge, Mason Grp' =>  'In-charge, Mason Grp',
                    'JCB Operator' =>  'JCB Operator',
                    'Labourer'   =>  'Labourer',
                    'Leadman'    =>  'Leadman',
                    'Light Driver'    =>  'Light Driver',
                    'Male Nurse'  =>  'Male Nurse',
                    'Mason'    =>  'Mason',
                    'Mechanic'  =>  'Mechanic',
                    'Mechanic Assistant' =>  'Mechanic Assistant',
                    'Office Boy'   =>  'Office Boy',
                    'Office Security'  =>  'Office Security',
                    'Operations Manager'   =>  'Operations Manager',
                    'Painter' =>  'Painter',
                    'Plumber' =>  'Plumber',
                    'Project Engineer'    =>  'Project Engineer',
                    'Project Manager'   =>  'Project Manager',
                    'Public Relation Manager'    =>  'Public Relation Manager',
                    'Public Relation Officer'    =>  'Public Relation Officer',
                    'Purchase Engineer'   =>  'Purchase Engineer',
                    'Purchase Manager'   =>  'Purchase Manager',
                    'Purchase Representative' =>  'Purchase Representative',
                    'QS / Estimator'  =>  'QS / Estimator',
                    'Representative' => 'Representative',
                    'Safety Assist.'   =>  'Safety Assist.',
                    'Safety Officer'   =>  'Safety Officer',
                    'Secretary'    =>  'Secretary',
                    'Secretary/IT Assistant'    =>  'Secretary/IT Assistant',
                    'Shutter Carpenter'    =>  'Shutter Carpenter',
                    'Site Engineer'    =>  'Site Engineer',
                    'Steel Fixer'   =>  'Steel Fixer',
                    'Store Kepeer'    =>  'Store Kepeer',
                    'Technical Engineer' =>  'Technical Engineer',
                    'Timekeeper'   =>  'Timekeeper',
                    'Watchman' =>  'Watchman']) !!}
                    {!! Form::select('nationality',$nats) !!}

                    <div class="field-wrap">
                    	<label for="empnum"><input type="checkbox" name="fields[]" value="empnum" id="empnum" {{ in_array('empnum',session('fields'))?'checked':'' }}>Employee ID</label>

                    	<label for="dob"><input type="checkbox" name="fields[]" value="dob" id="dob" {{ in_array('dob',session('fields'))?'checked':'' }}>Date of Birth</label>

                    	<label for="nat"><input type="checkbox" name="fields[]" value="nat" id="nat" {{ in_array('nat',session('fields'))?'checked':'' }}>Nationality</label>

                    	<label for="jd"><input type="checkbox" name="fields[]" value="jd" id="jd" {{ in_array('jd',session('fields'))?'checked':'' }}>Join Date</label>

                    	<label for="qid"><input type="checkbox" name="fields[]" value="qid" id="qid" {{ in_array('qid',session('fields'))?'checked':'' }}>QID</label>

                    	<label for="passport"><input type="checkbox" name="fields[]" value="passport" id="passport" {{ in_array('passport',session('fields'))?'checked':'' }}>Passport</label>

                    	<label for="hc"><input type="checkbox" name="fields[]" value="hc" id="hc" {{ in_array('hc',session('fields'))?'checked':'' }}>Health Card</label>

                    	<label for="salary"><input type="checkbox" name="fields[]" value="salary" id="salary" {{ in_array('salary',session('fields'))?'checked':'' }}>Salary</label>
                    </div>
				{!! Form::submit('search') !!}
			{!! Form::close() !!}
			<a href="{{url('cancelled')}}">All Cancelled Employees</a>
			<a href="{{url('employees')}}">Employees</a>
			<p>Total: {{count($employees)}}</p>
		</div>
		@if(count($employees->toArray()))
		<div class="table-wrap">
			<table id="employees" class="emp-list">
				<thead>
	  				<tr>
					    <th rowspan="2">SN</th>
					    @if(in_array('empnum', session('fields')))
					    <th rowspan="2">Staff No.</th>
					    @endif
					    <th rowspan="2">Name</th>
					    @if(in_array('nat', session('fields')))
					    <th rowspan="2">Nationality</th>
					    @endif
					    @if(in_array('jd', session('fields')))
					    <th rowspan="2">Join Date</br><span style="display:inline-block; font-size:11px;">(dd-mm-yyyy)</span></th>
					    @endif
					    @if(in_array('dob', session('fields')))
					    <th rowspan="2">DoB</br><span style="display:inline-block; font-size:11px;">(dd-mm-yyyy)</span></th>
					    @endif
					    @if(in_array('qid', session('fields')))
					    <th colspan="2">Residency Permit</th>
					    @endif
					    @if(in_array('passport', session('fields')))
					    <th colspan="2">Passport</th>
					    @endif
					    @if(in_array('hc', session('fields')))
					    <th colspan="2">Health Card</th>
					    @endif
					    @if(in_array('salary', session('fields')))
					    <th colspan="2">Total Monthly Salary</th>
					    @endif
					    <td rowspan="2" class="ph">Tools</td>
	  				</tr>
	  				<tr>
	  				@if(in_array('qid', session('fields')))
					    <th>RP No.</th>
					    <th>Exp Date</br><span style="display:inline-block; font-size:11px;">(dd-mm-yyyy)</span></th>
					@endif
					@if(in_array('passport', session('fields')))
					    <th>PPT No.</th>
					    <th>Exp Date</br><span style="display:inline-block; font-size:11px;">(dd-mm-yyyy)</span></th>
					@endif
					@if(in_array('hc', session('fields')))
					    <th>HC No.</th>
					    <th>Exp Date</br><span style="display:inline-block; font-size:11px;">(dd-mm-yyyy)</span></th>
					@endif
					@if(in_array('salary', session('fields')))
					    <th>Basic</th>
					    <th>Allowance</th>
					@endif
	  				</tr>
				</thead>
				<tbody>
					<?php $x=1; ?>
					@foreach($employees as $emp)
					<tr>
						<td>{{$x}}</td>
						@if(in_array('empnum', session('fields')))
						<td>{{$emp->emp_id}}</td>
						@endif
						<td><a href="{{url('employees/'.$emp->id)}}">{{$emp->name}}</a></td>
						@if(in_array('nat', session('fields')))
						<td>{{$emp->nationality?$emp->nationality:'--'}}</td>
						@endif
						@if(in_array('jd', session('fields')))
						<td>{{$emp->joined?$emp->joined->format('d/m/Y'):'--'}}</td>
						@endif
						@if(in_array('dob', session('fields')))
						<td>{{$emp->dob?$emp->dob->format('d/m/Y'):'--'}}</td>
						@endif
						@if(in_array('qid', session('fields')))
						<td>{{$emp->qid?$emp->qid:'--'}}</td>
						<td>{{$emp->qid_expiry?$emp->qid_expiry->format('d/m/Y'):'--'}}</td>
						@endif
						@if(in_array('passport', session('fields')))
						<td>{{$emp->passport?$emp->passport:'--'}}</td>
						<td>{{$emp->passport_expiry?$emp->passport_expiry->format('d/m/Y'):'--'}}</td>
						@endif
						@if(in_array('hc', session('fields')))
						<td>{{$emp->health_card?$emp->health_card:'--'}}</td>
						<td>{{$emp->hc_expiry?$emp->hc_expiry->format('d/m/Y'):'--'}}</td>
						@endif
						@if(in_array('salary', session('fields')))
						<td>{{$emp->salary()->first()?$emp->salary()->first()->basic:'--'}}</td>
						<td>{{$emp->salary()->first()?$emp->salary()->first()->subTotal:'--'}}</td>
						@endif
						<td class="ph">
							<a href="{{url('employees/'.$emp->id.'/edit')}}"><i class="fa fa-wrench"></i></a>
							<a href="#delete-leanmodal" data-id="{{$emp->id}}" class="delete" rel="leanModal" title="delete"><i class="fa fa-remove"></i></a>
							{!! Form::open(['route' => ['emp-delete',$emp->id],'style' => 'display: none;','id' => 'delete'.$emp->id]) !!}{!! Form::close() !!}
						</td>
					</tr>
					<?php $x++; ?>
					@endforeach
				</tbody>
			</table>
		</div>
		
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