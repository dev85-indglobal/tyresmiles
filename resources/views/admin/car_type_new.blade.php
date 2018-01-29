<!DOCTYPE html>
<html lang="en">
    @include('partials.admin_header')
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @include('partials.admin_topbar')
                <!-- page content -->
                <div class="right_col" role="main">
                    <form name="new_carstypefrm" method="post" action="{{URL::to('/admin/car-types-save')}}" enctype="multipart/form-data">
						{{ csrf_field()}}
					<div class="form-group">
					   <h1><center>Add New Cars Types</center></h1> 
					</div>
					<div class="form-group">
						<label for="Title" ><h2>Car Type Name</h2></label>
						<input type="text" name="name" class="form-control">

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
     $("form[name='new_carstypefrm']").validate({
      // Specify validation rules
      rules: {
        // The key name on the left side is the name attribute
        // of an input field. Validation rules are defined
        // on the right side
        name: "required",  
      },
      // Specify validation error messages
      messages: {
        name: "Required",
      },
    });
</script>
