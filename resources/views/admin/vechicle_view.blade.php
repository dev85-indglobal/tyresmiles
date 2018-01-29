<!DOCTYPE html>
<html lang="en">
    @include('partials.admin_header')
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @include('partials.admin_topbar')
                <!-- page content -->
                <div class="right_col" role="main">
                    @foreach($service_data as $sd)
                    <form name="edit_carsfrm" method="post" action="{{URL::to('/admin/cars-edit')}}" enctype="multipart/form-data">
						{{ csrf_field()}}
					<div class="form-group">
					   <h1><center>Edit Car Names</center></h1> 
					</div>
					<div class="form-group">
						<label for="Title" ><h2>Car Name</h2></label>
						<input type="text" name="name" value="{{$sd->name}}" class="form-control">

					</div>
					
					<div class="form-group">
            <label for="Content" ><h2>Car Type</h2></label>     
            <select name="type_id" class="form-control">
              <option value="">Choose car type</option>
              @if(count($car_types)>0)
              @foreach($car_types as $ct)
              <option value="{{$ct->id}}" 
                @if(($sd->type_id) == $ct->id) <?php echo "selected=selected"; ?>
                @endif>{{$ct->name}}
              </option>
              @endforeach
              @endif
            </select>
          </div>
					<br><br>
					    <input type="submit" value="UPDATE" name="submit" class="btn btn-success">
					    <input type="hidden" name="id" value="{{$sd->id}}">
					</form>
					@endforeach
                </div>
                <!-- /page content -->
            </div>
        </div>
        @include('partials.admin_footer')
    </body>
</html>
<script type="text/javascript">
     $("form[name='edit_carsfrm']").validate({
      // Specify validation rules
      rules: {
        // The key name on the left side is the name attribute
        // of an input field. Validation rules are defined
        // on the right side
        name: "required",
        type_id: "required",
       
      },
      // Specify validation error messages
      messages: {
        name: "Required",
        type_id: "Required",
      },
    });
</script>

