@extends('dashboard')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/assets/css/print.css" />
@endsection

@section('title')
Used Visas | {{config('app.name')}}
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
		Used Visas
	@endslot
	@slot('content')
		<div id="heading" class="nh ps">
		<h4>TALAL TRADING and CONTRACTING COMPANY</h4>
		<h5>USED VISA LIST <br/>AS OF {{date('d/m/Y')}}</h5>
		</div>
		<div id="tools" class="ph">
			{!! Form::open(['method' => 'GET','route' => 'visa-used-search','id' => 'searchForm']) !!}

				{!! Form::label('occupation', 'Occupation') !!}
				{!! Form::select('occupation',['' => '--Select Occupation--', 'Accountant' => 'Accountant', 'Carpenter' => 'Carpenter', 'Civil Engineer' => 'Civil Engineer', 'Draftsman' => 'Draftsman', 'Driver' => 'Driver', 'Engineer' => 'Engineer','Foreman' => 'Foreman', 'Labor' => 'Labor','Marble Technician' => 'Marble Technician','Mason' => 'Mason','Steel Fixer' => 'Steel Fixer','Tiles Maker' => 'Tiles Maker']) !!}
				@if ($errors->has('occupation'))
                    <span class="error">
                        <strong>{{ $errors->first('occupation') }}</strong>
                    </span>
                @endif

				{!! Form::label('gender', 'Type') !!}
                {!! Form::select('gender', [''=>'--Select Type--', 'male' => 'Male','female' => 'Female'], old('gender')) !!}
                @if ($errors->has('gender'))
                    <span class="error">
                        <strong>{{ $errors->first('gender') }}</strong>
                    </span>
                @endif

                {!! Form::label('nationality', 'Nationality') !!}
                {!! Form::select('nationality', $nats, old('nationality')) !!}
                @if ($errors->has('nationality'))
                    <span class="error">
                        <strong>{{ $errors->first('nationality') }}</strong>
                    </span>
                @endif

				{!! Form::submit('search') !!}
			{!! Form::close() !!}

			<a href="{{url('visa')}}">Available Visas</a>
			<a href="{{url('visa/used')}}">Used Visas</a>
		</div>
		@if(count($visas->toArray()))
		<table id="employees" class="emp-list">
			<thead>
  				<tr>
  					<th>Emp No.</th>
  					<th>Name</th>
				    <th>Interior No.</th>
				    <th>Application No.</th>
				    <th>Year</th>
				    <th>Expiry Date</th>
				    <th>Type</th>
				    <th>Occupation</th>
				    <th>Nationality</th>
				    <th class="balance">tools</th>
  				</tr>
			</thead>
			<tbody>
				<?php $total = 0; ?>
				@foreach($visas as $visa)
				<tr>
					<td>{{$visa->user()->first()->emp_id}}</td>
					<td>{{$visa->user()->first()->name}}</td>
					<td>{{$visa->interior}}</td>
					<td>{{$visa->app_num}}</td>
					<td>{{$visa->year}}</td>
					<td>{{$visa->visaExpiry}}</td>
					<td>{{$visa->gender}}</td>
					<td>{{$visa->occupation}}</td>
					<td>{{$visa->nationality}}</td>
					<td class="ph">
						<a href="{{url('visa'.'/'.$visa->id.'/edit')}}"><i class="fa fa-wrench"></i></a>
						<a href="#delete-leanmodal" data-id="{{$visa->user()->first()->id}}" class="delete" rel="leanModal" title="delete"><i class="fa fa-remove"></i></a>
						<form method="POST" action="{{url('visa'.'/'.$visa->id.'/delete')}}" accept-charset="UTF-8" style="display: none; position: relative;" id="delete{{$visa->user()->first()->id}}">
						{{Form::token()}}
						</form>
					</td>
				</tr>
				
				@endforeach
				<tr>
					<th colspan="9">Total</th>
					<th>{{count($visas->toArray())}}</th>
				</tr>
			</tbody>
		</table>
		
		@else
			<p>No Visas.</p>
		@endif
	@endslot
@endcomponent

@endsection

@section('modal')
<div id="delete-leanmodal">
	<a class="modal_close" href="#"><i class="fa fa-close"></i></a>
	<p>This will Permanently delete this visa. Continue?</p>
	<div class="options">
		<button class="option yes">Yes</button>
		<button class="option cancel">Cancel</button>
	</div>
</div>
@endsection

@section('script')
	$(document).ready(function(){
		var visaId;
		$(document).on('click','a[rel=leanModal]',function(){
			visaId = $(this).data('id');
		});

		$('.options .yes').click(function(){
			$('#delete'+visaId).submit();
		});

	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection