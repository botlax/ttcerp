@extends('dashboard')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/assets/css/print.css" />
@endsection

@section('title')
Visas | {{config('app.name')}}
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
		Visas
	@endslot
	@slot('content')
		<div id="heading" class="nh ps">
		<h4>TALAL TRADING and CONTRACTING COMPANY</h4>
		<h5>VISA LIST <br/>AS OF {{date('d/m/Y')}}</h5>
		</div>
		<div id="tools" class="ph">
			{!! Form::open(['method' => 'GET','route' => 'visa-search','id' => 'searchForm']) !!}

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
			<a href="#" class="compress">Compress Results</a>
			<a href="#" class="expand" 
				data-occupation="{{$occupation}}"
				data-nationality="{{$nationality}}"
				data-gender="{{$gender}}">Expand Results</a>
		</div>
		@if(count($visas->toArray()))
		<table id="employees" class="emp-list">
			<thead>
  				<tr>
				    <th>Interior No.</th>
				    <th>Application No.</th>
				    <th>Year</th>
				    <th>Expiry Date</th>
				    <th>Type</th>
				    <th>Occupation</th>
				    <th>Nationality</th>
				    <th class="balance">Balance</th>
  				</tr>
			</thead>
			<tbody>
				<?php $total = 0; ?>
				@foreach($visas as $visa)
				<tr>
					<td>{{$visa->interior}}</td>
					<td>{{$visa->app_num}}</td>
					<td>{{$visa->year}}</td>
					<td>{{$visa->visaExpiry}}</td>
					<td>{{$visa->gender}}</td>
					<td>{{$visa->occupation}}</td>
					<td>{{$visa->nationality}}</td>
					<td>{{$visa->total}}</td>
				</tr>
				<?php $total = $total + $visa->total; ?>
				@endforeach
				<tr>
					<td colspan="7"></td>
					<th>{{$total}}</th>
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

		$.ajaxSetup({
        	headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
      	});

		$(document).on('click','.expand',function(){
			
			var gender = $(this).data('gender');
			var occupation = $(this).data('occupation');
			var nationality = $(this).data('nationality');

			$.ajax({
			    url: '{{url('visa/search-expand')}}',
			    dataType:'JSON',
			    type: "POST",
			    data: {'gender':gender,'occupation':occupation,'nationality':nationality,'status':'available'},
			    success: function(data){
			    	$('#employees tbody').html('');
			    	var visas = '';
			    	for(var i in data){
			    		visas = visas + '<tr><td>'+data[i]['interior']+'</td>' + '<td>'+data[i]['app_num']+'</td>' + '<td>'+data[i]['year']+'</td>' + '<td>'+data[i]['visaExpiry']+'</td>' + '<td>'+data[i]['gender']+'</td>' + '<td>'+data[i]['occupation']+'</td>' + '<td>'+data[i]['nationality']+'</td>' + '<td class="ph"><a href="{{url('/')}}/visa/'+data[i]['id']+'/edit"><i class="fa fa-wrench"></i></a><a href="#delete-leanmodal" data-id="'+data[i]['id']+'" class="delete" rel="leanModal" title="delete"><i class="fa fa-remove"></i></a><form method="POST" action="{{url('/')}}/visa/'+data[i]['id']+'/delete" accept-charset="UTF-8" style="display: none; position: relative;" id="delete'+data[i]['id']+'"><input name="_token" type="hidden" value="'+$('meta[name=_token]').attr('content')+'"></form></td></tr>';
			    	}
			    	$('#employees .balance').html('Tools').addClass('ph');
			    	$('#employees tbody').html(visas);
			    },
			    error: function(data){

			    }
			});


			return false;
		});

		$(document).on('click','.compress',function(){

			location.reload();
			return false;
		});
		
	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection