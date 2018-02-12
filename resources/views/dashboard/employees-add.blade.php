@extends('dashboard')

@section('title')
Add Employee | {{config('app.name')}}
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
		user-plus
	@endslot
	@slot('headerTitle')
		Add Employee
	@endslot
	@slot('content')
		{!! Form::open(['route' => 'emp-add','id' => 'emp-add']) !!}
        <div class="row clearfix">
            <div class="5u">
        		<div>
        			{!! Form::label('emp_id', 'Employee ID') !!}
        			{!! Form::text('emp_id', old('emp_id')) !!}
        			@if ($errors->has('emp_id'))
                        <span class="error">
                            <strong>{{ $errors->first('emp_id') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
        			{!! Form::label('name', 'Name') !!}
        			{!! Form::text('name', old('name')) !!}
        			@if ($errors->has('name'))
                        <span class="error">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div>            
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', old('email')) !!}
                    @if ($errors->has('email'))
                        <span class="error">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div>
                    {!! Form::label('position', 'Position') !!}
                    {!! Form::select('position', ['' => '--Select Position--',
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
                    'Watchman' =>  'Watchman'], old('position')) !!}
                    @if ($errors->has('position'))
                        <span class="error">
                            <strong>{{ $errors->first('position') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
                    {!! Form::label('nationality', 'Nationality') !!}
        			{!! Form::select('nationality', $nats, old('nationality')) !!}
        			@if ($errors->has('nationality'))
                        <span class="error">
                            <strong>{{ $errors->first('nationality') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
                    {!! Form::label('joined', 'Join Date') !!}
        			{!! Form::text('joined', old('joined'),['placeholder'=>'yyyy-mm-dd']) !!}
        			@if ($errors->has('joined'))
                        <span class="error">
                            <strong>{{ $errors->first('joined') }}</strong>
                        </span>
                    @endif
                </div>
                <div>            
                    {!! Form::label('gender', 'Gender') !!}
                    {!! Form::select('gender', ['' => '--Select Gender--', 'male' => 'Male', 'female' => 'Female'],old('gender')) !!}
                    @if ($errors->has('gender'))
                        <span class="error">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                    @endif
                </div>
                <div>            
                    {!! Form::label('religion', 'Religion') !!}
                    {!! Form::select('religion', ['' => '--Select Religion--', 'muslim' => 'Muslim', 'hindu' => 'Hindu', 'christian' => 'Christian', 'others' => 'Others'],old('religion')) !!}
                    @if ($errors->has('religion'))
                        <span class="error">
                            <strong>{{ $errors->first('religion') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
                    {!! Form::label('dob', 'Date of Birth') !!}
        			{!! Form::text('dob', old('dob'),['placeholder'=>'yyyy-mm-dd']) !!}
        			@if ($errors->has('dob'))
                        <span class="error">
                            <strong>{{ $errors->first('dob') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
                    {!! Form::label('status', 'Status') !!}
        			{!! Form::select('status', ['' => '--Select Status--', 'single' => 'Single', 'married' => 'Married'],old('status')) !!}
        			@if ($errors->has('status'))
                        <span class="error">
                            <strong>{{ $errors->first('status') }}</strong>
                        </span>
                    @endif
                </div>
                <div>            
                    {!! Form::label('children', 'No. of Children') !!}
        			{!! Form::text('children', old('children')) !!}
        			@if ($errors->has('children'))
                        <span class="error">
                            <strong>{{ $errors->first('children') }}</strong>
                        </span>
                    @endif
                </div>
         		<div>           
                    {!! Form::label('qid', 'QID') !!}
        			{!! Form::text('qid', old('qid')) !!}
        			@if ($errors->has('qid'))
                        <span class="error">
                            <strong>{{ $errors->first('qid') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
                    {!! Form::label('qid_expiry', 'QID Expiry') !!}
        			{!! Form::text('qid_expiry', old('qid_expiry'),['placeholder'=>'yyyy-mm-dd']) !!}
        			@if ($errors->has('qid_expiry'))
                        <span class="error">
                            <strong>{{ $errors->first('qid_expiry') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="5u">
        		<div>            
                    {!! Form::label('passport', 'Passport No.') !!}
        			{!! Form::text('passport', old('passport')) !!}
        			@if ($errors->has('passport'))
                        <span class="error">
                            <strong>{{ $errors->first('passport') }}</strong>
                        </span>
                    @endif
                </div>
         		<div>           
                    {!! Form::label('passport_expiry', 'Passport Expiry') !!}
        			{!! Form::text('passport_expiry', old('passport_expiry'),['placeholder'=>'yyyy-mm-dd']) !!}
        			@if ($errors->has('passport_expiry'))
                        <span class="error">
                            <strong>{{ $errors->first('passport_expiry') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
                    {!! Form::label('health_card', 'Health Card No.') !!}
        			{!! Form::text('health_card', old('health_card')) !!}
        			@if ($errors->has('health_card'))
                        <span class="error">
                            <strong>{{ $errors->first('health_card') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
                    {!! Form::label('hc_expiry', 'Health Card Expiry') !!}
        			{!! Form::text('hc_expiry', old('hc_expiry'),['placeholder'=>'yyyy-mm-dd']) !!}
        			@if ($errors->has('hc_expiry'))
                        <span class="error">
                            <strong>{{ $errors->first('hc_expiry') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
                    {!! Form::label('mobile', 'Company Mobile No.') !!}
        			{!! Form::text('mobile', old('mobile')) !!}
        			@if ($errors->has('mobile'))
                        <span class="error">
                            <strong>{{ $errors->first('mobile') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
                    {!! Form::label('airport', 'Airport') !!}
        			{!! Form::select('airport', [], old('airport')) !!}
        			@if ($errors->has('airport'))
                        <span class="error">
                            <strong>{{ $errors->first('airport') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
                    {!! Form::label('degree', 'Degree') !!}
        			{!! Form::text('degree', old('degree')) !!}
        			@if ($errors->has('degree'))
                        <span class="error">
                            <strong>{{ $errors->first('degree') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
                    {!! Form::label('grad_date', 'Graduation Date') !!}
        			{!! Form::text('grad_date', old('grad_date'),['placeholder'=>'yyyy-mm-dd']) !!}
        			@if ($errors->has('grad_date'))
                        <span class="error">
                            <strong>{{ $errors->first('grad_date') }}</strong>
                        </span>
                    @endif
                </div>
        		<div>            
                    {!! Form::label('work_start_date', 'Work Start Date') !!}
        			{!! Form::text('work_start_date', old('work_start_date'),['placeholder'=>'yyyy-mm-dd']) !!}
        			@if ($errors->has('work_start_date'))
                        <span class="error">
                            <strong>{{ $errors->first('work_start_date') }}</strong>
                        </span>
                    @endif
                </div>
                <div>            
                    {!! Form::label('location', 'Location') !!}
                    {!! Form::select('location_prefix', ['' => '--', 'P' => 'P', 'T' => 'T', 'PI' => 'PI'],old('location_prefix'), ['style' => 'width:70px;']) !!}
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
            </div>
        </div>
		{!! Form::close() !!}
	@endslot
@endcomponent

@endsection

@section('script')
$(document).ready(function(){
	$('#joined').datepicker();
	$('#joined').datepicker("option", "dateFormat", "yy-mm-dd");

	$('#dob').datepicker();
	$('#dob').datepicker("option", "dateFormat", "yy-mm-dd");

	$('#qid_expiry').datepicker();
	$('#qid_expiry').datepicker("option", "dateFormat", "yy-mm-dd");

	$('#passport_expiry').datepicker();
	$('#passport_expiry').datepicker("option", "dateFormat", "yy-mm-dd");

	$('#hc_expiry').datepicker();
	$('#hc_expiry').datepicker("option", "dateFormat", "yy-mm-dd");

	$('#work_start_date').datepicker();
	$('#work_start_date').datepicker("option", "dateFormat", "yy-mm-dd");

	$('#grad_date').datepicker();
	$('#grad_date').datepicker("option", "dateFormat", "yy-mm-dd");

	$('#joined').val('{{old('joined')}}');
	$('#dob').val('{{old('dob')}}');
	$('#qid_expiry').val('{{old('qid_expiry')}}');
	$('#passport_expiry').val('{{old('passport_expiry')}}');
	$('#hc_expiry').val('{{old('hc_expiry')}}');
	$('#work_start_date').val('{{old('work_start_date')}}');
	$('#grad_date').val('{{old('grad_date')}}');

	$('select#airport').append('<option value="">--Select Airport--</option><option value="ABJ">Abidjan (ABJ)</option><option value="ZVJ">Abu Dhabi (BUS) (ZVJ)</option><option value="ABV">Abuja (ABV)</option><option value="ACC">Accra (ACC)</option><option value="ADD">Addis Ababa (ADD)</option><option value="ADL">Adelaide (ADL)</option><option value="AMD">Ahmedabad (AMD)</option><option value="ZVH">Al Ain (BUS) (ZVH)</option><option value="HBE">Alexandria (HBE)</option><option value="ALG">Algiers (ALG)</option><option value="AMM">Amman (AMM)</option><option value="AMS">Amsterdam (AMS)</option><option value="ATH">Athens (ATH)</option><option value="AKL">Auckland (AKL)</option><option value="BGW">Baghdad (BGW)</option><option value="BAH">Bahrain (BAH)</option><option value="DPS">Bali (DPS)</option><option value="BKK">Bangkok (BKK)</option><option value="BCN">Barcelona (BCN)</option><option value="BSR">Basra (BSR)</option><option value="PEK">Beijing (PEK)</option><option value="BEY">Beirut (BEY)</option><option value="BLR">Bengaluru (BLR)</option><option value="BHX">Birmingham (BHX)</option><option value="BLQ">Bologna (BLQ)</option><option value="BOS">Boston (BOS)</option><option value="BNE">Brisbane (BNE)</option><option value="BRU">Brussels (BRU)</option><option value="BUD">Budapest (BUD)</option><option value="EZE">Buenos Aires (EZE)</option><option value="CAI">Cairo (CAI)</option><option value="CPT">Cape Town (CPT)</option><option value="CMN">Casablanca (CMN)</option><option value="CEB">Cebu (CEB)</option><option value="MAA">Chennai (MAA)</option><option value="ORD">Chicago (ORD)</option><option value="CHC">Christchurch (CHC)</option><option value="CRK">Clark (CRK)</option><option value="CMB">Colombo (CMB)</option><option value="CPH">Copenhagen (CPH)</option><option value="DKR">Dakar (DKR)</option><option value="DFW">Dallas (DFW)</option><option value="DAM">Damascus (DAM)</option><option value="DMM">Dammam (DMM)</option><option value="DAR">Dar Es Salaam (DAR)</option><option value="DEL">Delhi (DEL)</option><option value="DAC">Dhaka (DAC)</option><option value="DXB">Dubai (DXB)</option><option value="DUB">Dublin (DUB)</option><option value="DUR">Durban (DUR)</option><option value="DUS">D&#252;sseldorf (DUS)</option><option value="EBB">Entebbe (EBB)</option><option value="EBL">Erbil (EBL)</option><option value="FLL">Fort Lauderdale (FLL)</option><option value="FRA">Frankfurt (FRA)</option><option value="GVA">Geneva (GVA)</option><option value="GLA">Glasgow (GLA)</option><option value="CAN">Guangzhou (CAN)</option><option value="HAM">Hamburg (HAM)</option><option value="HAN">Hanoi (HAN)</option><option value="HRE">Harare (HRE)</option><option value="SGN">Ho Chi Minh City (SGN)</option><option value="HKG">Hong Kong (HKG)</option><option value="IAH">Houston (IAH)</option><option value="HYD">Hyderabad (HYD)</option><option value="ISB">Islamabad (ISB)</option><option value="IST">Istanbul (IST)</option><option value="SAW">Istanbul Sabiha Gokcen (SAW)</option><option value="CGK">Jakarta (CGK)</option><option value="JED">Jeddah (JED)</option><option value="JNB">Johannesburg (JNB)</option><option value="KBL">Kabul (KBL)</option><option value="KHI">Karachi (KHI)</option><option value="KTM">Katmandu (KTM)</option><option value="KRT">Khartoum (KRT)</option><option value="COK">Kochi (COK)</option><option value="CCU">Kolkata (CCU)</option><option value="CCJ">Kozhikode (CCJ)</option><option value="KUL">Kuala Lumpur (KUL)</option><option value="KWI">Kuwait (KWI)</option><option value="LOS">Lagos (LOS)</option><option value="LHE">Lahore (LHE)</option><option value="LCA">Larnaca (LCA)</option><option value="LIS">Lisbon (LIS)</option><option value="LGW">London Gatwick (LGW)</option><option value="LHR">London Heathrow (LHR)</option><option value="LAX">Los Angeles (LAX)</option><option value="LAD">Luanda (LAD)</option><option value="LUN">Lusaka (LUN)</option><option value="LYS">Lyon (LYS)</option><option value="MAD">Madrid (MAD)</option><option value="MLE">Male (MLE)</option><option value="MLA">Malta (MLA)</option><option value="MAN">Manchester (MAN)</option><option value="MNL">Manila (MNL)</option><option value="MHD">Mashhad (MHD)</option><option value="MRU">Mauritius (MRU)</option><option value="MED">Medina (Madinah) (MED)</option><option value="MEL">Melbourne (MEL)</option><option value="MXP">Milan (MXP)</option><option value="DME">Moscow (DME)</option><option value="MUX">Multan (MUX)</option><option value="BOM">Mumbai (BOM)</option><option value="MUC">Munich (MUC)</option><option value="MCT">Muscat (MCT)</option><option value="NBO">Nairobi (NBO)</option><option value="JFK">New York (JFK)</option><option value="EWR">Newark (EWR)</option><option value="NCL">Newcastle (NCL)</option><option value="NCE">Nice (NCE)</option><option value="MCO">Orlando (MCO)</option><option value="KIX">Osaka (KIX)</option><option value="OSL">Oslo (OSL)</option><option value="CDG">Paris (CDG)</option><option value="PER">Perth (PER)</option><option value="PEW">Peshawar (PEW)</option><option value="PNH">Phnom Penh (PNH)</option><option value="HKT">Phuket (HKT)</option><option value="PRG">Prague (PRG)</option><option value="GIG">Rio de Janeiro (GIG)</option><option value="RUH">Riyadh (RUH)</option><option value="FCO">Rome (FCO)</option><option value="SFO">San Francisco (SFO)</option><option value="SAH">Sana&#39;a (SAH)</option><option value="GRU">S&#227;o Paulo (GRU)</option><option value="SEA">Seattle (SEA)</option><option value="ICN">Seoul (ICN)</option><option value="SEZ">Seychelles (SEZ)</option><option value="PVG">Shanghai (PVG)</option><option value="SKT">Sialkot (SKT)</option><option value="SIN">Singapore (SIN)</option><option value="LED">St Petersburg (LED)</option><option value="ARN">Stockholm (ARN)</option><option value="SYD">Sydney (SYD)</option><option value="TPE">Taipei (TPE)</option><option value="IKA">Tehran (IKA)</option><option value="TRV">Thiruvananthapuram (TRV)</option><option value="HND">Tokyo Haneda (HND)</option><option value="NRT">Tokyo Narita (NRT)</option><option value="YYZ">Toronto (YYZ)</option><option value="TIP">Tripoli (TIP)</option><option value="TUN">Tunis (TUN)</option><option value="VCE">Venice (VCE)</option><option value="VIE">Vienna (VIE)</option><option value="WAW">Warsaw (WAW)</option><option value="IAD">Washington Dulles (IAD)</option><option value="RGN">Yangon (RGN)</option><option value="INC">Yinchuan (INC)</option><option value="ZAG">Zagreb (ZAG)</option><option value="CGO">Zhengzhou (CGO)</option>');
});
@endsection
