@include('front.includes.header')
<main>
    <div class="container-fluid">
        <div class="row">
            <div class="left-content">
                <div class="left-tab">
                    <ul class="texts">
                        <li class="slideUp1 wow fadeInUp" data-wow-duration="3s" data-wow-delay="4s"><a href="#"><span>1</span>Understand Different Cultures</a>
                        </li>
                        <li class="slideUp2 wow fadeInUp" data-wow-duration="3s"  data-wow-delay="5.5s"><a href="#"><span>2</span>Know Cultural Values</a>
                        </li>
                        <li class="slideUp3 wow fadeInUp" data-wow-duration="3s"  data-wow-delay="6.5s"><a href="#"><span>3</span>Learn Cultural Behaviours</a>
                        </li>
                        <li class="slideUp4 wow fadeInUp" data-wow-duration="3s" data-wow-delay="7.5s"><a href="#"><span>4</span>Become Culturally Competent</a>
                        </li>
                    </ul>
                </div>
                <div class="about-game slideUp5 ">
                    <p id="js-rotating">Culture Buff Games have been specifically designed to help you develop cultural competence</p>
                </div>
            </div>
            <div class="mid-content">
                <div class="anmation-part">                       
                    <div id="set-text">
                <p class="quotes-blue quotes">I will help you understand what values are important in each country.</p>
                <p class="quotes-blue quotes">My name is Cultural Buff and I am an eminent professor of culture.</p>
                 <p class="quotes-blue quotes"> … and why people from different countries behave differently.</p>
                   <p class="quotes-yellow quotes">Are you interested in learning about British culture?</p> 
                    <p class="quotes-yellow quotes">Do you know what is important to British people?</p> 
                      <p class="quotes-round-yellow quotes">Now let’s see a preview of the game</p>
                    </div>
                </div>
                <div class="video-part">
                    <h3>Click Play To Preview Game</h3>
                    <span class="play-icon"><a href="#"><img src="{{url('resources/assets/front')}}/images/play-btn.png"></a></span>
                </div>
            </div>
            <div class="right-content">
                <div class="right-tab">
                  <img src="{{url('resources/assets/front')}}/images/london-bridge.png" class="l-bridge rotate-7" style="display:none">
                @if(empty(Auth::user()->user_id))
                  <a class="request button" href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">Request Trial</a>
                  <a href="#" class="purchase button" data-toggle="modal" data-target="#myModal1" data-backdrop="static" data-keyboard="false">Purchase Game</a>
                @endif
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Trigger the modal with a button -->
<!-- <button type="button" class="btn btn-info btn-lg" >Open Modal</button> -->

<!-- Modal -->
<div class="british-game-popup">
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span class="cross-close">&times;</span>
                    </button>
                    <h4 class="modal-title">Request Trial</h4>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="trialrequestform" method="post">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">First name</label>
                                    <input type="text" class="form-control" value="" required="required" name="first_name">
                                </div>
                                <div class="form-group">
                                    <label for="">Company Name</label>
                                    <input type="text" class="form-control" name="company_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Last name</label>
                                    <input type="text" class="form-control" required="required" name="last_name">
                                </div>
                                <div class="form-group">
                                    <label for="">Designation</label>
                                    <input type="text" class="form-control" required="required" name="designation">
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Sector</label>
                                    <input type="text" class="form-control" required="required" name="sector">
                                </div>

                                <div class="form-group">
                                    <label for="">Company Website</label>
                                    <input type="text" class="form-control" name="company_website">
                                </div>

                            </div>
                            <div  class="hide loading-img-popup wait"><img src="{{url('resources/dashboard/images')}}/demo_wait.gif" width="64" height="64" />
                                <br>Loading..</div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Country</label>
                                    <select class="form-control" name="country_id" required="required">
                                        {{getCountryOptionSrt()}}
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Email address</label>
                                    <input type="email" class="form-control" value="" required="required" name="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" value="" required="required" name="password">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" class="form-control" value="" required="required" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="message">

                        </div>

                </div>
                <div class="modal-footer">
                    <button style="" class="btn btn-grn pull-right submittrial button-submit-pp" type="submit">Request Trial</button>

                </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="british-game-popup">
    <div id="myModal1" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span class="cross-close">&times;</span>
                    </button>
                    <h4 class="modal-title">Purchase Game</h4>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="PurchaseGame" method="post">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">First name</label>
                                    <input type="text" class="form-control" value="" required="required" name="first_name">
                                </div>
                                <div class="form-group">
                                    <label for="">Company Name</label>
                                    <input type="text" class="form-control" name="company_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Last name</label>
                                    <input type="text" class="form-control" required="required" name="last_name">
                                </div>
                                <div class="form-group">
                                    <label for="">Designation</label>
                                    <input type="text" class="form-control" required="required" name="designation">
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Sector</label>
                                    <input type="text" class="form-control" required="required" name="sector">
                                </div>

                                <div class="form-group">
                                    <label for="">Company Website</label>
                                    <input type="text" class="form-control" name="company_website">
                                </div>

                            </div>

                            <div  class="hide loading-img-popup wait"><img src="{{url('resources/dashboard/images')}}/demo_wait.gif" width="64" height="64" />
                                <br>Loading..</div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Country</label>
                                    <select class="form-control" name="country_id" required="required">
                                        {{getCountryOptionSrt()}}
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Email address</label>
                                    <input type="email" class="form-control" value="" required="required" name="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" value="" required="required" name="password">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" class="form-control" value="" required="required" name="password_confirmation">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Account Type </label>
                                    <select required="required" name="user_type" class="form-control">
                                        <option value="1">Individual</option>
                                        <option value="2">Corporate</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="message">

                        </div>

                </div>
                <div class="modal-footer">
                    <button style="" class="btn btn-grn pull-right submittrial button-submit-pp" type="submit">Purchase Game</button>

                </div>
                </form>


            </div>

        </div>
    </div>
