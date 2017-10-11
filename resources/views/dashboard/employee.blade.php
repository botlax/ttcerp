@extends('dashboard')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/assets/css/print.css" />
@endsection

@section('title')
{{$emp->name}} | {{config('app.name')}}
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
		user
	@endslot
	@slot('headerTitle')
		{{$emp->name}}
	@endslot
	@slot('content')
	<div id="emp-nav" class="ph">
		@if($prev)
			<a href="{{url('employees').'/'.$prev->id}}" class="emp-prev"><i class="fa fa-arrow-left"></i></a>
		@endif

		@if($next)
			<a href="{{url('employees').'/'.$next->id}}" class="emp-next"><i class="fa fa-arrow-right"></i></a>
		@endif
	</div>

	<div id="heading" class="nh ps">
	<h4>TALAL TRADING and CONTRACTING COMPANY</h4>
	<h5>Employee Details of {{$emp->name}}</h5>
	</div>

	<div class="row clearfix">
		<div class="4u empMain">
			@if($files)
				@if($files->photo)
				<img src="{{$files->photo}}" width="200" alt="{{$emp->name}}">
				<div class="tools ph">
					{!! Form::open(['route' => ['file-update',$files->id], 'files' => true]) !!}
						{!! Form::hidden('field','photo') !!}
						{!! Form::label('photo','Upload Photo',['class'=>'uploadMain']) !!}
						{!! Form::file('photo',['class'=>'inputfile']) !!}
						@if ($errors->has('photo'))
			                <span class="error">
			                    <strong>{{ $errors->first('photo') }}</strong>
			                </span>
			            @endif
			            {!! Form::submit('upload',['class' => 'thick']) !!}
					{!! Form::close() !!}
					{!! Form::open(['route' => ['file-delete',$files->id]]) !!}
						{!! Form::hidden('field','photo') !!}
			            {!! Form::submit('Delete Photo',['class' => 'delete']) !!}
					{!! Form::close() !!}
				</div>
				@else
				<img src="{{url('images/user.png')}}" width="100" alt="{{$emp->name}}">
				<div class="tools ph">
				{!! Form::open(['route' => ['file-update',$files->id], 'files' => true]) !!}
					{!! Form::hidden('field','photo') !!}
					{!! Form::label('photo','Upload Photo',['class'=>'uploadMain']) !!}
					{!! Form::file('photo',['class'=>'inputfile']) !!}
					@if ($errors->has('photo'))
		                <span class="error">
		                    <strong>{{ $errors->first('photo') }}</strong>
		                </span>
		            @endif
		            {!! Form::submit('upload',['class' => 'thick']) !!}
				{!! Form::close() !!}
				</div>
				@endif
			@else
			<img src="{{url('images/user.png')}}" width="100" alt="{{$emp->name}}">
			<div class="tools ph">
			{!! Form::open(['route' => ['file-add',$emp->id], 'files' => true]) !!}
				{!! Form::label('photo','Upload Photo',['class'=>'uploadMain']) !!}
				{!! Form::file('photo',['class'=>'inputfile']) !!}
				@if ($errors->has('photo'))
	                <span class="error">
	                    <strong>{{ $errors->first('photo') }}</strong>
	                </span>
	            @endif
	            {!! Form::submit('upload',['class' => 'thick']) !!}
			{!! Form::close() !!}
			</div>
			@endif
			<!--============Employee Number===========-->
			<div class="separate">
			<p>Employee #: {{$emp->emp_id or '--'}}</p>
			<a href="#" data-field="emp_id" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'emp_idForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::text('emp_id', old('emp_id'),['required','id'=>'emp_id']) !!}
				@if ($errors->has('emp_id'))
	                <span class="error">
	                    <strong>{{ $errors->first('emp_id') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
			<!--============Name===========-->
			<div class="separate">
			<p>Name: {{$emp->name or '--'}}</p>
			<a href="#" data-field="name" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'nameForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::text('name', old('name'),['required','id'=>'name']) !!}
				@if ($errors->has('name'))
	                <span class="error">
	                    <strong>{{ $errors->first('name') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
			<!--============Position===========-->
			<div class="separate">
			<p>Position: {{$emp->position or '--'}} {{$emp->location?'@':''}} {{$emp->location_prefix or ''}}{{$emp->location or ''}}</p>
			<a href="#" data-field="position" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'positionForm', 'class' => 'userUpdateForm']) !!}
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
                    'Watchman' =>  'Watchman'], $emp->position?$emp->position:null,['required','id'=>'position']) !!}
				@if ($errors->has('position'))
	                <span class="error">
	                    <strong>{{ $errors->first('position') }}</strong>
	                </span>
	            @endif

	            <div>
                {!! Form::select('location_prefix', ['' => '--', 'P' => 'P', 'M' => 'M', 'PI' => 'PI'],old('location_prefix'), ['style' => 'width:70px;']) !!}
                {!! Form::text('location', old('location'),['style' => 'width:100px;']) !!}
                @if ($errors->has('location'))
                    <span class="error">
                        <strong>{{ $errors->first('location') }}</strong>
                    </span>
                @endif
                @if ($errors->has('location_prefix'))
                    <span class="error">
                        <strong>{{ $errors->first('location_prefix') }}</strong>
                    </span>
                @endif
                </div>
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
			<!--============Nationality===========-->
			<div class="separate">
			<p>Nationality: {{$emp->nationality or '--'}}</p>
			<a href="#" data-field="nationality" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'nationalityForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::select('nationality',$nats, $emp->nationality?strtolower($emp->nationality):null,['required','id'=>'nationality']) !!}
				@if ($errors->has('nationality'))
	                <span class="error">
	                    <strong>{{ $errors->first('nationality') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
			<!--============Religion===========-->
			<div class="separate">
			@if($emp->religion)
			<p>Religion: {{$emp->religion}}</p>
			<a href="#" data-field="religion" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['emp-drop',$emp->id],'class' => 'emp-delete']) !!}
	            {!! Form::hidden('field','religion') !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<p>Religion: <a href="#" data-field="religion" rel="formOpen"><i class="fa fa-plus">Add Religion</i></a></p>
			@endif

			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'religionForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::select('religion', ['' => '--Select Religion--', 'muslim' => 'Muslim', 'hindu' => 'Hindu', 'christian' => 'Christian', 'others' => 'Others'],$emp->religion?strtolower($emp->religion):null) !!}
	            @if ($errors->has('religion'))
	                <span class="error">
	                    <strong>{{ $errors->first('religion') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>

			<!--============Gender===========-->
			<div class="separate">
			@if($emp->gender)
			<p>Gender: {{$emp->gender}}</p>
			<a href="#" data-field="gender" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['emp-drop',$emp->id],'class' => 'emp-delete']) !!}
	            {!! Form::hidden('field','gender') !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<p>Gender: <a href="#" data-field="gender" rel="formOpen"><i class="fa fa-plus">Add Gender</i></a></p>
			@endif
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'genderForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::select('gender', ['' => '--Select Gender--', 'male' => 'Male', 'female' => 'Female'],$emp->gender?strtolower($emp->gender):null) !!}
	            @if ($errors->has('gender'))
	                <span class="error">
	                    <strong>{{ $errors->first('gender') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
			<!--============Join Date===========-->
			<div class="separate">
			<p>Joined Date: {{$emp->joined?$emp->joined->format('F d, Y'):'--'}}</p>
			<a href="#" data-field="joined" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'joinedForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::text('joined', old('joined'),['required', 'placeholder'=>'yyyy-mm-dd','id'=>'joined']) !!}
				@if ($errors->has('joined'))
	                <span class="error">
	                    <strong>{{ $errors->first('joined') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
			<!--============Date of Birth===========-->
			<div class="separate">
			@if($emp->dob)
			<p>Date of Birth: {{$emp->dob->format('F d, Y')}}</p>
			<a href="#" data-field="dob" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['emp-drop',$emp->id],'class' => 'emp-delete']) !!}
	            {!! Form::hidden('field','dob') !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<p>Date of Birth: <a href="#" data-field="dob" rel="formOpen"><i class="fa fa-plus">Add Date of Birth</i></a></p>
			@endif

			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'dobForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::text('dob', old('dob'),['placeholder'=>'yyyy-mm-dd','id'=>'dob']) !!}
				@if ($errors->has('dob'))
	                <span class="error">
	                    <strong>{{ $errors->first('dob') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
		</div>
		<div class="8u sub-emp">
		<!--============QID===========-->
			<div class="separate">
			<h4>QID</h4>
			@if($emp->qid && $emp->qid_expiry)
			<p>No.: {{$emp->qid}}</p>
			<p>Expiry: {{$emp->qid_expiry->format('F d, Y')}}</p>
			<a href="#" data-field="qid" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['emp-drop',$emp->id],'class' => 'emp-delete']) !!}
	            {!! Form::hidden('field','qid') !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<a href="#" data-field="qid" rel="formOpen"><i class="fa fa-plus">Add QID</i></a>
			@endif
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'qidForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::label('qid', 'QID') !!}
				{!! Form::text('qid', old('qid')) !!}
				@if ($errors->has('qid'))
	                <span class="error">
	                    <strong>{{ $errors->first('qid') }}</strong>
	                </span>
	            @endif
	            {!! Form::label('qid_expiry', 'QID Expiry') !!}
				{!! Form::text('qid_expiry', old('qid_expiry'),['placeholder'=>'yyyy-mm-dd']) !!}
				@if ($errors->has('qid_expiry'))
	                <span class="error">
	                    <strong>{{ $errors->first('qid_expiry') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
		<!--============Passport===========-->
			<div class="separate">
			<h4>Passport</h4>
			@if($emp->passport && $emp->passport_expiry)
			<p>No.: {{$emp->passport}}</p>
			<p>Expiry: {{$emp->passport_expiry->format('F d, Y')}}</p>
			<a href="#" data-field="passport" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['emp-drop',$emp->id],'class' => 'emp-delete']) !!}
	            {!! Form::hidden('field','passport') !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<a href="#" data-field="passport" rel="formOpen"><i class="fa fa-plus">Add passport</i></a>
			@endif
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'passportForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::label('passport', 'Passport') !!}
				{!! Form::text('passport', old('passport')) !!}
				@if ($errors->has('passport'))
	                <span class="error">
	                    <strong>{{ $errors->first('passport') }}</strong>
	                </span>
	            @endif
	            {!! Form::label('passport_expiry', 'Passport Expiry') !!}
				{!! Form::text('passport_expiry', old('passport_expiry'),['placeholder'=>'yyyy-mm-dd']) !!}
				@if ($errors->has('passport_expiry'))
	                <span class="error">
	                    <strong>{{ $errors->first('passport_expiry') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
		<!--============Health Card===========-->
			<div class="separate">
			<h4>Health Card</h4>
			@if($emp->health_card && $emp->hc_expiry)
			<p>No.: {{$emp->health_card}}</p>
			<p>Expiry: {{$emp->hc_expiry->format('F d, Y')}}</p>
			<a href="#" data-field="health_card" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['emp-drop',$emp->id],'class' => 'emp-delete']) !!}
	            {!! Form::hidden('field','health_card') !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<a href="#" data-field="health_card" rel="formOpen"><i class="fa fa-plus">Add health card</i></a>
			@endif
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'health_cardForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::label('health_card', 'Health Card') !!}
				{!! Form::text('health_card', old('health_card')) !!}
				@if ($errors->has('health_card'))
	                <span class="error">
	                    <strong>{{ $errors->first('health_card') }}</strong>
	                </span>
	            @endif
	            {!! Form::label('hc_expiry', 'Health Card Expiry') !!}
				{!! Form::text('hc_expiry', old('hc_expiry'),['placeholder'=>'yyyy-mm-dd']) !!}
				@if ($errors->has('hc_expiry'))
	                <span class="error">
	                    <strong>{{ $errors->first('hc_expiry') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
		<!--============Emergency Contact===========-->
			<div class="separate">
			<h4>Emergency Contact</h4>
			@if($emergency)
			<p>Name: {{$emergency->kin?$emergency->kin:'--'}}</p>
			<p>Relation: {{$emergency->relation?$emergency->relation:'--'}}</p>
			<p>Contact: {{$emergency->contact?$emergency->contact:'--'}}</p>
			<p>Address: {{$emergency->address?$emergency->address:'--'}}</p>
			<a href="#" data-field="emergency" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['emergency-drop',$emergency->id],'class' => 'emp-delete']) !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<a href="#" data-field="emergency" rel="formOpen"><i class="fa fa-plus">Add Emergency Contact</i></a>
			@endif
			{!! Form::model($emergency,['route' => ['emergency-update',$emp->id], 'id' => 'emergencyForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::label('kin', 'Name') !!}
				{!! Form::text('kin', old('kin')) !!}
				@if ($errors->has('kin'))
	                <span class="error">
	                    <strong>{{ $errors->first('kin') }}</strong>
	                </span>
	            @endif
	            {!! Form::label('relation', 'Relation') !!}
				{!! Form::text('relation', old('relation')) !!}
				@if ($errors->has('relation'))
	                <span class="error">
	                    <strong>{{ $errors->first('relation') }}</strong>
	                </span>
	            @endif
	            {!! Form::label('contact', 'Contact') !!}
				{!! Form::text('contact', old('contact')) !!}
				@if ($errors->has('contact'))
	                <span class="error">
	                    <strong>{{ $errors->first('contact') }}</strong>
	                </span>
	            @endif
	            {!! Form::label('address', 'Address') !!}
				{!! Form::text('address', old('address')) !!}
				@if ($errors->has('address'))
	                <span class="error">
	                    <strong>{{ $errors->first('address') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
		<!--============Driving License===========-->
			<div class="separate">
			<h4>Driving License</h4>
			@if($emp->license()->first())
			<p class="ph">Scan copy: @if($emp->license()->first()->file) <a href="{{$emp->license()->first()->file}}">License <i class="fa fa-download"></i></a> @else -- @endif</p>
			<p>Type: {{$emp->license()->first()->type or '--'}}</p>
			<p>License No.: {{$emp->license()->first()->license or '--'}}</p>
			<p>Expiry: {{$emp->license()->first()?$emp->license()->first()->expiry_date->format('F d, Y'):'--'}}</p>
			<a href="#" data-field="license" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['lic-drop',$emp->license()->first()->id]]) !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}

			{!! Form::model($emp->license()->first(),['route' => ['lic-update',$emp->id], 'id' => 'licenseForm', 'class' => 'userUpdateForm','files' => true]) !!}

				{!! Form::label('type','License Type') !!}
	            {!! Form::select('type',['' => '--Select License Type--','heavy' => 'Heavy', 'light' => 'Light', 'equipment' => 'Equipment'],$emp->license()->first()?strtolower($emp->license()->first()->type):null) !!}
	            @if ($errors->has('type'))
	                <span class="error">
	                    <strong>{{ $errors->first('type') }}</strong>
	                </span>
	            @endif

	            {!! Form::label('expiry_date','Expiry Date') !!}
	            {!! Form::text('expiry_date',old('expiry_date'),['placeholder'=>'yyyy-mm-dd']) !!}
	            @if ($errors->has('expiry_date'))
	                <span class="error">
	                    <strong>{{ $errors->first('expiry_date') }}</strong>
	                </span>
	            @endif

	            {!! Form::label('file','Upload Scan Copy',['class' => 'emp-file']) !!}
	            {!! Form::file('file',['class'=>'inputfile']) !!}
	            @if ($errors->has('file'))
	                <span class="error">
	                    <strong>{{ $errors->first('file') }}</strong>
	                </span>
	            @endif

	            {!! Form::submit('update') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<a href="#" data-field="license" rel="formOpen"><i class="fa fa-plus">Add License</i></a>
			{!! Form::open(['route' => ['lic-store',$emp->id], 'id' => 'licenseForm', 'class' => 'userUpdateForm','files' => true]) !!}

				{!! Form::label('type','License Type') !!}
	            {!! Form::select('type',['' => '--Select License Type--','heavy' => 'Heavy', 'light' => 'Light', 'equipment' => 'Equipment'],$emp->license()->first()?strtolower($emp->license()->first()->type):null) !!}
	            @if ($errors->has('type'))
	                <span class="error">
	                    <strong>{{ $errors->first('type') }}</strong>
	                </span>
	            @endif

	            {!! Form::label('expiry_date','Expiry Date') !!}
	            {!! Form::text('expiry_date',old('expiry_date'),['placeholder'=>'yyyy-mm-dd']) !!}
	            @if ($errors->has('expiry_date'))
	                <span class="error">
	                    <strong>{{ $errors->first('expiry_date') }}</strong>
	                </span>
	            @endif

	            {!! Form::label('file','Upload Scan Copy',['class' => 'emp-file']) !!}
	            {!! Form::file('file',['class'=>'inputfile']) !!}
	            @if ($errors->has('file'))
	                <span class="error">
	                    <strong>{{ $errors->first('file') }}</strong>
	                </span>
	            @endif

	            {!! Form::submit('add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@endif
			</div>
		<!--============Mobile===========-->
			<div class="separate">
			<h4>Mobile</h4>
			@if($emp->mobile)
			<p>{{$emp->mobile}}</p>
			<a href="#" data-field="mobile" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['emp-drop',$emp->id],'class' => 'emp-delete']) !!}
	            {!! Form::hidden('field','mobile') !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<a href="#" data-field="mobile" rel="formOpen"><i class="fa fa-plus">Add Mobile No.</i></a>
			@endif
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'mobileForm', 'class' => 'userUpdateForm']) !!}
				{!! Form::label('mobile', 'Mobile #') !!}
	            {!! Form::text('mobile', old('mobile')) !!}
				@if ($errors->has('mobile'))
	                <span class="error">
	                    <strong>{{ $errors->first('mobile') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
		<!--============Status===========-->
			<div class="separate">
			<h4>Marital Status</h4>
			@if($emp->status)
			<p>{{$emp->status}}</p>
			<a href="#" data-field="status" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['emp-drop',$emp->id],'class' => 'emp-delete']) !!}
	            {!! Form::hidden('field','status') !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<a href="#" data-field="status" rel="formOpen"><i class="fa fa-plus">Add Marital Status</i></a>
			@endif
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'statusForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::select('status', ['' => '--Select Status--', 'single' => 'Single', 'married' => 'Married'],$emp->status?strtolower($emp->status):null) !!}
				@if ($errors->has('status'))
	                <span class="error">
	                    <strong>{{ $errors->first('status') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
		<!--============Children===========-->
			<div class="separate">
			<h4>No. of Children</h4>
			@if($emp->children)
			<p>{{$emp->children}}</p>
			<a href="#" data-field="children" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['emp-drop',$emp->id],'class' => 'emp-delete']) !!}
	            {!! Form::hidden('field','children') !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<a href="#" data-field="children" rel="formOpen"><i class="fa fa-plus">Add no. of children</i></a>
			@endif
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'childrenForm', 'class' => 'userUpdateForm']) !!}
				{!! Form::label('children', 'Children') !!}
	            {!! Form::text('children', old('children')) !!}
				@if ($errors->has('children'))
	                <span class="error">
	                    <strong>{{ $errors->first('children') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
		<!--============Degree===========-->
			<div class="separate">
			<h4>Education / Career</h4>
			@if($emp->degree)
			<p>Degree: {{$emp->degree}}</p>
			<p>Graduation Date: {{$emp->grad_date->format('F d, Y')}}</p>
			<p>Years of Experience: {{$emp->work_start_date->diffInYears(\Carbon\Carbon::today())}}</p>
			<a href="#" data-field="degree" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['emp-drop',$emp->id],'class' => 'emp-delete']) !!}
	            {!! Form::hidden('field','degree') !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<a href="#" data-field="degree" rel="formOpen"><i class="fa fa-plus">Add Education / Career</i></a>
			@endif
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'degreeForm', 'class' => 'userUpdateForm']) !!}
				{!! Form::label('degree', 'Degree') !!}	
	            {!! Form::text('degree', old('degree')) !!}
				@if ($errors->has('degree'))
	                <span class="error">
	                    <strong>{{ $errors->first('degree') }}</strong>
	                </span>
	            @endif

	            {!! Form::label('grad_date', 'Graduation Date') !!}
	            {!! Form::text('grad_date', old('grad_date'),['placeholder'=>'yyyy-mm-dd','id'=>'grad_date']) !!}
				@if ($errors->has('grad_date'))
	                <span class="error">
	                    <strong>{{ $errors->first('grad_date') }}</strong>
	                </span>
	            @endif

	            {!! Form::label('work_start_date', 'Professional Start Date') !!}
	            {!! Form::text('work_start_date', old('work_start_date'),['placeholder'=>'yyyy-mm-dd','id'=>'work_start_date']) !!}
				@if ($errors->has('work_start_date'))
	                <span class="error">
	                    <strong>{{ $errors->first('work_start_date') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
			
		<!--============Airport===========-->
			<div class="separate">
			<h4>Home Destination Airport</h4>
			@if($emp->airport)
			<p>{{$emp->airport}}</p>
			<a href="#" data-field="airport" rel="formOpen"><i class="fa fa-wrench"></i></a>
			{!! Form::open(['route' => ['emp-drop',$emp->id],'class' => 'emp-delete']) !!}
	            {!! Form::hidden('field','airport') !!}
				<button class="delete-entry"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			@else
			<a href="#" data-field="airport" rel="formOpen"><i class="fa fa-plus">Add home destination airport</i></a>
			@endif
			{!! Form::model($emp,['route' => ['emp-update',$emp->id], 'id' => 'airportForm', 'class' => 'userUpdateForm']) !!}
	            {!! Form::select('airport', [], $emp->airport?$emp->airport:null,['id' => 'airport']) !!}
				@if ($errors->has('airport'))
	                <span class="error">
	                    <strong>{{ $errors->first('airport') }}</strong>
	                </span>
	            @endif
				{!! Form::submit('Add') !!}
				<button class="cancel"><i class="fa fa-remove"></i></button>
			{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div class="row tab clearfix ph">
		<div class="3u">
			<ul id="empNav">
				<li><a href="#files" class="active" rel="empTab">Files</a></li>
				<li><a href="#vacation" rel="empTab">Vacation</a></li>
				<li><a href="#leave" rel="empTab">Leave</a></li>
				<li><a href="#salary" rel="empTab">Salary</a></li>
				<li><a href="#warning" rel="empTab">Warning</a></li>
				<li><a href="#ai" rel="empTab">Accidents / Injuries</a></li>
				<li><a href="#ot" rel="empTab">Others</a></li>
			</ul>
		</div>
		<div class="9u">
			<div id="empPanel">
				<div id="files">
				@if($files)
					<ul>
						<li>CV:
							@if($files->cv)
							<a href="{{$files->cv}}"><i class="fa fa-download"></i></a>
							{!! Form::open(['route' => ['file-delete',$files->id]]) !!}
								{!! Form::hidden('field','cv') !!}
					            {!! Form::submit('delete',['class' => 'file-delete']) !!}
							{!! Form::close() !!}
							
							@endif
							{!! Form::open(['route' => ['file-update',$files->id], 'files' => true, 'class' => 'file-form']) !!}
								{!! Form::hidden('field','cv') !!}
								{!! Form::label('cv','Upload CV',['class' => 'upload-label']) !!}
								{!! Form::file('cv',['class'=>'inputfile']) !!}
								@if ($errors->has('cv'))
					                <span class="error">
					                    <strong>{{ $errors->first('cv') }}</strong>
					                </span>
					            @endif
					            {!! Form::submit('upload') !!}
					        {!! Form::close() !!}
						</li>
						<li>Passport: 
							@if($files->passport)
							<a href="{{$files->passport}}"><i class="fa fa-download"></i></a>
							{!! Form::open(['route' => ['file-delete',$files->id]]) !!}
								{!! Form::hidden('field','passport') !!}
					            {!! Form::submit('delete',['class' => 'file-delete']) !!}
							{!! Form::close() !!}
							@endif
							{!! Form::open(['route' => ['file-update',$files->id], 'files' => true, 'class' => 'file-form']) !!}
								{!! Form::hidden('field','passport') !!}
								{!! Form::label('passport1','Upload Passport',['class' => 'upload-label']) !!}
								{!! Form::file('passport1',['class'=>'inputfile']) !!}
								@if ($errors->has('passport'))
					                <span class="error">
					                    <strong>{{ $errors->first('passport') }}</strong>
					                </span>
					            @endif
					            {!! Form::submit('upload') !!}
							{!! Form::close() !!}
						</li>
						<li>QID: 
							@if($files->qid)
							<a href="{{$files->qid}}"><i class="fa fa-download"></i></a>
							{!! Form::open(['route' => ['file-delete',$files->id]]) !!}
								{!! Form::hidden('field','qid') !!}
					            {!! Form::submit('delete',['class' => 'file-delete']) !!}
							{!! Form::close() !!}
							
							@endif
							{!! Form::open(['route' => ['file-update',$files->id], 'files' => true, 'class' => 'file-form']) !!}
								{!! Form::hidden('field','qid') !!}
								{!! Form::label('qid1','Upload QID',['class' => 'upload-label']) !!}
								{!! Form::file('qid1',['class'=>'inputfile']) !!}
								@if ($errors->has('qid'))
					                <span class="error">
					                    <strong>{{ $errors->first('qid') }}</strong>
					                </span>
					            @endif
					            {!! Form::submit('upload') !!}
							{!! Form::close() !!}
						</li>
						<li>Health Card: 
							@if($files->hc_file)
							<a href="{{$files->hc_file}}"><i class="fa fa-download"></i></a>
							{!! Form::open(['route' => ['file-delete',$files->id]]) !!}
								{!! Form::hidden('field','hc_file') !!}
					            {!! Form::submit('delete',['class' => 'file-delete']) !!}
							{!! Form::close() !!}
							
							@endif
							{!! Form::open(['route' => ['file-update',$files->id], 'files' => true, 'class' => 'file-form']) !!}
								{!! Form::hidden('field','hc_file') !!}
								{!! Form::label('hc_file','Upload Health Card',['class' => 'upload-label']) !!}
								{!! Form::file('hc_file',['class'=>'inputfile']) !!}
								@if ($errors->has('hc_file'))
					                <span class="error">
					                    <strong>{{ $errors->first('hc_file') }}</strong>
					                </span>
					            @endif
					            {!! Form::submit('upload') !!}
							{!! Form::close() !!}
						</li>
						<li>Diploma: 
							@if($files->diploma)
							<a href="{{$files->diploma}}"><i class="fa fa-download"></i></a>
							{!! Form::open(['route' => ['file-delete',$files->id]]) !!}
								{!! Form::hidden('field','diploma') !!}
					            {!! Form::submit('delete',['class' => 'file-delete']) !!}
							{!! Form::close() !!}
							
							@endif
							{!! Form::open(['route' => ['file-update',$files->id], 'files' => true, 'class' => 'file-form']) !!}
								{!! Form::hidden('field','diploma') !!}
								{!! Form::label('diploma','Upload Diploma',['class' => 'upload-label']) !!}
								{!! Form::file('diploma',['class'=>'inputfile']) !!}
								@if ($errors->has('diploma'))
					                <span class="error">
					                    <strong>{{ $errors->first('diploma') }}</strong>
					                </span>
					            @endif
					            {!! Form::submit('upload') !!}
							{!! Form::close() !!}
						</li>
						<li>MMUP License: 
							@if($files->englic)
							<a href="{{$files->englic}}"><i class="fa fa-download"></i></a>
							{!! Form::open(['route' => ['file-delete',$files->id]]) !!}
								{!! Form::hidden('field','englic') !!}
					            {!! Form::submit('delete',['class' => 'file-delete']) !!}
							{!! Form::close() !!}
							
							@endif
							{!! Form::open(['route' => ['file-update',$files->id], 'files' => true, 'class' => 'file-form']) !!}
								{!! Form::hidden('field','englic') !!}
								{!! Form::label('englic','Upload MMUP License',['class' => 'upload-label']) !!}
								{!! Form::file('englic',['class'=>'inputfile']) !!}
								@if ($errors->has('englic'))
					                <span class="error">
					                    <strong>{{ $errors->first('englic') }}</strong>
					                </span>
					            @endif
					            {!! Form::submit('upload') !!}
							{!! Form::close() !!}
						</li>
						<li>Contract: 
							@if($files->contract)
							<a href="{{$files->contract}}"><i class="fa fa-download"></i></a>
							{!! Form::open(['route' => ['file-delete',$files->id]]) !!}
								{!! Form::hidden('field','contract') !!}
					            {!! Form::submit('delete',['class' => 'file-delete']) !!}
							{!! Form::close() !!}
							
							@endif
							{!! Form::open(['route' => ['file-update',$files->id], 'files' => true, 'class' => 'file-form']) !!}
								{!! Form::hidden('field','contract') !!}
								{!! Form::label('contract','Upload Contract',['class' => 'upload-label']) !!}
								{!! Form::file('contract',['class'=>'inputfile']) !!}
								@if ($errors->has('contract'))
					                <span class="error">
					                    <strong>{{ $errors->first('contract') }}</strong>
					                </span>
					            @endif
					            {!! Form::submit('upload') !!}
							{!! Form::close() !!}
							
						</li>
						<li>Visa: 
							@if($files->visa)
							<a href="{{$files->visa}}"><i class="fa fa-download"></i></a>
							{!! Form::open(['route' => ['file-delete',$files->id]]) !!}
								{!! Form::hidden('field','visa') !!}
					            {!! Form::submit('delete',['class' => 'file-delete']) !!}
							{!! Form::close() !!}
							@endif
							{!! Form::open(['route' => ['file-update',$files->id], 'files' => true, 'class' => 'file-form']) !!}
								{!! Form::hidden('field','visa') !!}
								{!! Form::label('visa','Upload Visa',['class' => 'upload-label']) !!}
								{!! Form::file('visa',['class'=>'inputfile']) !!}
								@if ($errors->has('visa'))
					                <span class="error">
					                    <strong>{{ $errors->first('visa') }}</strong>
					                </span>
					            @endif
					            {!! Form::submit('upload') !!}
							{!! Form::close() !!}
						</li>
						<li>Blood Group: 
							@if($files->blood_group)
							<a href="{{$files->blood_group}}"><i class="fa fa-download"></i></a>
							{!! Form::open(['route' => ['file-delete',$files->id]]) !!}
								{!! Form::hidden('field','blood_group') !!}
					            {!! Form::submit('delete',['class' => 'file-delete']) !!}
							{!! Form::close() !!}
							@endif
							{!! Form::open(['route' => ['file-update',$files->id], 'files' => true, 'class' => 'file-form']) !!}
								{!! Form::hidden('field','blood_group') !!}
								{!! Form::label('blood_group','Upload Blood Group',['class' => 'upload-label']) !!}
								{!! Form::file('blood_group',['class'=>'inputfile']) !!}
								@if ($errors->has('blood_group'))
					                <span class="error">
					                    <strong>{{ $errors->first('blood_group') }}</strong>
					                </span>
					            @endif
					            {!! Form::submit('upload') !!}
							{!! Form::close() !!}
							
						</li>
						<li>Job Offer:
							@if($files->job_offer)
							<a href="{{$files->job_offer}}"><i class="fa fa-download"></i></a>
							{!! Form::open(['route' => ['file-delete',$files->id]]) !!}
								{!! Form::hidden('field','job_offer') !!}
					            {!! Form::submit('delete',['class' => 'file-delete']) !!}
							{!! Form::close() !!}
							@endif
							{!! Form::open(['route' => ['file-update',$files->id], 'files' => true, 'class' => 'file-form']) !!}
								{!! Form::hidden('field','job_offer') !!}
								{!! Form::label('job_offer','Upload Job Offer',['class' => 'upload-label']) !!}
								{!! Form::file('job_offer',['class'=>'inputfile']) !!}
								@if ($errors->has('job_offer'))
					                <span class="error">
					                    <strong>{{ $errors->first('job_offer') }}</strong>
					                </span>
					            @endif
					            {!! Form::submit('upload') !!}
							{!! Form::close() !!}
							
						</li>
					</ul>
				@else

				{!! Form::open(['route' => ['file-add',$emp->id], 'files' => true, 'class' => 'file-form', 'id' => 'file-add-form']) !!}
					<div>
						{!! Form::label('cv','Upload CV',['class' => 'upload-label']) !!}
						{!! Form::file('cv',['class'=>'inputfile']) !!}
						@if ($errors->has('cv'))
			                <span class="error">
			                    <strong>{{ $errors->first('cv') }}</strong>
			                </span>
			            @endif
					</div>
					<div>
						{!! Form::label('passport1','Upload Passport',['class' => 'upload-label']) !!}
						{!! Form::file('passport1',['class'=>'inputfile']) !!}
						@if ($errors->has('passport'))
			                <span class="error">
			                    <strong>{{ $errors->first('passport') }}</strong>
			                </span>
			            @endif
					</div>
					<div>
						{!! Form::label('qid1','Upload QID',['class' => 'upload-label']) !!}
						{!! Form::file('qid1',['class'=>'inputfile']) !!}
						@if ($errors->has('qid'))
			                <span class="error">
			                    <strong>{{ $errors->first('qid') }}</strong>
			                </span>
			            @endif
					</div>
					<div>
						{!! Form::label('hc_file','Upload Health Card',['class' => 'upload-label']) !!}
						{!! Form::file('hc_file',['class'=>'inputfile']) !!}
						@if ($errors->has('hc_file'))
			                <span class="error">
			                    <strong>{{ $errors->first('hc_file') }}</strong>
			                </span>
			            @endif
					</div>
					<div>
						{!! Form::label('diploma','Upload Diploma',['class' => 'upload-label']) !!}
						{!! Form::file('diploma',['class'=>'inputfile']) !!}
						@if ($errors->has('diploma'))
			                <span class="error">
			                    <strong>{{ $errors->first('diploma') }}</strong>
			                </span>
			            @endif
					</div>
					<div>
						{!! Form::label('englic','Upload MMUP License',['class' => 'upload-label']) !!}
						{!! Form::file('englic',['class'=>'inputfile']) !!}
						@if ($errors->has('englic'))
			                <span class="error">
			                    <strong>{{ $errors->first('englic') }}</strong>
			                </span>
			            @endif
					</div>
					<div>
						{!! Form::label('contract','Upload Contract',['class' => 'upload-label']) !!}
						{!! Form::file('contract',['class'=>'inputfile']) !!}
						@if ($errors->has('contract'))
			                <span class="error">
			                    <strong>{{ $errors->first('contract') }}</strong>
			                </span>
			            @endif
					</div>
					<div>
						{!! Form::label('visa','Upload Visa',['class' => 'upload-label']) !!}
						{!! Form::file('visa',['class'=>'inputfile']) !!}
						@if ($errors->has('visa'))
			                <span class="error">
			                    <strong>{{ $errors->first('visa') }}</strong>
			                </span>
			            @endif
					</div>
					<div>
						{!! Form::label('blood_group','Upload Blood Group',['class' => 'upload-label']) !!}
						{!! Form::file('blood_group',['class'=>'inputfile']) !!}
						@if ($errors->has('blood_group'))
			                <span class="error">
			                    <strong>{{ $errors->first('blood_group') }}</strong>
			                </span>
			            @endif
					</div>
					<div>
						{!! Form::label('job_offer','Upload Job Offer',['class' => 'upload-label']) !!}
						{!! Form::file('job_offer',['class'=>'inputfile']) !!}
						@if ($errors->has('job_offer'))
			                <span class="error">
			                    <strong>{{ $errors->first('job_offer') }}</strong>
			                </span>
			            @endif
					</div>
					<div>
						{!! Form::submit('Add') !!}
					</div>
				{!! Form::close() !!}

				@endif
				</div>

				<div id="vacation">
				@if($emp->vacation()->first())
					<p><a href="#" data-field="vacation" rel="formOpen"><i class="fa fa-plus"></i>Add Vacation</a></p>
					@if($vacation['on'])
					<h5>{{$emp->name}} is currently on vacation.</h5>
					
					{!! Form::model($vacation['current'],['route' => ['vac-update',$vacation['current']->id], 'id' => 'vacation'.$vacation['current']->id.'Form', 'class' => 'userUpdateForm','files' => true]) !!}
			            <div>
			            {!! Form::label('vac_from','From') !!}
			            {!! Form::text('vac_from',old('vac_from'),['placeholder'=>'yyyy-mm-dd','id'=>'vac_from']) !!}
			            @if ($errors->has('vac_from'))
			                <span class="error">
			                    <strong>{{ $errors->first('vac_from') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('vac_to','To') !!}
			            {!! Form::text('vac_to',old('vac_to'),['placeholder'=>'yyyy-mm-dd','id'=>'vac_to']) !!}
			            @if ($errors->has('vac_to'))
			                <span class="error">
			                    <strong>{{ $errors->first('vac_to') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('vac_from_time','Departure') !!}
			            {!! Form::text('vac_from_time',old('vac_from_time'),['class' => 'time-input']) !!}
			            @if ($errors->has('vac_from_time'))
			                <span class="error">
			                    <strong>{{ $errors->first('vac_from_time') }}</strong>
			                </span>
			            @endif
			            </div>
			           	<div>
			            {!! Form::label('vac_to_time','Arrival') !!}
			            {!! Form::text('vac_to_time',old('vac_to_time'),['class' => 'time-input']) !!}
			            @if ($errors->has('vac_to_time'))
			                <span class="error">
			                    <strong>{{ $errors->first('vac_to_time') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('airlines','Airlines') !!}
			            {!! Form::text('airlines',old('airlines'),['placeholder' => 'Type it.. :)']) !!}
			            @if ($errors->has('airlines'))
			                <span class="error">
			                    <strong>{{ $errors->first('airlines') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('ticket','Upload Ticket',['class' => 'upload-label']) !!}
			            {!! Form::file('ticket',['class'=>'inputfile']) !!}
			            @if ($errors->has('ticket'))
			                <span class="error">
			                    <strong>{{ $errors->first('ticket') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('exit_permit','Upload Exit Permit',['class' => 'upload-label']) !!}
			            {!! Form::file('exit_permit',['class'=>'inputfile']) !!}
			            @if ($errors->has('exit_permit'))
			                <span class="error">
			                    <strong>{{ $errors->first('exit_permit') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('original_form','Upload Original Form',['class' => 'upload-label']) !!}
			            {!! Form::file('original_form',['class'=>'inputfile']) !!}
			            @if ($errors->has('original_form'))
			                <span class="error">
			                    <strong>{{ $errors->first('original_form') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('vacation_form','Upload Vacation Settlement',['class' => 'upload-label']) !!}
			            {!! Form::file('vacation_form',['class'=>'inputfile']) !!}
			            @if ($errors->has('vacation_form'))
			                <span class="error">
			                    <strong>{{ $errors->first('vacation_form') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('leave_wpay','Days Payable') !!}
			            {!! Form::text('leave_wpay') !!}
			            @if ($errors->has('leave_wpay'))
			                <span class="error">
			                    <strong>{{ $errors->first('leave_wpay') }}</strong>
			                </span>
			            @endif
			            </div>
						{!! Form::submit('Update') !!}
						<button class="cancel"><i class="fa fa-remove"></i></button>
					{!! Form::close() !!}
					<ul>
						<a href="#" class="data-tool" data-field="vacation{{$vacation['current']->id}}" rel="formOpen"><i class="fa fa-wrench"></i></a>
						{!! Form::open(['route' => ['vac-drop',$vacation['current']->id],'class' => 'data-tool']) !!}
							<button class="delete-entry"><i class="fa fa-remove"></i></button>
						{!! Form::close() !!}
						<li>From: {{$vacation['current']->vac_from->format('F d, Y')}}</li>
						<li>To:
							<?php
								if($vacation['current']->vac_from->diffInDays($vacation['current']->vac_to) == 171){
									echo 'Open';
								}
								else{
									echo $vacation['current']->vac_to->format('F d, Y');
								}
							?>
						</li>
						<li>Departure: {{$vacation['current']->vac_from_time?$vacation['current']->vac_from_time->format('F d, Y g:i a'):''}}</li>
						<li>Arrival: {{$vacation['current']->vac_to_time?$vacation['current']->vac_to_time->format('F d, Y g:i a'):''}}</li>
						<li>Airlines: {{$vacation['current']->airlines}}</li>
						<li>Ticket: <a href="{{$vacation['current']->ticket?$vacation['current']->ticket:'#'}}">Ticket <i class="fa fa-download"></i></a></li>
						<li>Exit Permit: <a href="{{$vacation['current']->exit_permit?$vacation['current']->exit_permit:'#'}}">Exit Permit <i class="fa fa-download"></i></a></li>
						<li>Original Form: <a href="{{$vacation['current']->original_form?$vacation['current']->original_form:'#'}}">Original Form <i class="fa fa-download"></i></a></li>
						<li>Vacation Settlement: <a href="{{$vacation['current']->vacation_form?$vacation['current']->vacation_form:'#'}}">Vacation Settlement <i class="fa fa-download"></i></a></li>
						@if($emp->salary()->first())
						<li>Leave Pay: QAR {{round(intval($vacation['current']->leave_wpay)*($emp->salary()->first()->total/30),2)}}</li>
						@else
						<li>Leave Pay: Please add salary details to obtain total leave pay.</li>
						@endif
					</ul>
					@endif

					@if($vacation['upcoming'])
					<h5>Upcoming Vacation</h5>
					
					{!! Form::model($vacation['upcoming'],['route' => ['vac-update',$vacation['upcoming']->id], 'id' => 'vacation'.$vacation['upcoming']->id.'Form', 'class' => 'userUpdateForm','files' => true]) !!}
			            <div>
			            {!! Form::label('vac_from','From') !!}
			            {!! Form::text('vac_from',old('vac_from'),['placeholder'=>'yyyy-mm-dd','id'=>'vac_from']) !!}
			            @if ($errors->has('vac_from'))
			                <span class="error">
			                    <strong>{{ $errors->first('vac_from') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('vac_to','To') !!}
			            {!! Form::text('vac_to',old('vac_to'),['placeholder'=>'yyyy-mm-dd','id'=>'vac_to']) !!}
			            @if ($errors->has('vac_to'))
			                <span class="error">
			                    <strong>{{ $errors->first('vac_to') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('vac_from_time','Departure') !!}
			            {!! Form::text('vac_from_time',old('vac_from_time'),['class' => 'time-input']) !!}
			            @if ($errors->has('vac_from_time'))
			                <span class="error">
			                    <strong>{{ $errors->first('vac_from_time') }}</strong>
			                </span>
			            @endif
			            </div>
			           	<div>
			            {!! Form::label('vac_to_time','Arrival') !!}
			            {!! Form::text('vac_to_time',old('vac_to_time'),['class' => 'time-input']) !!}
			            @if ($errors->has('vac_to_time'))
			                <span class="error">
			                    <strong>{{ $errors->first('vac_to_time') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('airlines','Airlines') !!}
			            {!! Form::text('airlines',old('airlines'),['placeholder' => 'Type it.. :)']) !!}
			            @if ($errors->has('airlines'))
			                <span class="error">
			                    <strong>{{ $errors->first('airlines') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('ticket','Upload Ticket',['class' => 'upload-label']) !!}
			            {!! Form::file('ticket',['class'=>'inputfile']) !!}
			            @if ($errors->has('ticket'))
			                <span class="error">
			                    <strong>{{ $errors->first('ticket') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('exit_permit','Upload Exit Permit',['class' => 'upload-label']) !!}
			            {!! Form::file('exit_permit',['class'=>'inputfile']) !!}
			            @if ($errors->has('exit_permit'))
			                <span class="error">
			                    <strong>{{ $errors->first('exit_permit') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('original_form','Upload Original Form',['class' => 'upload-label']) !!}
			            {!! Form::file('original_form',['class'=>'inputfile']) !!}
			            @if ($errors->has('original_form'))
			                <span class="error">
			                    <strong>{{ $errors->first('original_form') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('vacation_form','Upload Vacation Settlement',['class' => 'upload-label']) !!}
			            {!! Form::file('vacation_form',['class'=>'inputfile']) !!}
			            @if ($errors->has('vacation_form'))
			                <span class="error">
			                    <strong>{{ $errors->first('vacation_form') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('leave_wpay','Days Payable') !!}
			            {!! Form::text('leave_wpay') !!}
			            @if ($errors->has('leave_wpay'))
			                <span class="error">
			                    <strong>{{ $errors->first('leave_wpay') }}</strong>
			                </span>
			            @endif
			            </div>
						{!! Form::submit('Update') !!}
						<button class="cancel"><i class="fa fa-remove"></i></button>
					{!! Form::close() !!}
					<ul>
						<a href="#" class="data-tool" data-field="vacation{{$vacation['upcoming']->id}}" rel="formOpen"><i class="fa fa-wrench"></i></a>
						{!! Form::open(['route' => ['vac-drop',$vacation['upcoming']->id],'class' => 'data-tool']) !!}
							<button class="delete-entry"><i class="fa fa-remove"></i></button>
						{!! Form::close() !!}
						<li>From: {{$vacation['upcoming']->vac_from->format('F d, Y')}}</li>
						<li>To:
							<?php
								if($vacation['upcoming']->vac_from->diffInDays($vacation['upcoming']->vac_to) == 171){
									echo 'Open';
								}
								else{
									echo $vacation['upcoming']->vac_to->format('F d, Y');
								}
							?>
						</li>
						<li>Departure: {{$vacation['upcoming']->vac_from_time?$vacation['upcoming']->vac_from_time->format('F d, Y g:i a'):''}}</li>
						<li>Arrival: {{$vacation['upcoming']->vac_to_time?$vacation['upcoming']->vac_to_time->format('F d, Y g:i a'):''}}</li>
						<li>Airlines: {{$vacation['upcoming']->airlines}}</li>
						<li>Ticket: <a href="{{$vacation['upcoming']->ticket?$vacation['upcoming']->ticket:'#'}}">Ticket <i class="fa fa-download"></i></a></li>
						<li>Exit Permit: <a href="{{$vacation['upcoming']->exit_permit?$vacation['upcoming']->exit_permit:'#'}}">Exit Permit <i class="fa fa-download"></i></a></li>
						<li>Original Form: <a href="{{$vacation['upcoming']->original_form?$vacation['upcoming']->original_form:'#'}}">Original Form <i class="fa fa-download"></i></a></li>
						<li>Vacation Settlement: <a href="{{$vacation['upcoming']->vacation_form?$vacation['upcoming']->vacation_form:'#'}}">Vacation Settlement <i class="fa fa-download"></i></a></li>
						@if($emp->salary()->first())
						<li>Leave Pay: QAR {{round(intval($vacation['upcoming']->leave_wpay)*($emp->salary()->first()->total/30),2)}}</li>
						@else
						<li>Leave Pay: Please add salary details to obtain total leave pay.</li>
						@endif
					</ul>
					@endif
					@if($vacation['past'])
					<h5>Vacation History</h5>
					
					@foreach($vacation['past'] as $vac)
					
					{!! Form::model($vac,['route' => ['vac-update',$vac->id], 'id' => 'vacation'.$vac->id.'Form', 'class' => 'userUpdateForm','files' => true]) !!}
			            <div>
			            {!! Form::label('vac_from','From') !!}
			            {!! Form::text('vac_from',old('vac_from'),['placeholder'=>'yyyy-mm-dd','id'=>'vac_from']) !!}
			            @if ($errors->has('vac_from'))
			                <span class="error">
			                    <strong>{{ $errors->first('vac_from') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('vac_to','To') !!}
			            {!! Form::text('vac_to',old('vac_to'),['placeholder'=>'yyyy-mm-dd','id'=>'vac_to']) !!}
			            @if ($errors->has('vac_to'))
			                <span class="error">
			                    <strong>{{ $errors->first('vac_to') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('vac_from_time','Departure') !!}
			            {!! Form::text('vac_from_time',old('vac_from_time'),['class' => 'time-input']) !!}
			            @if ($errors->has('vac_from_time'))
			                <span class="error">
			                    <strong>{{ $errors->first('vac_from_time') }}</strong>
			                </span>
			            @endif
			            </div>
			           	<div>
			            {!! Form::label('vac_to_time','Arrival') !!}
			            {!! Form::text('vac_to_time',old('vac_to_time'),['class' => 'time-input']) !!}
			            @if ($errors->has('vac_to_time'))
			                <span class="error">
			                    <strong>{{ $errors->first('vac_to_time') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('airlines','Airlines') !!}
			            {!! Form::text('airlines',old('airlines'),['placeholder' => 'Type it.. :)']) !!}
			            @if ($errors->has('airlines'))
			                <span class="error">
			                    <strong>{{ $errors->first('airlines') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('ticket','Upload Ticket',['class' => 'upload-label']) !!}
			            {!! Form::file('ticket',['class'=>'inputfile']) !!}
			            @if ($errors->has('ticket'))
			                <span class="error">
			                    <strong>{{ $errors->first('ticket') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('exit_permit','Upload Exit Permit',['class' => 'upload-label']) !!}
			            {!! Form::file('exit_permit',['class'=>'inputfile']) !!}
			            @if ($errors->has('exit_permit'))
			                <span class="error">
			                    <strong>{{ $errors->first('exit_permit') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('original_form','Upload Original Form',['class' => 'upload-label']) !!}
			            {!! Form::file('original_form',['class'=>'inputfile']) !!}
			            @if ($errors->has('original_form'))
			                <span class="error">
			                    <strong>{{ $errors->first('original_form') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('vacation_form','Upload Vacation Settlement',['class' => 'upload-label']) !!}
			            {!! Form::file('vacation_form',['class'=>'inputfile']) !!}
			            @if ($errors->has('vacation_form'))
			                <span class="error">
			                    <strong>{{ $errors->first('vacation_form') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('leave_wpay','Days Payable') !!}
			            {!! Form::text('leave_wpay') !!}
			            @if ($errors->has('leave_wpay'))
			                <span class="error">
			                    <strong>{{ $errors->first('leave_wpay') }}</strong>
			                </span>
			            @endif
			            </div>
						{!! Form::submit('Update') !!}
						<button class="cancel"><i class="fa fa-remove"></i></button>
					{!! Form::close() !!}

					<ul>
						<a href="#" class="data-tool" data-field="vacation{{$vac->id}}" rel="formOpen"><i class="fa fa-wrench"></i></a>
						{!! Form::open(['route' => ['vac-drop',$vac->id],'class' => 'data-tool']) !!}
							<button class="delete-entry"><i class="fa fa-remove"></i></button>
						{!! Form::close() !!}
						<li>From: {{$vac->vac_from->format('F d, Y')}}</li>
						<li>To:
							<?php
								if($vac->vac_from->diffInDays($vac->vac_to) == 171){
									echo 'Open';
								}
								else{
									echo $vac->vac_to->format('F d, Y');
								}
							?>
						</li>
						<li>Departure: {{$vac->vac_from_time?$vac->vac_from_time->format('F d, Y g:i a'):''}}</li>
						<li>Arrival: {{$vac->vac_to_time?$vac->vac_to_time->format('F d, Y g:i a'):''}}</li>
						<li>Airlines: {{$vac->airlines}}</li>
						<li>Ticket: <a href="{{$vac->ticket?$vac->ticket:'#'}}">Ticket <i class="fa fa-download"></i></a></li>
						<li>Exit Permit: <a href="{{$vac->exit_permit?$vac->exit_permit:'#'}}">Exit Permit <i class="fa fa-download"></i></a></li>
						<li>Original Form: <a href="{{$vac->original_form?$vac->original_form:'#'}}">Original Form <i class="fa fa-download"></i></a></li>
						<li>Vacation Settlement: <a href="{{$vac->vacation_form?$vac->vacation_form:'#'}}">Vacation Settlement <i class="fa fa-download"></i></a></li>
						@if($emp->salary()->first())
						<li>Leave Pay: QAR {{round(intval($vac->leave_wpay)*($emp->salary()->first()->total/30),2)}}</li>
						@else
						<li>Leave Pay: Please add salary details to obtain total leave pay.</li>
						@endif
					</ul>
					@endforeach
					@endif
					
				@else
					<p class="note">No recorded vacation. Add a record below:</p>
					<a href="#" data-field="vacation" rel="formOpen"><i class="fa fa-plus"></i>Add Vacation</a>
				@endif

				{!! Form::open(['route' => ['vac-store',$emp->id], 'id' => 'vacationForm', 'class' => 'userUpdateForm','files' => true]) !!}
					<div>
		            {!! Form::label('vac_from','From') !!}
		            {!! Form::text('vac_from',old('vac_from'),['placeholder'=>'yyyy-mm-dd','id'=>'add_from']) !!}
		            @if ($errors->has('vac_from'))
		                <span class="error">
		                    <strong>{{ $errors->first('vac_from') }}</strong>
		                </span>
		            @endif
		            </div>
		            <div>
		            {!! Form::label('vac_to','To') !!}
		            {!! Form::text('vac_to',old('vac_to'),['placeholder'=>'yyyy-mm-dd','id'=>'add_to']) !!}
		            @if ($errors->has('vac_to'))
		                <span class="error">
		                    <strong>{{ $errors->first('vac_to') }}</strong>
		                </span>
		            @endif
		            </div>
		            <div>
		            {!! Form::label('vac_from_time','Departure') !!}
		            {!! Form::text('vac_from_time',old('vac_from_time'),['class' => 'time-input']) !!}
		            @if ($errors->has('vac_from_time'))
		                <span class="error">
		                    <strong>{{ $errors->first('vac_from_time') }}</strong>
		                </span>
		            @endif
		            </div>
		           	<div>
		            {!! Form::label('vac_to_time','Arrival') !!}
		            {!! Form::text('vac_to_time',old('vac_to_time'),['class' => 'time-input']) !!}
		            @if ($errors->has('vac_to_time'))
		                <span class="error">
		                    <strong>{{ $errors->first('vac_to_time') }}</strong>
		                </span>
		            @endif
		            </div>
		            <div>
		            {!! Form::label('airlines','Airlines') !!}
		            {!! Form::text('airlines',old('airlines'),['placeholder' => 'Type it.. :)']) !!}
		            @if ($errors->has('airlines'))
		                <span class="error">
		                    <strong>{{ $errors->first('airlines') }}</strong>
		                </span>
		            @endif
		            </div>
		            <div>
		            {!! Form::label('ticket','Upload Ticket',['class' => 'upload-label']) !!}
		            {!! Form::file('ticket',['class'=>'inputfile']) !!}
		            @if ($errors->has('ticket'))
		                <span class="error">
		                    <strong>{{ $errors->first('ticket') }}</strong>
		                </span>
		            @endif
		            </div>
		            <div>
		            {!! Form::label('exit_permit','Upload Exit Permit',['class' => 'upload-label']) !!}
		            {!! Form::file('exit_permit',['class'=>'inputfile']) !!}
		            @if ($errors->has('exit_permit'))
		                <span class="error">
		                    <strong>{{ $errors->first('exit_permit') }}</strong>
		                </span>
		            @endif
		            </div>
		            <div>
		            {!! Form::label('original_form','Upload Original Form',['class' => 'upload-label']) !!}
		            {!! Form::file('original_form',['class'=>'inputfile']) !!}
		            @if ($errors->has('original_form'))
		                <span class="error">
		                    <strong>{{ $errors->first('original_form') }}</strong>
		                </span>
		            @endif
		            </div>
		            <div>
		            {!! Form::label('vacation_form','Upload Vacation Settlement',['class' => 'upload-label']) !!}
		            {!! Form::file('vacation_form',['class'=>'inputfile']) !!}
		            @if ($errors->has('vacation_form'))
		                <span class="error">
		                    <strong>{{ $errors->first('vacation_form') }}</strong>
		                </span>
		            @endif
		            </div>
		            <div>
		            {!! Form::label('leave_wpay','Days Payable') !!}
		            {!! Form::text('leave_wpay') !!}
		            @if ($errors->has('leave_wpay'))
		                <span class="error">
		                    <strong>{{ $errors->first('leave_wpay') }}</strong>
		                </span>
		            @endif
		            </div>
		           	
		            {!! Form::submit('add') !!}
		            <button class="cancel"><i class="fa fa-remove"></i></button>
				{!! Form::close() !!}
				</div>

				<div id="leave">
				@if($emp->leave()->first())
					<p><a href="#" data-field="leave" rel="formOpen"><i class="fa fa-plus"></i>Add Leave</a></p>
					@foreach($emp->leave()->orderBy('leave_from','DESC')->get() as $leave)
					
					{!! Form::model($leave,['route' => ['leave-update',$leave->id], 'id' => 'leave'.$leave->id.'Form', 'class' => 'userUpdateForm','files' => true]) !!}
			            <div>
			            {!! Form::label('type','Type') !!}
			            {!! Form::select('type',['' => '--Select Type--','medical' => 'Medical', 'special' => 'Special']) !!}
			            @if ($errors->has('type'))
			                <span class="error">
			                    <strong>{{ $errors->first('type') }}</strong>
			                </span>
			            @endif
			            </div>
						<div>
			            {!! Form::label('leave_from','From') !!}
			            {!! Form::text('leave_from',old('leave_from'),['placeholder'=>'yyyy-mm-dd','id'=>'leave_from']) !!}
			            @if ($errors->has('leave_from'))
			                <span class="error">
			                    <strong>{{ $errors->first('leave_from') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('leave_to','To') !!}
			            {!! Form::text('leave_to',old('leave_to'),['placeholder'=>'yyyy-mm-dd','id'=>'leave_to']) !!}
			            @if ($errors->has('leave_to'))
			                <span class="error">
			                    <strong>{{ $errors->first('leave_to') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('med_cert','Upload Medical Certificate',['class' => 'upload-label']) !!}
			            {!! Form::file('med_cert',['class'=>'inputfile']) !!}
			            @if ($errors->has('med_cert'))
			                <span class="error">
			                    <strong>{{ $errors->first('med_cert') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('leave_form','Upload Leave Form',['class' => 'upload-label']) !!}
			            {!! Form::file('leave_form',['class'=>'inputfile']) !!}
			            @if ($errors->has('leave_form'))
			                <span class="error">
			                    <strong>{{ $errors->first('leave_form') }}</strong>
			                </span>
			            @endif
			            </div>
							{!! Form::submit('Update') !!}
							<button class="cancel"><i class="fa fa-remove"></i></button>
						{!! Form::close() !!}
					<ul>
						<a href="#" class="data-tool" data-field="leave{{$leave->id}}" rel="formOpen"><i class="fa fa-wrench"></i></a>
						{!! Form::open(['route' => ['leave-drop',$leave->id],'class' => 'data-tool']) !!}
							<button class="delete-entry"><i class="fa fa-remove"></i></button>
						{!! Form::close() !!}
						<li>From: {{$leave->leave_from->format('F d, Y')}}</li>
						<li>To: {{$leave->leave_to->format('F d, Y')}}</li>
						<li>Type: {{$leave->type}}</li>
						<li>Medical Certificate: <a href="{{$leave->med_cert?$leave->med_cert:'#'}}">Medical Certificate<i class="fa fa-download"></i></a></li>
						<li>Leave Form: <a href="{{$leave->leave_form?$leave->leave_form:'#'}}">Leave Form<i class="fa fa-download"></i></a></li>
					</ul>
					@endforeach
					
				@else
					<p class="note">No recorded leave. Add a record below:</p>
					<a href="#" data-field="leave" rel="formOpen"><i class="fa fa-plus"></i>Add Leave</a>
				@endif

				{!! Form::open(['route' => ['leave-store',$emp->id], 'id' => 'leaveForm', 'class' => 'userUpdateForm','files' => true]) !!}
					<div>
		            {!! Form::label('type','Type') !!}
		            {!! Form::select('type',['' => '--Select Type--','medical' => 'Medical', 'special' => 'Special']) !!}
		            @if ($errors->has('type'))
		                <span class="error">
		                    <strong>{{ $errors->first('type') }}</strong>
		                </span>
		            @endif
		            </div>
					<div>
		            {!! Form::label('leave_from','From') !!}
		            {!! Form::text('leave_from',old('leave_from'),['placeholder'=>'yyyy-mm-dd','id'=>'add_leave_from']) !!}
		            @if ($errors->has('leave_from'))
		                <span class="error">
		                    <strong>{{ $errors->first('leave_from') }}</strong>
		                </span>
		            @endif
		            </div>
		            <div>
		            {!! Form::label('leave_to','To') !!}
		            {!! Form::text('leave_to',old('leave_to'),['placeholder'=>'yyyy-mm-dd','id'=>'add_leave_to']) !!}
		            @if ($errors->has('leave_to'))
		                <span class="error">
		                    <strong>{{ $errors->first('leave_to') }}</strong>
		                </span>
		            @endif
		            </div>
		            <div>
		            {!! Form::label('med_cert','Upload Medical Certificate',['class' => 'upload-label']) !!}
		            {!! Form::file('med_cert',['class'=>'inputfile']) !!}
		            @if ($errors->has('med_cert'))
		                <span class="error">
		                    <strong>{{ $errors->first('med_cert') }}</strong>
		                </span>
		            @endif
		            </div>
		            <div>
		            {!! Form::label('leave_form','Upload Leave Form',['class' => 'upload-label']) !!}
		            {!! Form::file('leave_form',['class'=>'inputfile']) !!}
		            @if ($errors->has('leave_form'))
		                <span class="error">
		                    <strong>{{ $errors->first('leave_form') }}</strong>
		                </span>
		            @endif
		            </div>
		           	
		            {!! Form::submit('add') !!}
		            <button class="cancel"><i class="fa fa-remove"></i></button>
				{!! Form::close() !!}
				</div>

				<div id="salary">
				@if($emp->salary()->first())
					
					{!! Form::model($emp->salary()->first(),['route' => ['sal-update',$emp->id], 'id' => 'salaryForm', 'class' => 'userUpdateForm']) !!}
			            
						<div>
			            {!! Form::label('basic','Basic') !!}
			            {!! Form::text('basic',old('basic')) !!}
			            @if ($errors->has('basic'))
			                <span class="error">
			                    <strong>{{ $errors->first('basic') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('transpo','Transpo') !!}
			            {!! Form::text('transpo',old('transpo')) !!}
			            @if ($errors->has('transpo'))
			                <span class="error">
			                    <strong>{{ $errors->first('transpo') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('accomodation','Accomodation') !!}
			            {!! Form::text('accomodation',old('accomodation')) !!}
			            @if ($errors->has('accomodation'))
			                <span class="error">
			                    <strong>{{ $errors->first('accomodation') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('work_nature','Work Nature') !!}
			            {!! Form::text('work_nature',old('work_nature')) !!}
			            @if ($errors->has('work_nature'))
			                <span class="error">
			                    <strong>{{ $errors->first('work_nature') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('food','Food') !!}
			            {!! Form::text('food',old('food')) !!}
			            @if ($errors->has('food'))
			                <span class="error">
			                    <strong>{{ $errors->first('food') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('special','Special') !!}
			            {!! Form::text('special',old('special')) !!}
			            @if ($errors->has('special'))
			                <span class="error">
			                    <strong>{{ $errors->first('special') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('others','Others') !!}
			            {!! Form::text('others',old('others')) !!}
			            @if ($errors->has('others'))
			                <span class="error">
			                    <strong>{{ $errors->first('others') }}</strong>
			                </span>
			            @endif
						</div>
						{!! Form::submit('Update') !!}
						<button class="cancel"><i class="fa fa-remove"></i></button>
					{!! Form::close() !!}

					<ul>
						<a href="#" class="data-tool" data-field="salary" rel="formOpen"><i class="fa fa-wrench"></i></a>
						{!! Form::open(['route' => ['sal-drop',$emp->id],'class' => 'data-tool']) !!}
							<button class="delete-entry"><i class="fa fa-remove"></i></button>
						{!! Form::close() !!}
						<li>Basic: QAR {{$emp->salary()->first()->basic}}</li>
						<li>Transpo: QAR {{$emp->salary()->first()->transpo?$emp->salary()->first()->transpo:'--'}}</li>
						<li>Accomodation: QAR {{$emp->salary()->first()->accomodation?$emp->salary()->first()->accomodation:'--'}}</li>
						<li>Work Nature: QAR {{$emp->salary()->first()->work_nature?$emp->salary()->first()->work_nature:'--'}}</li>
						<li>Food: QAR {{$emp->salary()->first()->food?$emp->salary()->first()->food:'--'}}</li>
						<li>Special: QAR {{$emp->salary()->first()->special?$emp->salary()->first()->special:'--'}}</li>
						<li>Others: QAR {{$emp->salary()->first()->others?$emp->salary()->first()->others:'--'}}</li>
						<li>Total: QAR {{$emp->salary()->first()->total}}</li>
					</ul>
				@else
					{!! Form::open(['route' => ['sal-store',$emp->id]]) !!}
						<div>
			            {!! Form::label('basic','Basic') !!}
			            {!! Form::text('basic',old('basic')) !!}
			            @if ($errors->has('basic'))
			                <span class="error">
			                    <strong>{{ $errors->first('basic') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('transpo','Transpo') !!}
			            {!! Form::text('transpo',old('transpo')) !!}
			            @if ($errors->has('transpo'))
			                <span class="error">
			                    <strong>{{ $errors->first('transpo') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('accomodation','Accomodation') !!}
			            {!! Form::text('accomodation',old('accomodation')) !!}
			            @if ($errors->has('accomodation'))
			                <span class="error">
			                    <strong>{{ $errors->first('accomodation') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('work_nature','Work Nature') !!}
			            {!! Form::text('work_nature',old('work_nature')) !!}
			            @if ($errors->has('work_nature'))
			                <span class="error">
			                    <strong>{{ $errors->first('work_nature') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('food','Food') !!}
			            {!! Form::text('food',old('food')) !!}
			            @if ($errors->has('food'))
			                <span class="error">
			                    <strong>{{ $errors->first('food') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('special','Special') !!}
			            {!! Form::text('special',old('special')) !!}
			            @if ($errors->has('special'))
			                <span class="error">
			                    <strong>{{ $errors->first('special') }}</strong>
			                </span>
			            @endif
			            </div>
			            <div>
			            {!! Form::label('others','Others') !!}
			            {!! Form::text('others',old('others')) !!}
			            @if ($errors->has('others'))
			                <span class="error">
			                    <strong>{{ $errors->first('others') }}</strong>
			                </span>
			            @endif
						</div>
			            {!! Form::submit('add') !!}
					{!! Form::close() !!}
				@endif
				</div>
				<div id="warning">
				@if($emp->warning()->first())
					<p><a href="#" data-field="warning" rel="formOpen"><i class="fa fa-plus"></i>Add Warning</a></p>
					@foreach($emp->warning()->orderBy('warning_date','DESC')->get() as $warning)
					
					{!! Form::model($warning,['route' => ['warning-update',$warning->id], 'id' => 'warning'.$warning->id.'Form', 'class' => 'userUpdateForm','files' => true]) !!}
						
						<div>
			            {!! Form::label('violation','Violation') !!}
			            {!! Form::select('violation',['' => '--Select Violation--','company' => 'Company', 'government' => 'Government']) !!}
			            @if ($errors->has('violation'))
			                <span class="error">
			                    <strong>{{ $errors->first('violation') }}</strong>
			                </span>
			            @endif
			            </div>

			            <div>
			            {!! Form::label('warning_type','Type') !!}
			            {!! Form::select('warning_type',['' => '--Select Type--','verbal' => 'Verbal', 'warning' => 'Warning']) !!}
			            @if ($errors->has('warning_type'))
			                <span class="error">
			                    <strong>{{ $errors->first('warning_type') }}</strong>
			                </span>
			            @endif
			            </div>

			            <div>
			            {!! Form::label('warning_date','Date') !!}
			            {!! Form::text('warning_date',old('warning_date'),['placeholder'=>'yyyy-mm-dd','id'=>'warning_date']) !!}
			            @if ($errors->has('warning_date'))
			                <span class="error">
			                    <strong>{{ $errors->first('warning_date') }}</strong>
			                </span>
			            @endif
			            </div>

			            <div>
			            {!! Form::label('warning_file','Upload File',['class' => 'upload-label']) !!}
			            {!! Form::file('warning_file',['class'=>'inputfile']) !!}
			            @if ($errors->has('warning_file'))
			                <span class="error">
			                    <strong>{{ $errors->first('warning_file') }}</strong>
			                </span>
			            @endif
			            </div>
						{!! Form::submit('Update') !!}
						<button class="cancel"><i class="fa fa-remove"></i></button>
					{!! Form::close() !!}
					<ul>
						<a href="#" class="data-tool" data-field="warning{{$warning->id}}" rel="formOpen"><i class="fa fa-wrench"></i></a>
						{!! Form::open(['route' => ['warning-drop',$warning->id],'class' => 'data-tool']) !!}
							<button class="delete-entry"><i class="fa fa-remove"></i></button>
						{!! Form::close() !!}
						<li>Date: {{$warning->warning_date->format('F d, Y')}}</li>
						<li>Violation: {{$warning->violation}}</li>
						<li>Type: {{$warning->warning_type}}</li>
						<li>File: <a href="{{$warning->warning_file?$warning->warning_file:'#'}}">File<i class="fa fa-download"></i></a></li>
					</ul>
					@endforeach	
				@else
					<p class="note">No warnings recorded. Add Below.</p>
					<a href="#" data-field="warning" rel="formOpen"><i class="fa fa-plus"></i>Add Warning</a>
				@endif

				{!! Form::open(['route' => ['warning-store',$emp->id], 'id' => 'warningForm', 'class' => 'userUpdateForm','files' => true]) !!}
					
					<div>
		            {!! Form::label('violation','Violation') !!}
		            {!! Form::select('violation',['' => '--Select Violation--','company' => 'Company', 'government' => 'Government']) !!}
		            @if ($errors->has('violation'))
		                <span class="error">
		                    <strong>{{ $errors->first('violation') }}</strong>
		                </span>
		            @endif
		            </div>

		            <div>
		            {!! Form::label('warning_type','Type') !!}
		            {!! Form::select('warning_type',['' => '--Select Type--','verbal' => 'Verbal', 'warning' => 'Warning']) !!}
		            @if ($errors->has('warning_type'))
		                <span class="error">
		                    <strong>{{ $errors->first('warning_type') }}</strong>
		                </span>
		            @endif
		            </div>

		            <div>
		            {!! Form::label('warning_date','Date') !!}
		            {!! Form::text('warning_date',old('warning_date'),['placeholder'=>'yyyy-mm-dd','id'=>'add_warning_date']) !!}
		            @if ($errors->has('warning_date'))
		                <span class="error">
		                    <strong>{{ $errors->first('warning_date') }}</strong>
		                </span>
		            @endif
		            </div>

		            <div>
		            {!! Form::label('warning_file','Upload File',['class' => 'upload-label']) !!}
		            {!! Form::file('warning_file',['class'=>'inputfile']) !!}
		            @if ($errors->has('warning_file'))
		                <span class="error">
		                    <strong>{{ $errors->first('warning_file') }}</strong>
		                </span>
		            @endif
		            </div>
		           	
		            {!! Form::submit('add') !!}
		            <button class="cancel"><i class="fa fa-remove"></i></button>
				{!! Form::close() !!}
				</div>

				<div id="ai">
				@if($emp->ai()->first())
					<p><a href="#" data-field="ai" rel="formOpen"><i class="fa fa-plus"></i>Add Injury / Accident</a></p>

					@if(!empty($emp->ai()->where('ai_type','accident report')->get()->toArray()))
					<h5>Accident Reports</h5>
					@foreach($emp->ai()->where('ai_type','accident report')->orderBy('ai_date','DESC')->get() as $ai)
					
					{!! Form::model($ai,['route' => ['ai-update',$ai->id], 'id' => 'ai'.$ai->id.'Form', 'class' => 'userUpdateForm','files' => true]) !!}
						

			            <div>
			            {!! Form::label('ai_type','Type') !!}
			            {!! Form::select('ai_type',['' => '--Select Type--','accident report' => 'Accident Report', 'site injury' => 'Site Injury']) !!}
			            @if ($errors->has('ai_type'))
			                <span class="error">
			                    <strong>{{ $errors->first('ai_type') }}</strong>
			                </span>
			            @endif
			            </div>

			            <div>
			            {!! Form::label('ai_date','Date') !!}
			            {!! Form::text('ai_date',old('ai_date'),['placeholder'=>'yyyy-mm-dd','id'=>'ai_date']) !!}
			            @if ($errors->has('ai_date'))
			                <span class="error">
			                    <strong>{{ $errors->first('ai_date') }}</strong>
			                </span>
			            @endif
			            </div>

			            <div>
			            {!! Form::label('ai_file','Upload File',['class' => 'upload-label']) !!}
			            {!! Form::file('ai_file',['class'=>'inputfile']) !!}
			            @if ($errors->has('ai_file'))
			                <span class="error">
			                    <strong>{{ $errors->first('ai_file') }}</strong>
			                </span>
			            @endif
			            </div>
						
						{!! Form::submit('Update') !!}
						<button class="cancel"><i class="fa fa-remove"></i></button>
					{!! Form::close() !!}
					<ul>
						<a href="#" class="data-tool" data-field="ai{{$ai->id}}" rel="formOpen"><i class="fa fa-wrench"></i></a>
						{!! Form::open(['route' => ['ai-drop',$ai->id],'class' => 'data-tool']) !!}
							<button class="delete-entry"><i class="fa fa-remove"></i></button>
						{!! Form::close() !!}
						<li>Date: {{$ai->ai_date->format('F d, Y')}}</li>
						<li>Type: {{$ai->ai_type}}</li>
						<li>File: <a href="{{$ai->ai_file?$ai->ai_file:'#'}}">File<i class="fa fa-download"></i></a></li>
					</ul>
					@endforeach
					@endif

					@if(!empty($emp->ai()->where('ai_type','site injury')->get()->toArray()))
					<h5>Site Injuries</h5>
					@foreach($emp->ai()->where('ai_type','site injury')->orderBy('ai_date','DESC')->get() as $ai)
					
					{!! Form::model($ai,['route' => ['ai-update',$ai->id], 'id' => 'ai'.$ai->id.'Form', 'class' => 'userUpdateForm','files' => true]) !!}
						

			            <div>
			            {!! Form::label('ai_type','Type') !!}
			            {!! Form::select('ai_type',['' => '--Select Type--','accident report' => 'Accident Report', 'site injury' => 'Site Injury']) !!}
			            @if ($errors->has('ai_type'))
			                <span class="error">
			                    <strong>{{ $errors->first('ai_type') }}</strong>
			                </span>
			            @endif
			            </div>

			            <div>
			            {!! Form::label('ai_date','Date') !!}
			            {!! Form::text('ai_date',old('ai_date'),['placeholder'=>'yyyy-mm-dd','id'=>'ai_date']) !!}
			            @if ($errors->has('ai_date'))
			                <span class="error">
			                    <strong>{{ $errors->first('ai_date') }}</strong>
			                </span>
			            @endif
			            </div>

			            <div>
			            {!! Form::label('ai_file','Upload File',['class' => 'upload-label']) !!}
			            {!! Form::file('ai_file',['class'=>'inputfile']) !!}
			            @if ($errors->has('ai_file'))
			                <span class="error">
			                    <strong>{{ $errors->first('ai_file') }}</strong>
			                </span>
			            @endif
			            </div>
						
						{!! Form::submit('Update') !!}
						<button class="cancel"><i class="fa fa-remove"></i></button>
					{!! Form::close() !!}
					<ul>
						<a href="#" class="data-tool" data-field="ai{{$ai->id}}" rel="formOpen"><i class="fa fa-wrench"></i></a>
						{!! Form::open(['route' => ['ai-drop',$ai->id],'class' => 'data-tool']) !!}
							<button class="delete-entry"><i class="fa fa-remove"></i></button>
						{!! Form::close() !!}
						<li>Date: {{$ai->ai_date->format('F d, Y')}}</li>
						<li>Type: {{$ai->ai_type}}</li>
						<li>File: <a href="{{$ai->ai_file?$ai->ai_file:'#'}}">File<i class="fa fa-download"></i></a></li>
					</ul>
					@endforeach
					@endif
				@else
					<p class="note">No Site Injuries / Accident Report recorded. Add Below.</p>
					<a href="#" data-field="ai" rel="formOpen"><i class="fa fa-plus"></i>Add Injury / Accident</a>
				@endif

				{!! Form::open(['route' => ['ai-store',$emp->id], 'id' => 'aiForm', 'class' => 'userUpdateForm','files' => true]) !!}
					
		           	<div>
		            {!! Form::label('ai_type','Type') !!}
		            {!! Form::select('ai_type',['' => '--Select Type--','accident report' => 'Accident Report', 'site injury' => 'Site Injury']) !!}
		            @if ($errors->has('ai_type'))
		                <span class="error">
		                    <strong>{{ $errors->first('ai_type') }}</strong>
		                </span>
		            @endif
		            </div>

		            <div>
		            {!! Form::label('ai_date','Date') !!}
		            {!! Form::text('ai_date',old('ai_date'),['placeholder'=>'yyyy-mm-dd','id'=>'add_ai_date']) !!}
		            @if ($errors->has('ai_date'))
		                <span class="error">
		                    <strong>{{ $errors->first('ai_date') }}</strong>
		                </span>
		            @endif
		            </div>

		            <div>
		            {!! Form::label('ai_file','Upload File',['class' => 'upload-label']) !!}
		            {!! Form::file('ai_file',['class'=>'inputfile']) !!}
		            @if ($errors->has('ai_file'))
		                <span class="error">
		                    <strong>{{ $errors->first('ai_file') }}</strong>
		                </span>
		            @endif
		            </div>

		            {!! Form::submit('add') !!}
		            <button class="cancel"><i class="fa fa-remove"></i></button>
				{!! Form::close() !!}
				</div>

				<div id="ot">
				@if($emp->ot()->first())
					<p><a href="#" data-field="ot" rel="formOpen"><i class="fa fa-plus"></i>Add Record / File</a></p>
					@foreach($ot as $key => $val)
					@if($val)
						<h5>{{$key}}</h5>
						@foreach($val as $v)
						
						{!! Form::model($v,['route' => ['ot-update',$v->id], 'id' => 'ot'.$v->id.'Form', 'class' => 'userUpdateForm','files' => true]) !!}

				            <div>
				            {!! Form::label('ot_type','Type') !!}
				            {!! Form::select('ot_type',['' => '--Select Type--','increment request' => 'Increment Request', 'increment approved form' => 'Increment Approved Form', 'cash advance' => 'Cash Advance', 'personal loan' => 'Personal Loan', 'car loan' => 'Car Loan', 'salary loan' => 'Salary Loan', 'previous contract' => 'Previous Contract', 'bank account' => 'Bank Account Number']) !!}
				            @if ($errors->has('ot_type'))
				                <span class="error">
				                    <strong>{{ $errors->first('ot_type') }}</strong>
				                </span>
				            @endif
				            </div>

				            <div>
				            {!! Form::label('ot_date','Date') !!}
				            {!! Form::text('ot_date',old('ot_date'),['placeholder'=>'yyyy-mm-dd','id'=>'ot_date']) !!}
				            @if ($errors->has('ot_date'))
				                <span class="error">
				                    <strong>{{ $errors->first('ot_date') }}</strong>
				                </span>
				            @endif
				            </div>

				            <div>
				            {!! Form::label('ot_desc','Description') !!}
				            {!! Form::text('ot_desc',old('ot_desc')) !!}
				            @if ($errors->has('ot_desc'))
				                <span class="error">
				                    <strong>{{ $errors->first('ot_desc') }}</strong>
				                </span>
				            @endif
				            </div>

				            <div>
				            {!! Form::label('ot_file','Upload File',['class' => 'upload-label']) !!}
				            {!! Form::file('ot_file',['class'=>'inputfile']) !!}
				            @if ($errors->has('ot_file'))
				                <span class="error">
				                    <strong>{{ $errors->first('ot_file') }}</strong>
				                </span>
				            @endif
				            </div>
							
							{!! Form::submit('Update') !!}
							<button class="cancel"><i class="fa fa-remove"></i></button>
						{!! Form::close() !!}
						<ul>
							<a href="#" class="data-tool" data-field="ot{{$v->id}}" rel="formOpen"><i class="fa fa-wrench"></i></a>
							{!! Form::open(['route' => ['ot-drop',$v->id],'class' => 'data-tool']) !!}
								<button class="delete-entry"><i class="fa fa-remove"></i></button>
							{!! Form::close() !!}
							<li>Date: {{$v->ot_date->format('F d, Y')}}</li>
							<li>Type: {{$v->ot_type}}</li>
							<li>Description: {{$v->ot_desc or '--'}}</li>
							<li>File: <a href="{{$v->ot_file?$v->ot_file:'#'}}">File<i class="fa fa-download"></i></a></li>
						</ul>
						@endforeach
					@endif
					@endforeach
					
				@else
					<p class="note">No Records / Files. Add Below.</p>
					<a href="#" data-field="ot" rel="formOpen"><i class="fa fa-plus"></i>Add Files / Record</a>
				@endif

				{!! Form::open(['route' => ['ot-store',$emp->id], 'id' => 'otForm', 'class' => 'userUpdateForm','files' => true]) !!}
					
		           	<div>
		            {!! Form::label('ot_type','Type') !!}
		            {!! Form::select('ot_type',['' => '--Select Type--','increment request' => 'Increment Request', 'increment approved form' => 'Increment Approved Form', 'cash advance' => 'Cash Advance', 'personal loan' => 'Personal Loan', 'car loan' => 'Car Loan', 'salary loan' => 'Salary Loan', 'previous contract' => 'Previous Contract', 'bank account' => 'Bank Account Number']) !!}
		            @if ($errors->has('ot_type'))
		                <span class="error">
		                    <strong>{{ $errors->first('ot_type') }}</strong>
		                </span>
		            @endif
		            </div>

		            <div>
		            {!! Form::label('ot_date','Date') !!}
		            {!! Form::text('ot_date',old('ot_date'),['placeholder'=>'yyyy-mm-dd','id'=>'add_ot_date']) !!}
		            @if ($errors->has('ot_date'))
		                <span class="error">
		                    <strong>{{ $errors->first('ot_date') }}</strong>
		                </span>
		            @endif
		            </div>

		            <div>
		            {!! Form::label('ot_desc','Description') !!}
		            {!! Form::text('ot_desc',old('ot_desc')) !!}
		            @if ($errors->has('ot_desc'))
		                <span class="error">
		                    <strong>{{ $errors->first('ot_desc') }}</strong>
		                </span>
		            @endif
		            </div>

		            <div>
		            {!! Form::label('ot_file','Upload File',['class' => 'upload-label']) !!}
		            {!! Form::file('ot_file',['class'=>'inputfile']) !!}
		            @if ($errors->has('ot_file'))
		                <span class="error">
		                    <strong>{{ $errors->first('ot_file') }}</strong>
		                </span>
		            @endif
		            </div>

		            {!! Form::submit('add') !!}
		            <button class="cancel"><i class="fa fa-remove"></i></button>
				{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
	@endslot
@endcomponent

@endsection

@section('modal')
<div id="emp-leanmodal">
	<a class="modal_close" href="#"><i class="fa fa-close"></i></a>
	
</div>
@endsection

@section('script')
	$(document).ready(function(){

		$('#empPanel > div').hide();
		$('#empPanel #files').show();

		var hash = window.location.hash;

		if(hash != ''){
			$('#empPanel > div').hide();
			$(hash).show();
			$('a[rel=empTab]').removeClass('active');
			$('a[rel=empTab]').each(function(){
				if($(this).attr('href') == hash){
					$(this).addClass('active');
				}
			});
		}
		$('a[rel=empTab]').click(function(e){
			var tabId = $(this).attr('href');
			$('a[rel=empTab]').removeClass('active');
			$(this).addClass('active');
			$('#empPanel > div').hide();
			$(tabId).show();
		});

		$('#vac_from,#vac_to,#vac_from_time,#vac_to_time').datepicker();
		$('#vac_from,#vac_to,#vac_from_time,#vac_to_time').datepicker("option", "dateFormat", "yy-mm-dd");

		@if($vacation['on'])
			if($('#vacation{{$vacation['current']->id}}Form #vac_from').attr('value') != undefined){
				$('#vacation{{$vacation['current']->id}}Form #vac_from').val($('#vacation{{$vacation['current']->id}}Form #vac_from').attr('value').replace(' 00:00:00',''));
			}
			if($('#vacation{{$vacation['current']->id}}Form #vac_to').attr('value') != undefined){
				$('#vacation{{$vacation['current']->id}}Form #vac_to').val($('#vacation{{$vacation['current']->id}}Form #vac_to').attr('value').replace(' 00:00:00',''));
			}
		@endif

		@if($vacation['upcoming'])
			if($('#vacation{{$vacation['upcoming']->id}}Form #vac_from').attr('value') != undefined){
				$('#vacation{{$vacation['upcoming']->id}}Form #vac_from').val($('#vacation{{$vacation['upcoming']->id}}Form #vac_from').attr('value').replace(' 00:00:00',''));
			}
			if($('#vacation{{$vacation['upcoming']->id}}Form #vac_to').attr('value') != undefined){
				$('#vacation{{$vacation['upcoming']->id}}Form #vac_to').val($('#vacation{{$vacation['upcoming']->id}}Form #vac_to').attr('value').replace(' 00:00:00',''));
			}
		@endif

		@if($vacation['past'])
		@foreach($vacation['past'] as $vac)
			if($('#vacation{{$vac->id}}Form #vac_from').attr('value') != undefined){
				$('#vacation{{$vac->id}}Form #vac_from').val($('#vacation{{$vac->id}}Form #vac_from').attr('value').replace(' 00:00:00',''));
			}
			if($('#vacation{{$vac->id}}Form #vac_to').attr('value') != undefined){
				$('#vacation{{$vac->id}}Form #vac_to').val($('#vacation{{$vac->id}}Form #vac_to').attr('value').replace(' 00:00:00',''));
			}
		@endforeach
		@endif

		$('#leave_from,#leave_to').datepicker();
		$('#leave_from,#leave_to').datepicker("option", "dateFormat", "yy-mm-dd");

		@if($emp->leave()->first())
			@foreach($emp->leave()->orderBy('leave_from','ASC')->get() as $leave)
			if($('#leave{{$leave->id}}Form #leave_from').attr('value') != undefined){
				$('#leave{{$leave->id}}Form #leave_from').val($('#leave{{$leave->id}}Form #leave_from').attr('value').replace(' 00:00:00',''));
			}
			if($('#leave{{$leave->id}}Form #leave_to').attr('value') != undefined){
				$('#leave{{$leave->id}}Form #leave_to').val($('#leave{{$leave->id}}Form #leave_to').attr('value').replace(' 00:00:00',''));
			}
			@endforeach
		@endif

		$('#add_leave_from,#add_leave_to').datepicker();
		$('#add_leave_from,#add_leave_to').datepicker("option", "dateFormat", "yy-mm-dd");

		if($('#add_leave_from').attr('value') != undefined){
			$('#add_leave_from').val($('#add_leave_from').attr('value').replace(' 00:00:00',''));
		}
		if($('#add_leave_to').attr('value') != undefined){
			$('#add_leave_to').val($('#add_leave_to').attr('value').replace(' 00:00:00',''));
		}

		$('#add_from,#add_to').datepicker();
		$('#add_from,#add_to').datepicker("option", "dateFormat", "yy-mm-dd");

		if($('#add_from').attr('value') != undefined){
			$('#add_from').val($('#add_from').attr('value').replace(' 00:00:00',''));
		}
		if($('#add_to').attr('value') != undefined){
			$('#add_to').val($('#add_to').attr('value').replace(' 00:00:00',''));
		}
		
		$('#qid_expiry').datepicker();
		$('#qid_expiry').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#qid_expiry').attr('value') != undefined){
			$('#qid_expiry').val($('#qid_expiry').attr('value').replace(' 00:00:00',''));
		}

		$('#passport_expiry').datepicker();
		$('#passport_expiry').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#passport_expiry').attr('value') != undefined){
			$('#passport_expiry').val($('#passport_expiry').attr('value').replace(' 00:00:00',''));
		}

		$('#hc_expiry').datepicker();
		$('#hc_expiry').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#hc_expiry').attr('value') != undefined){
			$('#hc_expiry').val($('#hc_expiry').attr('value').replace(' 00:00:00',''));
		}

		$('#joined').datepicker();
		$('#joined').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#joined').attr('value') != undefined){
			$('#joined').val($('#joined').attr('value').replace(' 00:00:00',''));
		}

		$('#dob').datepicker();
		$('#dob').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#dob').attr('value') != undefined){
			$('#dob').val($('#dob').attr('value').replace(' 00:00:00',''));
		}

		$('#work_start_date').datepicker();
		$('#work_start_date').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#work_start_date').attr('value') != undefined){
			$('#work_start_date').val($('#work_start_date').attr('value').replace(' 00:00:00',''));
		}

		$('#grad_date').datepicker();
		$('#grad_date').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#grad_date').attr('value') != undefined){
			$('#grad_date').val($('#grad_date').attr('value').replace(' 00:00:00',''));
		}

		$('#expiry_date').datepicker();
		$('#expiry_date').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#expiry_date').attr('value') != undefined){
			$('#expiry_date').val($('#expiry_date').attr('value').replace(' 00:00:00',''));
		}

		@if($emp->warning()->first())
			@foreach($emp->warning()->orderBy('warning_date','DESC')->get() as $warning)
			$('#warning{{$warning->id}}Form #warning_date').datepicker();
			$('#warning{{$warning->id}}Form #warning_date').datepicker("option", "dateFormat", "yy-mm-dd");
			if($('#warning{{$warning->id}}Form #warning_date').attr('value') != undefined){
				$('#warning{{$warning->id}}Form #warning_date').val($('#warning{{$warning->id}}Form #warning_date').attr('value').replace(' 00:00:00',''));
			}
			@endforeach
		@endif

		$('#add_warning_date').datepicker();
		$('#add_warning_date').datepicker("option", "dateFormat", "yy-mm-dd");

		if($('#add_warning_date').attr('value') != undefined){
			$('#add_warning_date').val($('#add_warning_date').attr('value').replace(' 00:00:00',''));
		}

		@if($emp->ai()->first())
			@foreach($emp->ai()->orderBy('ai_date','DESC')->get() as $ai)
			$('#ai{{$ai->id}}Form #ai_date').datepicker();
			$('#ai{{$ai->id}}Form #ai_date').datepicker("option", "dateFormat", "yy-mm-dd");
			if($('#ai{{$ai->id}}Form #ai_date').attr('value') != undefined){
				$('#ai{{$ai->id}}Form #ai_date').val($('#ai{{$ai->id}}Form #ai_date').attr('value').replace(' 00:00:00',''));
			}
			@endforeach
		@endif

		$('#add_ai_date').datepicker();
		$('#add_ai_date').datepicker("option", "dateFormat", "yy-mm-dd");

		if($('#add_ai_date').attr('value') != undefined){
			$('#add_ai_date').val($('#add_ai_date').attr('value').replace(' 00:00:00',''));
		}

		

		@if($emp->ot()->first())
			@foreach($emp->ot()->orderBy('ot_date','DESC')->get() as $ot)
			$('#ot{{$ot->id}}Form #ot_date').datepicker();
			$('#ot{{$ot->id}}Form #ot_date').datepicker("option", "dateFormat", "yy-mm-dd");
			if($('#ot{{$ot->id}}Form #ot_date').attr('value') != undefined){
				$('#ot{{$ot->id}}Form #ot_date').val($('#ot{{$ot->id}}Form #ot_date').attr('value').replace(' 00:00:00',''));
			}
			@endforeach
		@endif

		$('#add_ot_date').datepicker();
		$('#add_ot_date').datepicker("option", "dateFormat", "yy-mm-dd");

		if($('#add_ot_date').attr('value') != undefined){
			$('#add_ot_date').val($('#add_ot_date').attr('value').replace(' 00:00:00',''));
		}
		

		$('.userUpdateForm').hide();

		$(document).on('click','a[rel=formOpen]',function(){
			var field = $(this).data('field');
			
			$('.userUpdateForm').hide();
			$(this).parent().find('.emp-delete').hide();
			$('a[rel=formOpen]').show();
			$('#'+field+'Form').show();
			$(this).hide();
			return false;
		});

		$('button.cancel').click(function(e){
			e.preventDefault();
			$(this).parent().hide();
			var field = $(this).parent().attr('id').replace('Form','');
			$('a[data-field='+field+']').show();
			$('.emp-delete').show();
		});

		function searchAll(){
			$.ajax({
			    url: '{{url('employees/all')}}',
			    dataType:'JSON',
			    type: "POST",
			    data: {},
			    success: function(data){
			    	$('ul#employees').html('');
			    	for(var i in data){
			    		$('ul#employees').append('<li><a href="{{url('employees')}}/'+data[i].id+'">'+data[i].name+'</a><a href="{{url('employees')}}/'+data[i].id+'/edit"><i class="fa fa-wrench"></i></a><a href="#delete-leanmodal" data-id="'+data[i].id+'" class="delete" rel="leanModal" title="delete"><i class="fa fa-remove"></i></a><form method="POST" action="{{url('employees')}}/'+data[i].id+'/delete" accept-charset="UTF-8" style="display: none;" id="delete'+data[i].id+'"><input name="_token" type="hidden" value="'+$('meta[name=_token]').attr('content')+'"></form></li>');
			    	}
			    },
			});
		}

		$('.time-input').inputmask("yyyy-mm-dd hh:mm:ss", {
                mask: "y-1-2 h:s:s",
                placeholder: "yyyy-mm-dd hh:mm:ss",
                alias: "datetime",
                separator: "-",
                leapday: "-02-29",
                regex: {
                    val2pre: function(separator) {
                        var escapedSeparator = Inputmask.escapeRegex.call(this, separator);
                        return new RegExp("((0[13-9]|1[012])" + escapedSeparator + "[0-3])|(02" + escapedSeparator + "[0-2])");
                    },
                    val2: function(separator) {
                        var escapedSeparator = Inputmask.escapeRegex.call(this, separator);
                        return new RegExp("((0[1-9]|1[012])" + escapedSeparator + "(0[1-9]|[12][0-9]))|((0[13-9]|1[012])" + escapedSeparator + "30)|((0[13578]|1[02])" + escapedSeparator + "31)");
                    },
                    val1pre: new RegExp("[01]"),
                    val1: new RegExp("0[1-9]|1[012]")
                },
                onKeyDown: function(e, buffer, caretPos, opts) {}
            });

		$.ajaxSetup({
	    	headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	  	});

	  	$('.delete-entry,.file-delete').click(function(e){
	  		e.preventDefault();
	  		if(confirm("Are you sure you want to delete this entry?")){
	  			$(this).parent().submit();
	  		}
	  	});

	  	$('select#airport').append('<option value="">--Select Airport--</option><option value="ABJ">Abidjan (ABJ)</option><option value="ZVJ">Abu Dhabi (BUS) (ZVJ)</option><option value="ABV">Abuja (ABV)</option><option value="ACC">Accra (ACC)</option><option value="ADD">Addis Ababa (ADD)</option><option value="ADL">Adelaide (ADL)</option><option value="AMD">Ahmedabad (AMD)</option><option value="ZVH">Al Ain (BUS) (ZVH)</option><option value="HBE">Alexandria (HBE)</option><option value="ALG">Algiers (ALG)</option><option value="AMM">Amman (AMM)</option><option value="AMS">Amsterdam (AMS)</option><option value="ATH">Athens (ATH)</option><option value="AKL">Auckland (AKL)</option><option value="BGW">Baghdad (BGW)</option><option value="BAH">Bahrain (BAH)</option><option value="DPS">Bali (DPS)</option><option value="BKK">Bangkok (BKK)</option><option value="BCN">Barcelona (BCN)</option><option value="BSR">Basra (BSR)</option><option value="PEK">Beijing (PEK)</option><option value="BEY">Beirut (BEY)</option><option value="BLR">Bengaluru (BLR)</option><option value="BHX">Birmingham (BHX)</option><option value="BLQ">Bologna (BLQ)</option><option value="BOS">Boston (BOS)</option><option value="BNE">Brisbane (BNE)</option><option value="BRU">Brussels (BRU)</option><option value="BUD">Budapest (BUD)</option><option value="EZE">Buenos Aires (EZE)</option><option value="CAI">Cairo (CAI)</option><option value="CPT">Cape Town (CPT)</option><option value="CMN">Casablanca (CMN)</option><option value="CEB">Cebu (CEB)</option><option value="MAA">Chennai (MAA)</option><option value="ORD">Chicago (ORD)</option><option value="CHC">Christchurch (CHC)</option><option value="CRK">Clark (CRK)</option><option value="CMB">Colombo (CMB)</option><option value="CPH">Copenhagen (CPH)</option><option value="DKR">Dakar (DKR)</option><option value="DFW">Dallas (DFW)</option><option value="DAM">Damascus (DAM)</option><option value="DMM">Dammam (DMM)</option><option value="DAR">Dar Es Salaam (DAR)</option><option value="DEL">Delhi (DEL)</option><option value="DAC">Dhaka (DAC)</option><option value="DXB">Dubai (DXB)</option><option value="DUB">Dublin (DUB)</option><option value="DUR">Durban (DUR)</option><option value="DUS">D&#252;sseldorf (DUS)</option><option value="EBB">Entebbe (EBB)</option><option value="EBL">Erbil (EBL)</option><option value="FLL">Fort Lauderdale (FLL)</option><option value="FRA">Frankfurt (FRA)</option><option value="GVA">Geneva (GVA)</option><option value="GLA">Glasgow (GLA)</option><option value="CAN">Guangzhou (CAN)</option><option value="HAM">Hamburg (HAM)</option><option value="HAN">Hanoi (HAN)</option><option value="HRE">Harare (HRE)</option><option value="SGN">Ho Chi Minh City (SGN)</option><option value="HKG">Hong Kong (HKG)</option><option value="IAH">Houston (IAH)</option><option value="HYD">Hyderabad (HYD)</option><option value="ISB">Islamabad (ISB)</option><option value="IST">Istanbul (IST)</option><option value="SAW">Istanbul Sabiha Gokcen (SAW)</option><option value="CGK">Jakarta (CGK)</option><option value="JED">Jeddah (JED)</option><option value="JNB">Johannesburg (JNB)</option><option value="KBL">Kabul (KBL)</option><option value="KHI">Karachi (KHI)</option><option value="KRT">Khartoum (KRT)</option><option value="COK">Kochi (COK)</option><option value="CCU">Kolkata (CCU)</option><option value="CCJ">Kozhikode (CCJ)</option><option value="KUL">Kuala Lumpur (KUL)</option><option value="KWI">Kuwait (KWI)</option><option value="LOS">Lagos (LOS)</option><option value="LHE">Lahore (LHE)</option><option value="LCA">Larnaca (LCA)</option><option value="LIS">Lisbon (LIS)</option><option value="LGW">London Gatwick (LGW)</option><option value="LHR">London Heathrow (LHR)</option><option value="LAX">Los Angeles (LAX)</option><option value="LAD">Luanda (LAD)</option><option value="LUN">Lusaka (LUN)</option><option value="LYS">Lyon (LYS)</option><option value="MAD">Madrid (MAD)</option><option value="MLE">Male (MLE)</option><option value="MLA">Malta (MLA)</option><option value="MAN">Manchester (MAN)</option><option value="MNL">Manila (MNL)</option><option value="MHD">Mashhad (MHD)</option><option value="MRU">Mauritius (MRU)</option><option value="MED">Medina (Madinah) (MED)</option><option value="MEL">Melbourne (MEL)</option><option value="MXP">Milan (MXP)</option><option value="DME">Moscow (DME)</option><option value="MUX">Multan (MUX)</option><option value="BOM">Mumbai (BOM)</option><option value="MUC">Munich (MUC)</option><option value="MCT">Muscat (MCT)</option><option value="NBO">Nairobi (NBO)</option><option value="JFK">New York (JFK)</option><option value="EWR">Newark (EWR)</option><option value="NCL">Newcastle (NCL)</option><option value="NCE">Nice (NCE)</option><option value="MCO">Orlando (MCO)</option><option value="KIX">Osaka (KIX)</option><option value="OSL">Oslo (OSL)</option><option value="CDG">Paris (CDG)</option><option value="PER">Perth (PER)</option><option value="PEW">Peshawar (PEW)</option><option value="PNH">Phnom Penh (PNH)</option><option value="HKT">Phuket (HKT)</option><option value="PRG">Prague (PRG)</option><option value="GIG">Rio de Janeiro (GIG)</option><option value="RUH">Riyadh (RUH)</option><option value="FCO">Rome (FCO)</option><option value="SFO">San Francisco (SFO)</option><option value="SAH">Sana&#39;a (SAH)</option><option value="GRU">S&#227;o Paulo (GRU)</option><option value="SEA">Seattle (SEA)</option><option value="ICN">Seoul (ICN)</option><option value="SEZ">Seychelles (SEZ)</option><option value="PVG">Shanghai (PVG)</option><option value="SKT">Sialkot (SKT)</option><option value="SIN">Singapore (SIN)</option><option value="LED">St Petersburg (LED)</option><option value="ARN">Stockholm (ARN)</option><option value="SYD">Sydney (SYD)</option><option value="TPE">Taipei (TPE)</option><option value="IKA">Tehran (IKA)</option><option value="TRV">Thiruvananthapuram (TRV)</option><option value="HND">Tokyo Haneda (HND)</option><option value="NRT">Tokyo Narita (NRT)</option><option value="YYZ">Toronto (YYZ)</option><option value="TIP">Tripoli (TIP)</option><option value="TUN">Tunis (TUN)</option><option value="VCE">Venice (VCE)</option><option value="VIE">Vienna (VIE)</option><option value="WAW">Warsaw (WAW)</option><option value="IAD">Washington Dulles (IAD)</option><option value="RGN">Yangon (RGN)</option><option value="INC">Yinchuan (INC)</option><option value="ZAG">Zagreb (ZAG)</option><option value="CGO">Zhengzhou (CGO)</option>');
	
	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection
