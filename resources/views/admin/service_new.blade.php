<!DOCTYPE html>
<html lang="en">
    @include('partials.admin_header')
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @include('partials.admin_topbar')
                <!-- page content -->
                <div class="right_col" role="main">
                    <form name="new_servicefrm" method="post" action="{{URL::to('/admin/service-save')}}" enctype="multipart/form-data">
						{{ csrf_field()}}
					<div class="form-group">
					   <h1><center>Create New Service</center></h1> 
					</div>
					<div class="form-group">
						<label for="Title" ><h2>Service Name</h2></label>
						<input type="text" name="service_name" class="form-control">

					</div>
					<div class="form-group">
						<label for="Content" ><h2>Active</h2></label>	   	
					    <select name="service_active" class="form-control">
					     <option value="1" >Active</option>
					     <option value="2">InActive</option>
					    </select>
					</div>
					<br><br>
					<div class="form-group">
						<label for="Content" ><h2>Service Image</h2></label>
						<input type="file" name="service_Img" id="serviceImg">
					</div>
					<br><br>
					    <input type="submit" value="SUBMIT" name="submit" class="btn btn-success">
					</form>
                </div>
                <!-- /page content -->
            </div>
        </div>
        @include('partials.admin_footer')
    </body>
</html>
<script type="text/javascript">
     $("form[name='new_servicefrm']").validate({
      // Specify validation rules
      rules: {
        // The key name on the left side is the name attribute
        // of an input field. Validation rules are defined
        // on the right side
        service_name: "required",
        service_active: "required",
        service_Img: "required",
      },
      // Specify validation error messages
      messages: {
        service_name: "Required",
        service_active: "Required",
        service_Img: "Required",
      },
    });
</script>
