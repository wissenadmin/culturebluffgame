<style type="text/css">
    .topsapce{
        margin-top: 10px;
    }
    .topsapce1{
        margin-bottom: 20px;
    }
    .topsapce3{
        margin-top: 30px;
    }
    .topsapce2{
        margin-top: 20px;
    }
    .topsapce5{
        margin-top: 50px;
    }
</style>
<div class=" bg-white">
  <div class="edt-wrap">
    <h3 class="page-header text-center">Purchase Culture Buff Games</h3>
  <div class="row">
   <div class="col-md-12"> 
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
      
          
               <label for="" class="topsapce1">Please select one or more games that you would like to purchase and review the total price prior to clicking the Purchase Game button:</label> <br> 

               <div class="row topsapce3 text-left" style="font-size: 16px">
    
                    <div class="col-md-12"> 
                        <div class="col-md-4 col-sm-4">
                           <b> License Type</b>
                        </div>
                        
                        <div class="col-md-4 col-sm-4">
                        <?php
                            // if($user_type == ) {?>
                           <b> Number Of Licenses</b>
                        <?php //} ?>
                        </div>
                        
                        <div class="col-md-4 col-sm-4">
                            <b>Price Subtotal</b>
                        </div>

                    </div>
                </div>

                @foreach($data['allLicence'] as $key => $value)
                <div class="row topsapce2">
                    <div class="col-md-4">
                        <div class="form-group">
                    <input  type="checkbox" data-price="{{$value->licence_price}}" name="licenceType[]" data-gamename="{{$value->licence_type}}" class="licenceType " value="{{$value->licence_id}}"> 
                    {{$value->licence_type}}
                        </div>
                        </div>
                        <div class="cartbox id_{{$value->licence_id}}">
                        <?php
                        $user_type = $data['user']['user_type'];

                        if($user_type == 2){ ?>

                                <div class="col-md-4 col-sm-4"><input data-value1="1" type="number" onkeydown="return false" data-licenceid="{{$value->licence_id}}" @if($key == 0) value="1" @else value="1" @endif    min="0" max="10" class="numberoflinces lid_{{$value->licence_id}}" data-id="gameid" name="numberoflicence[{{$value->licence_id}}]"></div>

                            <?php } else {
                                ?>
                                <div class="col-md-4 col-sm-4"><input data-value1="1" type="text" readonly="readonly" onkeydown="return false" data-licenceid="{{$value->licence_id}}" value="1" class="numberoflinces lid_{{$value->licence_id}}" data-id="gameid" name="numberoflicence[{{$value->licence_id}}]"></div>

                                <?php } ?>

                                <div class="col-md-4 col-sm-4 pricebox_{{$value->licence_id}}">&pound;<span class="price">  @if($key == 0) 0 @else 0 @endif </span></div>

                    </div>
                </div>
                @endforeach
                @if($user_type != 1)
                <div  class="hide loading-img-popup wait text-center"><img 
                    src="{{url('resources/dashboard/images')}}/demo_wait.gif" width="64" height="64" />
                    <br>Loading..
                </div>
                @endif
               

        

        
      <input type="hidden" name="upload" value="1" />          
       <input type="hidden" name="cmd" value="_cart" /> 
     <!-- <input type="hidden" name="cmd" value="_xclick" /> -->
     <!--  <input type="hidden" name="no_note" value="1" /> -->
      <input type="hidden" name="lc" value="UK" />
      <input type="hidden" name="currency_code" value="GBP" />
      <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
      <!-- <input type="hidden" name="first_name" value="Customer's First Name"  />
      <input type="hidden" name="last_name" value="Customer's Last Name"  /> -->
      <!-- <input type="hidden" name="payer_email" value="customer@example.com"  /> -->
      <!-- <input type="hidden" name="item_number" value="123456" / > -->
      <div class="finalprice   row topsapce2">
       <div class="col-md-12  text-center "><h1>Total Price (GBP) : <span class="finlprice"></span></h1></div> </div>

      <div class="topsapce5">
        <button type="submit" class="btn btn-grn ">Purchase Game</button>
      </div>

    </form>

        

    </div>
    </div>
                  
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        updateTotal();
        
        $(".licenceType").click(function(){
            var licence_id = $(this).val();
            if ($(this).is(':checked')) {
                            				$(".lid_"+licence_id).val(1);
                number = $(".lid_"+licence_id).val();
                getprice(licence_id,number);
            }else{
                price = 0;
                var classs= "pricebox_"+licence_id;
                var html = '&pound; <span class="price">'+price+'</span>';	
				$(".lid_"+licence_id).val(0);
                //alert(html);
                $("."+classs).html(html);
                updateTotal();
            }
            
        });

        //$(".numberoflinces").change(function(){
        $(document).on("change",".numberoflinces",function() {
            number = $(this).val();
       
            licenceType = $(this).attr("data-licenceid");
            var price =  getprice(licenceType,number);
        })


        /*$(".number_of_licence").change(function(){
            getprice();
        })*/
        //.licenceType
        /*$(".licenceType").change(function(){
            getprice();
        })*/

        function updateTotal(){
            var price = 0;
            $('.price').each(function(i, el) {
               x = $(el).html();
               x =  parseInt(x);
               price = price + x;
            });
            if(price != 0){
                $(".finalprice").removeClass("hide");
            }else{
              //  $(".finalprice").addClass("hide");
            }
            price ="&pound; "+price+".00"
            $(".finlprice").html(price);
        }

        

        function getprice(licenceType = '',number =''){
            $(".loading-img-popup").removeClass("hide");
            var csrftoken = $("#csrf-token").val();
            var datastring = {'number':number,'licenceType':licenceType,'_token':csrftoken};
            $.ajax({
                type: "POST",
                url: "{{url('getprice')}}",
                dataType: "Json",
                data: datastring,
                success: function(data) {
                    var price = data.price;
                    var classs= "pricebox_"+licenceType;
                    var html = '&pound; <span class="price">'+price+'</span>';
                    //alert(html);
                    $("."+classs).html(html);
                    updateTotal();
                     $(".loading-img-popup").addClass("hide");
                }
            });
        }
    })
</script>