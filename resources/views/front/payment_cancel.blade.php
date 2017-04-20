<style type="text/css">
    .topsapce{
        margin-top: 20px;
    }
    .topsapce1{
        margin-bottom: 20px;
    }
</style>
<div class=" bg-white">
  <div class="edt-wrap">
    <h3 class="page-header text-center topsapce1">Oops ! Game Purchase has been failed.</h3>
  <div class="row">
   <div class="col-md-12"> 
    <!-- <form method="post" class="reset-pass clearfix">
      <div class="form-group">
        <label for="">Old Password</label><br>
        <input type="password" name="old_password" value="" class="form-control" required="">
      </div> -->
      @if(!empty(Session::get('success')))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{Session::get('success')}}
        </div>
        @endif
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $error }}</div>
            @endforeach
        @endif

        <div class="text-center">
        <div class="top-characters ">
          <!-- <a href="#">
          <img src="{{url()}}/resources/assets/front/images/new-cartoon.png" ></a>  --> 
          </div>
        <h1 class="topsapce">There is something wrong with your payment process.</h1>
        <h1 class="topsapce">Please check all your payment information and settings. You can try again with same purchase URL.</h1>
        <h1 class="topsapce">Thank you.</h1>
        </div>


       <!--  <div class="text-center">
        <h1>Payment cancel</h1>
        <p>Your payment was cancel.</p>
        <p>Please check account setting, your payment canceled.</p>
        <p>Please use Purchase to Purchase game again.</p>
        <p>Thank you.</p>
        </div> -->
    </div>
    </div>
                  
  </div>
</div>