</div>
@include('front.includes.footer')
<script type="text/javascript"> 
$( window ).load(function() {
  //init
  new WOW().init(); 
  doSpeak(); 
});

//speak animation
function doSpeak(){  
  $( "img.c-speak" ).animate({
    top: 260,
    'marginTop': "+=20",
    'marginLeft': "+=200"
  }, {
    duration: 1000,    
    complete:function(){ 

        $( "img.c-speak" ).addClass('bounce animated speak')
        $( "img.c-speak" ).animate({
          left: 50
        },{
          duration: 1500,
          complete:function(){
            url = "{{url()}}" + "/resources/assets/front/images/animate.gif";
            //$( "img.l-bridge" ).fadeIn( "slow").addClass('rotateOutUpLeft animated').fadeOut('slow');  
                     
          }      
        }     
      )
    }
  });
}

$(document).ready(function() {
  //text rotating
  setTimeout(function(){
    $('#js-rotating').show();
    $('#js-rotating').textillate({
      in:{ 
          effect: 'fadeInUp', 
          delay: 70
         } 
      }); 
    }, 9000);

    //speak text animation
    $('#js-rotating').on('end.tlt', function () {
      url = "{{url()}}" + "/resources/assets/front/images/animate.gif";
      $("img.c-speak").attr("src", url);

      //text animation
      var quotes = $(".quotes");
      var quoteIndex = -1; 
      var count = quotes.length - 1; 
      function showNextQuote() {
        ++quoteIndex;
        if(quoteIndex != count){
          quotes.eq(quoteIndex % quotes.length)
              .fadeIn(2000)
              .delay(2000)
              .fadeOut(2000, showNextQuote);
        }else{
          quotes.eq(quoteIndex % quotes.length)
              .fadeIn(2000);
              setTimeout
            setTimeout(function(){
            url = "{{url()}}" + "/resources/assets/front/images/new-cartoon.png";
                      $("img.c-speak").attr("src", url);   
            }, 2000);


        }
      }       
      showNextQuote();
    });
   
    $('#trialrequestform').submit(function(ev) {
        ev.preventDefault(); // to stop the form from submitting
        var url = "{{url('request-trial')}}";
        $(".wait").removeClass("hide");
        // alert(url);
        //return false;
        var datastring = $("#trialrequestform").serialize();
        $.ajax({
            type: "POST",
            url: url,
            dataType: "Json",
            data: datastring,
            success: function(data) {
                $(".wait").addClass("hide");
                if (data.status == '1') {
                    $(".message").html('');
                    $(".message").html('<div class="alert alert-success"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>Trial request process successfully please check your email address to active your account.</div>');
                } else {
                    var errors = data.message; //this will get the errors response data.
                    errorsHtml = '<div class="alert alert-danger"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a><ul>';

                    $.each( errors , function( key, value ) {
                        errorsHtml += '<li>' + value + '</li>'; //showing only the first error.
                    });
                    //console.log(errorsHtml);
                    errorsHtml += '</ul></div>';
                    $(".message").html(errorsHtml);


                   // $(".message").html('<div class="alert alert-danger"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>Please check your data.</div>');
                }
            }
        });
        return false;
    })


    $('#PurchaseGame').submit(function(ev) {
        ev.preventDefault(); // to stop the form from submitting
        var url = "{{url('purchase-game')}}";
        $(".wait").removeClass("hide");
        // alert(url);
        //return false;
        var datastring = $("#PurchaseGame").serialize();
        $.ajax({
            type: "POST",
            url: url,
            dataType: "Json",
            data: datastring,
            success: function(data) {
                $(".wait").addClass("hide");
                if (data.status == '1') {
                    $(".message").html('');

                    $(".message").html('<div class="alert alert-success"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>Please check Your email address for next step.</div>');
                } else {
                    var errors = data.message; //this will get the errors response data.
                    errorsHtml = '<div class="alert alert-danger"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a><ul>';

                    $.each( errors , function( key, value ) {
                        errorsHtml += '<li>' + value + '</li>'; //showing only the first error.
                    });
                    //console.log(errorsHtml);
                    errorsHtml += '</ul></div>';
                    $(".message").html(errorsHtml);

                }
            }
        });
        return false;
    })
})
</script>