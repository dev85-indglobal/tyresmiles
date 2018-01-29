<!DOCTYPE html>
<html lang="en">
    @include('partials.admin_header')
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @include('partials.admin_topbar')
                <!-- page content -->
                <div class="right_col" role="main">
                    <form name="new_carsfrm" method="post" action="{{URL::to('/admin/cars-save')}}" enctype="multipart/form-data">
						{{ csrf_field()}}
					<div class="form-group">
					   <h1><center>Add New Cars</center></h1> 
					</div>
					<div class="form-group">
						<label for="Title" ><h2>Car Name</h2></label>
						<input type="text" name="name" class="form-control">

					</div>
					
					<div class="form-group">
            <label for="Title" ><h2>Car Type</h2></label>
            <select name="type_id" class="form-control">
              <option value="">Choose car type</option>
              @if(count($car_types)>0)
              @foreach($car_types as $ct)
              <option value="{{$ct->id}}">{{$ct->name}}</option>
              @endforeach
              @endif
            </select>
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
     $("form[name='new_carsfrm']").validate({
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
