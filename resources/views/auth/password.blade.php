
<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.3/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 01 Sep 2015 13:12:22 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Forgot Password</title>

    <link href="{{url('/resources/assets/admin')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{url('/resources/assets/admin')}}/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="{{url('/resources/assets/admin')}}/css/animate.css" rel="stylesheet">
    <link href="{{url('/resources/assets/admin')}}/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">IN+</h1>

            </div>
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $error }}</div>
                @endforeach
            @endif
            <h3>Welcome to IN+</h3>
           
            <p>Login in. To see it in action.</p>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
            <?php //echo Form::token(); ?>
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" required="required" name="email" value="{{ old('email') }}">
                </div>
                
                <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>

                <a href="{{url('login')}}"><small>Login?</small></a>
                
            </form>
            
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{url('/resources/assets/admin')}}/js/jquery-2.1.1.js"></script>
    <script src="{{url('/resources/assets/admin')}}/js/bootstrap.min.js"></script>

</body>



</html>
