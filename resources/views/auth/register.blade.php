<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Register</title>

    <link href="{{url('resources/assets/admin')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{url('resources/assets/admin')}}/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="{{url('resources/assets/admin')}}/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="{{url('resources/assets/admin')}}/css/animate.css" rel="stylesheet">
    <link href="{{url('resources/assets/admin')}}/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">IN+</h1>

            </div>
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $error }}</div>
                @endforeach
            @endif
            <h3>Register to IN+</h3>
            <p>Create account to see it in action.</p>
             <form action="{{url('auth/register')}}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" name="first_name" value="{{ old('first_name') }}" required="">
                </div>
                 <div class="form-group">
                    <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Userame" name="username" value="{{ old('username') }}" required="">
                </div>

                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password " required="">
                </div>

                <div class="form-group">
                    <select name="account_type" class="form-control"> <option value="0"> Select Account Type</option><option value="1"> Business Account</option><option value="2"> Developer Account </option> </select>
                </div>

                <!-- <div class="form-group">
                    <input type="password" name="password" class="form-control" name="password_confirmation" placeholder="Retype password">
                </div> -->

                <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Agree the terms and policy </label></div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="login.html">Login</a>
            </form>
            
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{url('resources/assets/admin')}}/js/jquery-2.1.1.js"></script>
    <script src="{{url('resources/assets/admin')}}/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="{{url('resources/assets/admin')}}/js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
</body>



</html>
