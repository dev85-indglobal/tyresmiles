<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="{{{ URL::to('/public/img/favicon.ico') }}}">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tyresmiles</title>

    <!-- Bootstrap -->
    <link href="{{ URL::to('public/admin_css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::to('public/admin_css/font-awesome.min.css') }}" rel="stylesheet">
   
    <!-- Custom Theme Style -->
    <link href="{{ URL::to('public/admin_css/custom.min.css') }}" rel="stylesheet">
  </head>

  <body class="login">
    <div>
     @if(Session::has('message'))
      <p class="alert alert-info">{{ Session::get('message') }}</p>
     @endif

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form name="login_form" action="{{URL::to('/admin')}}" method="post">
              <h1>Admin Login</h1>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Email" name="email"/>
                <span style="color:red;">{{ $errors->first('email') }}</span>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" />
                <span style="color:red;">{{ $errors->first('password') }}</span>
              </div>
                {{ csrf_field() }}
                
              <div>
                <button type="submit" class="btn btn-default submit">Log in</button>
              </div>

              <div class="clearfix"></div>


            </form>
          </section>
        </div>

      </div>
    </div>
  </body>
</html>
