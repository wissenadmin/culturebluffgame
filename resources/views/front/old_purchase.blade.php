<div class=" bg-white">
  <div class="edt-wrap">
    <h3 class="page-header text-center">Purchase Game</h3>
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
    <form enctype="multipart/form-data" class="reset-pass clearfix" id="trialrequestform" method="post" >
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
       <div class="form-group">
        <label for="">Select licence Type</label><br>
        <select name="licenceType" class="form-control licenceType" required="required">
        @foreach($data['allLicence'] as $key => $value)
            <option value="{{$value->licence_id}}" >{{$value->licence_type}}</option> 
        @endforeach
        </select>
      </div>
     
      @if($data['user']['user_type'] == 2)
      <div class="form-group">
        <label for="">Number of licence</label><br>
        <input type="number"  name="numberoflicence" value="1" class="form-control number_of_licence" required="" min="1">
      </div>
      @else
      <input type="hidden"  name="numberoflicence" value="1" class="form-control number_of_licence" required="" min="1">
      @endif
      <?php //$payment =  ?> 
      <div class="form-group">
        <label for="">Payment</label><br>
        <input type="text" readonly="readonly" name="payment"  class="form-control payment" value="{{$data['allLicence'][0]->licence_price}}" required="">
      </div>
      <input type="hidden" name="cmd" value="_xclick" />
     <!--  <input type="hidden" name="no_note" value="1" /> -->
      <input type="hidden" name="lc" value="UK" />
      <input type="hidden" name="currency_code" value="GBP" />
      <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
      <!-- <input type="hidden" name="first_name" value="Customer's First Name"  />
      <input type="hidden" name="last_name" value="Customer's Last Name"  /> -->
      <!-- <input type="hidden" name="payer_email" value="customer@example.com"  /> -->
      <!-- <input type="hidden" name="item_number" value="123456" / > -->
      <div class="pull-right">
        <button type="submit" class="btn btn-grn">Purchase Game</button>
      </div>

    </form>
    </div>
    </div>
                  
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".number_of_licence").change(function(){
            getprice();
        })
        //.licenceType
        $(".licenceType").change(function(){
            getprice();
        })

        function getprice(){
            var number = $('.number_of_licence').val();
            
            if(null == number){
              number = 1;
            }
           // alert(number);
            var licenceType = $(".licenceType").val();
            var csrftoken = $("#csrf-token").val();
            var datastring = {'number':number,'licenceType':licenceType,'_token':csrftoken};
            $.ajax({
                type: "POST",
                url: "{{url('getprice')}}",
                dataType: "Json",
                data: datastring,
                success: function(data) {
                    var price = data.price;
                    $(".payment").val(price);
                }
            });
        }
    })
</script>