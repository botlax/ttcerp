<div id="nav-panel">
	<a href="#" id="nav-button"><i class="fa fa-bars"></i></a>
	<nav id="sub-nav-mobile">
		<ul>
			<li class="{{$dbClass or ''}}"><a href="{{url('/')}}" title="Dashboard"><i class="fa fa-home"></i></a></li>
			<li class="with-dropdown {{$empClass or ''}}"><a href="#" title="Employees"><i class="fa fa-users"></i></a>
				<ul class="dropdown">
					<li><a href="{{url('employees')}}">Employee List</a></li>
					<li><a href="{{url('employees/add')}}">Add Employee</a></li>
				</ul>
			</li>
			
			<li class="with-dropdown {{$vacClass or ''}}"><a href="#" title="Vacation"><i class="fa fa-paper-plane"></i></a>
				<ul class="dropdown">
					<li><a href="{{url('vacation')}}">Vacation List</a></li>
					<li><a href="{{url('vacation/add')}}">Add Vacation</a></li>
				</ul>
			</li>

			<li class="{{$qidClass or ''}}"><a href="{{url('qid-expiry')}}" title="QID Expiry"><i class="fa fa-id-badge"></i></a>
			</li>

			<li class="{{$passClass or ''}}"><a href="{{url('passport-expiry')}}" title="Passport Expiry"><i class="fa fa-drivers-license"></i></a>
			</li>

			<li class="{{$hcClass or ''}}"><a href="{{url('hc-expiry')}}" title="Health Card Expiry"><i class="fa fa-medkit"></i></a>
			</li>

			<li class="{{$licClass or ''}}"><a href="{{url('license-expiry')}}" title="License Expiry"><i class="fa fa-car"></i></a>
			</li>

			<li class="with-dropdown {{$visaClass or ''}}"><a href="#" title="Visas"><i class="fa fa-file-text"></i></a>
				<ul class="dropdown">
					<li><a href="{{url('visa')}}">Visa List</a></li>
					<li><a href="{{url('visa/add')}}">Add Visa</a></li>
				</ul>
			</li>
			
		</ul>
	</nav>

	<nav id="sub-nav">
		<ul>
			<li class="{{$dbClass or ''}}"><a href="{{url('/')}}" title="Dashboard"><i class="fa fa-home"></i>Dashboard</a></li>
			<li class="with-dropdown {{$empClass or ''}}"><a href="#" title="Employees"><i class="fa fa-users"></i>Employees</a>
				<ul class="dropdown">
					<li><a href="{{url('employees')}}">Employee List</a></li>
					<li><a href="{{url('employees/add')}}">Add Employee</a></li>
				</ul>
			</li>
			
			<li class="with-dropdown {{$vacClass or ''}}"><a href="#" title="Vacation"><i class="fa fa-paper-plane"></i>Vacation</a>
				<ul class="dropdown">
					<li><a href="{{url('vacation')}}">Vacation List</a></li>
					<li><a href="{{url('vacation/add')}}">Add Vacation</a></li>
				</ul>
			</li>

			<li class="{{$qidClass or ''}}"><a href="{{url('qid-expiry')}}" title="QID Expiry"><i class="fa fa-id-badge"></i>QID Expiry</a>
			</li>

			<li class="{{$passClass or ''}}"><a href="{{url('passport-expiry')}}" title="Passport Expiry"><i class="fa fa-drivers-license"></i>Passport Expiry</a>
			</li>

			<li class="{{$hcClass or ''}}"><a href="{{url('hc-expiry')}}" title="Health Card Expiry"><i class="fa fa-medkit"></i>HC Expiry</a>
			</li>

			<li class="{{$licClass or ''}}"><a href="{{url('license-expiry')}}" title="License Expiry"><i class="fa fa-car"></i>License Expiry</a>
			</li>

			<li class="with-dropdown {{$visaClass or ''}}"><a href="#" title="Visas"><i class="fa fa-file-text"></i>Visas</a>
				<ul class="dropdown">
					<li><a href="{{url('visa')}}">Visa List</a></li>
					<li><a href="{{url('visa/add')}}">Add Visa</a></li>
				</ul>
			</li>
			
		</ul>
	</nav>
</div>