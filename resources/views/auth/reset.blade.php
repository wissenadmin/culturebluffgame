<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Culture Buff Games Reset Password </title>

    <!-- Bootstrap CSS -->    
    <link href="{{url('/resources/front-html')}}/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="{{url('/resources/front-html')}}/css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="{{url('/resources/front-html')}}/css/elegant-icons-style.css" rel="stylesheet" />
    <link href="{{url('/resources/front-html')}}/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="{{url('/resources/front-html')}}/css/style.css" rel="stylesheet">
    <link href="{{url('/resources/front-html')}}/css/style-responsive.css" rel="stylesheet" />


    <link href="{{url('resources/assets/front')}}/css/bootstrap.css" rel="stylesheet">
    <link href="{{url('resources/assets/front')}}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{url('resources/assets/front')}}/css/main.css" rel="stylesheet">
    <script src="{{url('resources/assets/front')}}/js/html5shiv.js"></script>
    <script src="{{url('resources/assets/front')}}/js/html5shiv-printshiv.js"></script>




    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-img3-body">

<header>

<div class="head-row1">
<div class="container-fluid">
  <div class="top-characters">
<a href="#"><img src="{{url('resources/assets/front')}}/images/top-cha.png"></a>  
</div>
 <div class="logo-top">
 <a href="#">Culture Buff Games</a></div>

</div>
</div>
<div class="head-row2">
     <nav class="navbar">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="{{url()}}">Home</a></li>
            <li><a href="about">About</a></li>
            <li><a href="faq">FAQ's</a></li>
            <li><a href="contactus">Contact Us</a></li>
          </ul>
        </div><!--/.nav-collapse -->
       </nav>
 <a href="{{url('login')}}" class="login button">Login</a>      
</div>
</header>

<main>
<div class="container-fluid">
        
       @if (count($errors) > 0)
        <div class="alert alert-danger">
          <!-- <strong>Whoops!</strong> There were some problems with your input.<br><br> -->
           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
     @endif

     <form class="login-form" role="form" method="POST" action="{{ url('/password/reset') }}">
     @if(!empty(Session::get('success_done')))
            <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
              <strong>Success!</strong> {{Session::get('success_done')}}
          </div>
          @endif 
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="login-wrap">
        <!-- <div class="input-field col s6">
            <input id="email" type="email" class="" name="email" value="{{ old('email') }}">
            <label for="email">Email</label>
        </div> -->
        <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              <input type="text" name="email" class="form-control" placeholder="Email" autofocus>
        </div>

        <div class="input-group">
              <span class="input-group-addon"><i class="icon_key_alt"></i></span>
              <input type="password" name="password" class="form-control" placeholder="password" autofocus>
        </div>

        <div class="input-group">
              <span class="input-group-addon"><i class="icon_key_alt"></i></span>
              <input type="password" name="password_confirmation" class="form-control" placeholder="confirm password" autofocus>
        </div>
        <button class="btn btn-primary btn-lg btn-block" type="submit">Reset</button>
       
        </div>
    </form>

    </div>
</main>

<footer>
 <p class="copyright">Copyright @ 2016 Culture Buff Games. All Rights Reserved</p> 
</footer>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="{{url('resources/assets/front')}}/js/bootstrap.min.js"></script>

<script type="text/javascript">
   /* $(document).ready(function(){
        $(".showforgot").click(function(){
            $(".login").addClass('hide');
            $(".forgot").removeClass('hide');
        })
        $(".showlogin").click(function(){
            $(".forgot").addClass('hide');
            $(".login").removeClass('hide');
        })
    })*/
</script>
  </body>
</html>
