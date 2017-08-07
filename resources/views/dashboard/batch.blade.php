@extends('dashboard')

@section('title')
Batch Upload | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		files
	@endslot
	@slot('headerTitle')
		Batch Upload
	@endslot
	@slot('content')
		{!! Form::open(['route' => 'batch-upload','id' => 'emp-add','files' => true]) !!}
        <div class="row clearfix">
            <div class="5u">
                
                @if (count($errors->messages()))
                <div class="error-wrap">
                    <ul class="error">
                    @foreach($errors->messages() as $error)
                        <li>{{ $error[0] }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif

                @if(!empty(session('fails')))
                <p>The following filenames did not match any of employee records.</p>
                <div class="error-wrap">
                    <ul class="error">
                    @foreach(session('fails') as $fail)
                        <li>{{$fail}}</li>
                    @endforeach
                    </ul>
                </div>

                {{session(['fails'=>null])}}

                @endif
        		<div>
        			{!! Form::label('files[]', 'Upload Files',['class' => 'full']) !!}
        			{!! Form::file('files[]',['multiple','class'=>'inputfile','data-multiple-caption' => '{count} files selected']) !!}
        			
                </div>
        		
                <div>            
                    {!! Form::label('file_type', 'File Type') !!}
                    {!! Form::select('file_type', ['' => '--Select File Type--','photo' => 'Photos', 'cv' => 'CV', 'contract' => 'Contract', 'qid' => 'QID', 'passport' => 'Passport', 'visa' => 'Visa', 'job_offer' => 'Job Offer', 'blood_group' => 'Blood Group', 'diploma' => 'Diploma', 'englic' => 'MMUP License', 'hc_file' => 'Health Card'], old('file_type')) !!}
                    
                </div>
        			{!! Form::submit('Add') !!}
            </div>
        </div>
		{!! Form::close() !!}
	@endslot
@endcomponent

@endsection

@section('script')
$(document).ready(function(){
	
});
@endsection