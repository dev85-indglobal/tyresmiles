<!DOCTYPE html>
<html lang="en">
    @include('partials.admin_header')
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @include('partials.admin_topbar')
                <!-- page content -->
                <div class="right_col" role="main">
                    <form name="new_ServicesubCat" method="post" action="{{URL::to('/admin/service-sub-categories-save')}}" enctype="multipart/form-data">
						{{ csrf_field()}}
					<div class="form-group">
					   <h1><center>Add Service Sub Categories</center></h1> 
					</div>
					
					<div class="form-group">
            <label for="Title" ><h2>Category_ID</h2></label>
            <select name="category_id" class="form-control">
              <option value="">Choose Category</option>
              @if(count($categories)>0)
              @foreach($categories as $ct)
              <option value="{{$ct->id}}">{{$ct->name}}</option>
              @endforeach
              @endif
            </select>
            </div>
            <br><br>
            <div class="form-group">
            <label for="Title" ><h2>Sub Category Name</h2></label>
            <input type="text" name="sub_category_name" class="form-control">
          </div>
           <br><br>
           <div class="form-group">
            <label for="Title" ><h2>Service details</h2></label>
            <input type="text" name="sub_category_name" class="form-control">
          </div>
           <br><br>
          <div class="form-group">
            <label for="Content" ><h2>Service Exists</h2></label>     
              <select name="type" class="form-control">
               <option value="1" >Yes</option>

               <option value="2">No</option>
              </select>
          </div>
          <br><br>
          <div class="form-group">
            <label for="Content" ><h2>Active</h2></label>     
              <select name="active" class="form-control">
               <option value="1" >yes</option>
               <option value="2">No</option>
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
     $("form[name='new_ServicesubCat']").validate({
      // Specify validation rules
      rules: {
        // The key name on the left side is the name attribute
        // of an input field. Validation rules are defined
        // on the right side
        category_id: "required",
        sub_category_name: "required",
        services_exist: "required",
        active: "required",
      },
      // Specify validation error messages
      messages: {
        category_id: "Required",
        sub_category_name: "Required",
        services_exist: "Required",
        active: "Required",  
      },
    });
</script>
