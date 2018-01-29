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

                    <form name="edit_servicesubcat" method="post" action="{{URL::to('/admin/service-sub-categories-edit')}}" enctype="multipart/form-data">
						{{ csrf_field()}}
					<div class="form-group">
					   <h1><center>Edit Sub Category </center></h1> 
					</div>
          <div class="form-group">
            <label for="Content" ><h2>category Type</h2></label>     
            <select name="category_id" class="form-control">
              <option value="">category_ID</option>
              @if(count($service_types)>0)
              @foreach($service_types as $st)
              <option value="{{$st->id}}" 
                @if(($sd->category_id) == $st->id) <?php echo "selected=selected"; ?>
                @endif>{{$st->name}}
              </option>
              @endforeach
              @endif
            </select>
          </div>
					<div class="form-group">
						<label for="Title" ><h2>Sub Category Name</h2></label>
						<input type="text" name="sub_category_name" value="{{$sd->sub_category_name}}" class="form-control">

					</div>
          <br><br>
          <div class="form-group">
            <label for="Content" ><h2>Service Exists</h2></label>     
              <select name="services_exist" class="form-control">
               <option value="1" 
                @if($sd->services_exist == 1) 
                  <?php echo "Opened='Opened'" ?>
                @endif
               >Yes</option>
               <option value="2"
                @if($sd->services_exist == 2) 
                  <?php echo "closed='Closed'" ?>
                @endif
               >No</option>
              </select>
          </div>
          <br><br>
          <div class="form-group">
            <label for="Content" ><h2>Active</h2></label>     
              <select name="active" class="form-control">
               <option value="1" 
                @if($sd->active == 1) 
                  <?php echo "Opened='Opened'" ?>
                @endif
               >Yes</option>
               <option value="2" 
                @if($sd->active == 2) 
                  <?php echo "closed='closed'" ?>
                @endif
               >No</option>
              </select>
          </div>
					
					
					<br><br>
					    <input type="submit" value="UPDATE" name="submit" class="btn btn-success">
					    <input type="hidden" name="id" value="{{$sd->sub_category_id}}">
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
     $("form[name='edit_servicesubcat']").validate({
      // Specify validation rules
      rules: {
        // The key name on the left side is the name attribute
        // of an input field. Validation rules are defined
        // on the right side
        sub_category_name: "required",
        category_id: "required",
        services_exist: "required",
        active: "required",
       
      },
      // Specify validation error messages
      messages: {
        name: "Required",
        category_id: "Required",
        services_exist: "Required",
        active: "Required",
      },
    });
</script>

