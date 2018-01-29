<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	<div class="menu_section">
		<h3>&nbsp;</h3>
		<ul class="nav side-menu">
			<li>
				<a href="{{ URL::to('admin/dashboard') }}">Dashboard</a>
			</li>
			<li>
				<a>Services<span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li>
						<a href="{{ URL::to('admin/service-new') }}">Create New</a>
					</li>
					<li>
						<a href="{{ URL::to('admin/services-list') }}">List</a>
					</li>
				</ul>
			</li>
			<li>
				<a>Service Sub Categories<span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li>
						<a href="{{ URL::to('admin/service-sub-categories-new') }}">Create New</a>
					</li>
					<li>
						<a href="{{ URL::to('admin/service-sub-categories-list') }}">List</a>
					</li>
				</ul>
			</li>
			<li>
				<a>Car Types<span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li>
						<a href="{{ URL::to('admin/car-types-new') }}">Create New</a>
					</li>
					<li>
						<a href="{{ URL::to('admin/car-types-list') }}">List</a>
					</li>
				</ul>
			</li>
			<li>
				<a>Cars<span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li>
						<a href="{{ URL::to('admin/cars-new') }}">Add cars</a>
					</li>
					<li>
						<a href="{{ URL::to('admin/cars-list') }}">List</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="{{ URL::to('admin/reports')}}">Reports</a>
			</li>
			<li>
				<a>Vendors<span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li>
						<a href="{{ URL::to('admin/vendors-new') }}">Create New</a>
					</li>
					<li>
						<a href="{{ URL::to('admin/vendors-list') }}">List</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<!-- /sidebar menu -->