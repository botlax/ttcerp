@extends('dashboard')

@section('title')
Cancellation Form | {{config('app.name')}}
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
		user-times
	@endslot
	@slot('headerTitle')
		Cancellation Form
	@endslot
	@slot('content')
		<div id="form-full">
		
			{!! Form::open(['route' => ['cancel-add',$emp->id]]) !!}
				<div>
				{!! Form::textarea('reason',old('reason'),['placeholder' => 'Reason of Cancellation...','rows' => '4']) !!}
				@if ($errors->has('reason'))
	                <span class="error">
	                    <strong>{{ $errors->first('reason') }}</strong>
	                </span>
	            @endif
	            </div>
	            <div>
				{!! Form::label('cancel_date', 'Cancellation Date') !!}
				{!! Form::text('cancel_date') !!}
				@if ($errors->has('cancel_date'))
	                <span class="error">
	                    <strong>{{ $errors->first('cancel_date') }}</strong>
	                </span>
	            @endif
	            </div>

				{!! Form::submit('Submit') !!}
			{!! Form::close() !!}

		</div>
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
		$('#cancel_date').datepicker();
		$('#cancel_date').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#cancel_date').attr('value') != undefined){
			$('#cancel_date').val($('#cancel_date').attr('value').replace(' 00:00:00',''));
		}
		
	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection