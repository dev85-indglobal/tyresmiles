<!DOCTYPE html>
<html lang="en">
    @include('partials.admin_header')
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @include('partials.admin_topbar')
                <!-- page content -->
                <div class="right_col" role="main">
                    <form name="new_vendorsfrm" method="post" action="{{URL::to('/admin/vendors-save')}}" enctype="multipart/form-data">
						{{ csrf_field()}}
					<div class="form-group">
					   <h1><center>Create New Vendors</center></h1> 
					</div>
					<div class="form-group">
						<label for="Title" ><h2>Vendor Name</h2></label>
						<input type="text" name="vendor_name" class="form-control">

					</div>
          <div class="form-group">
            <label for="Title" ><h2>Vendor Category ID</h2></label>
            <input type="text" name="category_id" class="form-control">

          </div>
          <div class="form-group">
            <label for="Title" ><h2>Vendor Address</h2></label>
            <input type="text" name="address" class="form-control">

          </div>
           <div class="form-group">
            <label for="Title" ><h2>Currency</h2></label>
            <input type="text" name="currency" class="form-control">

          </div>
           <div class="form-group">
            <label for="Title" ><h2>price</h2></label>
            <input type="text" name="price" class="form-control">

          </div>
          <div class="form-group">
            <label for="Title" ><h2>City Id</h2></label>
            <select name ="city_id" class="form-control">
              <option value ="">Choose City</option>
              @if(sizeof($city)>0)
              @foreach($city as $c)
              <option value ="{{$c->id}}">{{$c->name}}</option>
              @endforeach
              @endif

            </select>

          </div>
					<div class="form-group">
						<label for="Content" ><h2>Active</h2></label>	   	
					    <select name="type" class="form-control">
					     <option value="1" >Opened</option>

					     <option value="2">Closed</option>
					    </select>
					</div>
					<br><br>
					<div class="form-group">
						<label for="Content" ><h2>Vendor Image</h2></label>
						<input type="file" name="logo" id="logo">
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
     $("form[name='new_vendorsfrm']").validate({
      // Specify validation rules
      rules: {
        // The key name on the left side is the name attribute
        // of an input field. Validation rules are defined
        // on the right side
        category_id :'required',
        vendor_name :'required',
        address : 'required',
        city_id :'required',
        logo :'required',
        currency :'required',
        price :'required',
        type :'required', // 1-opened, 2-closed.
      },
      // Specify validation error messages
      messages: {
        category_id :'Required',
        vendor_name :'Required',
        address : 'Required',
        city_id :'Required',
        logo :'Required',
        currency :'Required',
        price :'Required',
        type :'Required', // 1-opened, 2-closed.
      },
    });
</script>
