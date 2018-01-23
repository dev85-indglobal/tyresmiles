<!DOCTYPE html>
<html lang="en">
    @include('partials.admin_header')
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @include('partials.admin_topbar')
                <!-- page content -->
                <div class="right_col" role="main">
                    <table id="general-table" class="table table-bordered table-hover">
						<h1><center>List of Cars</center></h1>
						<thead>
						<tr>
							<th>Sl No</th>
							<th>Car Name</th>				
						</tr>
						</thead>

						<tr>
							@foreach($cars as $r)
							<td>{{$r->id}}</td>
							<td>{{$r->name}}</td>
						</tr>
						    @endforeach
					</table>
                </div>
                <!-- /page content -->
            </div>
        </div>
        @include('partials.admin_footer')
    </body>
</html>
