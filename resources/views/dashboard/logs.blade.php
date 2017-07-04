@extends('dashboard')

@section('title')
Logs | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		bars
	@endslot
	@slot('headerTitle')
		logs
	@endslot
	@slot('content')
		@if($logs->toArray()['total'] != 0)
			<ul id="employees">
			@foreach($logs as $log)
				<li>
					<p><i class="fa fa-arrow-right"></i> {{$log->user()->first()->name}} {{$log->logs}} ({{$log->log_date->format('F d, Y - g:ia')}})</p>
				</li>
			@endforeach
			</ul>
		@else
			<p>No Logs.</p>
		@endif

		{{ $logs->links() }}
	@endslot
@endcomponent

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

		function search(){
			$.ajax({
			    url: '{{url('employees/search')}}',
			    dataType:'JSON',
			    type: "POST",
			    data: {'search':$('#searchForm #search').val()},
			    success: function(data){
			    	$('ul#employees').html('');
			    	for(var i in data){
			    		$('ul#employees').append('<li><a href="{{url('vacation')}}/'+data[i].id+'/add">'+data[i].name+'</a></li>');
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
			    		$('ul#employees').append('<li><a href="{{url('vacation')}}/'+data[i].id+'/add">'+data[i].name+'</a></li>');
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
	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection