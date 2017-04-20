<style type="text/css">
    .topsapce{
        margin-top: 10px;
    }
    .topsapce1{
        margin-bottom: 20px;
    }
</style>
<div class=" bg-white">
  <div class="edt-wrap">
    <h3 class="page-header text-center topsapce1">Game Purchased Successfully.</h3>
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
        <div class="top-characters topsapce1">
          <a href="#">
          <img src="{{url()}}/resources/assets/front/images/new-cartoon.png" ></a>  
          </div>
        <h1 class="topsapce">You have purchased the game license successfully.</h1>
        <h1 class="topsapce">Please find the login details of your purchased game at your submitted email address.</h1>
        <h1 class="topsapce">Thank you.</h1>
        </div>
    </div>
    </div>
                  
  </div>
</div>