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
		<h5>NAME LIST OF EMPLOYEES {{strtoupper($adj)}} {{strtoupper($attr)}}<br/>AS OF {{date('d/m/Y')}}</h5>

		</div>
		<div id="tools" class="ph">
			{!! Form::open(['method' => 'GET','route' => 'emp-search','id' => 'searchForm']) !!}
				{!! Form::text('q','') !!}
				{!! Form::select('position',['' => '--Select Position--',
                    'Accountant'  =>  'Accountant',
                    'Assist. Foreman'  =>  'Assist. Foreman',
                    'Block Mason' =>  'Block Mason',
                    'Camp Boss'   =>  'Camp Boss' ,
                    'Camp Cleaner' =>  'Camp Cleaner',
                    'Camp Security'  =>  'Camp Security',
                    'Civil Engineer-Purchase'   =>  'Civil Engineer-Purchase',
                    'Decorative Painter'  =>  'Decorative Painter',
                    'Draftsman'    =>  'Draftsman',
                    'Driver'    =>  'Driver',
                    'Elect / Plumber'  =>  'Elect / Plumber',
                    'Executive Manager'   =>  'Executive Manager',
                    'General Manager'   =>  'General Manager',
                    'General Service Assistant'   =>  'General Service Assistant',
                    'General Service Manager'   =>  'General Service Manager',
                    'Head Of Tender Department'   =>  'Head Of Tender Department',
                    'Heavy Driver'  =>  'Heavy Driver',
                    'In-charge, Steel Fixer Grp' =>  'In-charge, Steel Fixer Grp',
                    'In-charge, Painter Grp' =>  'In-charge, Painter Grp',
                    'In-charge, Mason Grp' =>  'In-charge, Mason Grp',
                    'JCB Operator' =>  'JCB Operator',
                    'Labourer'   =>  'Labourer',
                    'Leadman'    =>  'Leadman',
                    'Male Nurse'  =>  'Male Nurse',
                    'Mason'    =>  'Mason',
                    'Mechanic'  =>  'Mechanic',
                    'Mechanic Assistant' =>  'Mechanic Assistant',
                    'Office Boy'   =>  'Office Boy',
                    'Office Security'  =>  'Office Security',
                    'Painter' =>  'Painter',
                    'Plumber' =>  'Plumber',
                    'Project Engineer'    =>  'Project Engineer',
                    'Project Manager'   =>  'Project Manager',
                    'Public Relation Manager'    =>  'Public Relation Manager',
                    'Purchase Representative' =>  'Purchase Representative',
                    'QS / Estimator'  =>  'QS / Estimator',
                    'Safety Officer'   =>  'Safety Officer',
                    'Secretary'    =>  'Secretary',
                    'Secretary/IT Assistant'    =>  'Secretary/IT Assistant',
                    'Shutter Carpenter'    =>  'Shutter Carpenter',
                    'Steel Fixer'   =>  'Steel Fixer',
                    'Store Kepeer'    =>  'Store Kepeer',
                    'Technical Engineer' =>  'Technical Engineer',
                    'Timekeeper'   =>  'Timekeeper',
                    'Watchman' =>  'Watchman']) !!}
                    {!! Form::select('nationality',$nats) !!}
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
				    <th rowspan="2">Join Date</br><span style="display:inline-block; font-size:11px;">(dd-mm-yyyy)</span></th>
				    <th rowspan="2">DoB</br><span style="display:inline-block; font-size:11px;">(dd-mm-yyyy)</span></th>
				    <th colspan="2">Residency Permit</th>
				    <th colspan="2">Passport</th>
				    <th colspan="2">Total Monthly Salary</th>
  				</tr>
  				<tr>
				    <td>RP No.</td>
				    <td>Exp Date</br><span style="display:inline-block; font-size:11px;">(dd-mm-yyyy)</span></td>
				    <td>PPT No.</td>
				    <td>Exp Date</br><span style="display:inline-block; font-size:11px;">(dd-mm-yyyy)</span></td>
				    <td>Basic</td>
				    <td>Allowance</td>
				    <td class="ph">Tools</td>
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
		//search---------------------------------
/*
		function search(){
			$.ajax({
			    url: '{{url('employees/search')}}',
			    dataType:'JSON',
			    type: "POST",
			    data: {'search':$('#searchForm #search').val()},
			    success: function(data){
			    	$('table#employees tbody').html('');
			    	var x = 1;
			    	for(var i in data){
			    		$('table#employees tbody').append('<li><a href="{{url('employees')}}/'+data[i].id+'">'+data[i].emp_id+' - '+data[i].name+'</a><a href="{{url('employees')}}/'+data[i].id+'/edit"><i class="fa fa-wrench"></i></a><a href="#delete-leanmodal" data-id="'+data[i].id+'" class="delete" rel="leanModal" title="delete"><i class="fa fa-remove"></i></a><form method="POST" action="{{url('employees')}}/'+data[i].id+'/delete" accept-charset="UTF-8" style="display: none;" id="delete'+data[i].id+'"><input name="_token" type="hidden" value="'+$('meta[name=_token]').attr('content')+'"></form></li>');
			    		x++;
			    	}
			      	
			    },
			    error: function(jqXhr ) {
			    	if( jqXhr.status === 422 ) {
				        //process validation errors here.
				        $errors = jqXhr.responseJSON; //this will get the errors response data.
				        //show them somewhere in the markup
				        //e.g
				       
				        errorsHtml = '<div class="alert alert-danger"><ul>';
				        $.each( $errors, function( key, value ) {
				            errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
				        });
				        errorsHtml += '</ul></di>';
				            
				        alert(errorsHtml);
			        }
			        else{
			        	$('body').html(jqXhr.responseText);
			        }
			    }
			});
		}

		function searchAll(){
			$.ajax({
			    url: '{{url('employees/all')}}',
			    dataType:'JSON',
			    type: "POST",
			    data: {},
			    success: function(data){
			    	$('ul#employees').html('');
			    	for(var i in data){
			    		$('ul#employees').append('<li><a href="{{url('employees')}}/'+data[i].id+'">'+data[i].emp_id+' - '+data[i].name+'</a><a href="{{url('employees')}}/'+data[i].id+'/edit"><i class="fa fa-wrench"></i></a><a href="#delete-leanmodal" data-id="'+data[i].id+'" class="delete" rel="leanModal" title="delete"><i class="fa fa-remove"></i></a><form method="POST" action="{{url('employees')}}/'+data[i].id+'/delete" accept-charset="UTF-8" style="display: none;" id="delete'+data[i].id+'"><input name="_token" type="hidden" value="'+$('meta[name=_token]').attr('content')+'"></form></li>');
			    	}
			    },
			});
		}

		$.ajaxSetup({
	    	headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	  	});
		timer = 0;
		function mySearch (){ 
		    var s = $.trim($('#searchForm #search').val());
		    if(s != ''){
		    	search();
		    }
		    else{
		    	searchAll();
		    }
		  	
		}
		$('#searchForm #search').on('keyup', function(e){
		    if (timer) {
		        clearTimeout(timer);
		    }
		    timer = setTimeout(mySearch, 500);
		});

		$('#searchForm').submit(function(e){
			e.preventDefault();
			search();
		});

		*/
	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection