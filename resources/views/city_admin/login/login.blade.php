@extends('login-auth-file.loginauth')
@section('content')
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Mangao Mart</title>
  <!-- Tell the browser to be responsive to screen width -->
 
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="">
  <div class="container" id="container">
    <div class="form-container sign-in-container">
      <form method="POST" id="laravelCityAdminLoginForm" action="{{ url('check-login-for-city-admin') }}">
        @csrf
        <h1> <img src="{{asset('commonarea/dist/img/logo.png')}}" style="height: 170px;" alt="logo"></h1>
      
        <div class="col-md-12">
          <input type="email" placeholder="Email" name="email"/>
        </div>
        <div class="col-md-12">
          <input type="password" placeholder="Password" id="password" name="password" />
          <span class="pass-show"><i class="fa fa-eye-slash"></i></span>
        </div>
        <div class="col-md-12">
          <div class="pad-10px mb-10px">
            <a href="{{ url('/') }}">Forgot your password?</a>
          </div>
        </div>
        <div class="col-md-12">
        <input type="submit" value="submit" class="btn btn-primary">
        </div>
      </form>
    </div>
    
  </div>



</body>

</html>
@endsection

