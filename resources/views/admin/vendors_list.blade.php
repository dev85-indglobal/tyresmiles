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
						<h1><center>List of Vendors</center></h1>
						<thead>
						<tr>
							<th> Id</th>
							<th>Category Id</th>
							<th>Vendor Name</th>
							<th>Address</th>
							<th>City Id</th>
							<th>Currency</th>
							<th>Price</th>
							<th>Active</th>
							<th>Action</th>	
							
											
						</tr>
						</thead>

						<tr>
							<?php $mn = 1; ?>
							
							@foreach($details as $d)
							<td>{{$d->id}}</td>
							<td>{{$d->category_id}}</td>
							<td>{{$d->vendor_name}}</td>
							<td>{{$d->address}}</td>
							<td>{{$d->city_id}}</td>
							<td>{{$d->currency}}</td>
							<td>{{$d->price}}</td>
							<td>{{$d->type}}</td>
							<td><a href='vendor-view/{{$d->id}}'>Edit</a></td>
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