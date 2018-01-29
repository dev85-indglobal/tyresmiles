<!DOCTYPE html>
<html lang="en">
    @include('partials.admin_header')
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @include('partials.admin_topbar')
                <!-- page content -->
                <div class="right_col" role="main">
                	<div class="row"></div>
                	@if(Session::has('successmsg'))
						<p class="alert alert-success">{{ Session::get('successmsg') }}</p>
					@endif
					@if(Session::has('errormsg'))
						<p class="alert alert-danger">{{ Session::get('errormsg') }}</p>
					@endif
                    <table id="general-table" class="table table-bordered table-hover">
						<h1><center>List of Service Sub Categories</center></h1>
						<thead>
						<tr>
							<th>Sl No</th>
							<th>Category ID</th>
							<th>Sub Category Name</th>
							<th>Service Exists</th>	
							<th>Active</th>	
							<th>Action</th>					
						</tr>				
						</tr>
						</thead>

						<tr>
							<?php $mn = 1; ?>
							@foreach($Sub_categories as $sc)
							<td>{{$sc->sub_category_id}}</td>
							<td>{{$sc->category_id}}</td>
							<td>{{$sc->sub_category_name}}</td>
							<td>{{$sc->services_exist}}</td>
							<td>{{$sc->active}}</td>
							<td><a href='service-sub-categories-view/{{$sc->sub_category_id}}'>Edit</a></td>
							<?php $mn++; ?>
						</tr>
						    @endforeach
						    @if($mn==1)
                      <tr>
                      <td colspan="3" align="center">No data found</td>
                      </tr>
                      @endif	
					</table>
                </div>
                <!-- /page content -->
            </div>
        </div>
        @include('partials.admin_footer')
    </body>
</html>
