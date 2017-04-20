$(document).ready(function(){

   $("#registration").on('submit', function() {
        if($(".password").val() != $(".password2").val()) {
            //alert("Password does not match.");
            $(".password").closest(".form-group").addClass("has-error");
            $(".password2").closest(".form-group").addClass("has-error");

            return false;
        }
    });

   $("#user_registration").on('submit', function() {
        if($(".c_password").val() != $(".c_password2").val()) {
            //alert("Password does not match.");
            $(".c_password").closest(".form-group").addClass("has-error");
            $(".c_password2").closest(".form-group").addClass("has-error");

            return false;
        }
    });

   $("#searchformheader").on('submit', function() {
    var keyword =  $(".keyword").val();
    var location = $(".location").val();
            if(keyword =='' && location == '') {
            $(".keyword").closest(".form-group").addClass("has-error");
            $(".location").closest(".form-group").addClass("has-error");

            return false;
        }
    });
   
    // JS for cat serach
    $(".categoryList").click( function(){
        $("#catform").submit();
    });

    $(".ratingsSort").click( function(){
        $("#catform").submit();
    });
     $("[name='sortby']").on('change', function(e){
         e.preventDefault();
        $("#catform").submit();
    });

    $(".categoryclear").click( function(e) {
        e.preventDefault();
        $('.categoryList').removeAttr('checked');
        $("#catform").submit();
    });

     $(".ratingclear").click( function(e) {
        e.preventDefault();
        $('.ratingList').removeAttr('checked');
        $("#catform").submit();
    });
// js for forgot password
    $(".formforgotpassword").submit(function(e){
        e.preventDefault();
        var url = document.URL+"/forgotpassword";
        
        var email =   $(".forgotemail").val();
        var datastring = $(".formforgotpassword").serialize();

        $.ajax({
            type: "POST",
            url: url,
            dataType: "Json",
            data: datastring,
            success: function(data) {
            var baseurl = "<?php echo base_url();?>";    
                if(data.status == 0)
                {
                    $( ".messgaeforgot" ).empty();
                    $( ".messageLableemail" ).hide();
                    $( ".forgotemail" ).hide();
                    $( ".hidehide" ).hide();
                    $( ".fortgotsend" ).hide();
                    
                    $(".messgaeforgot").append("This Email Id Not Exits Kindly Check Again.");
                }
                else
                {
                    $( ".messageLableemail" ).hide();
                    
                    $( ".hidehide" ).hide();
                    $( ".forgotemail" ).hide();
                    $( ".fortgotsend" ).hide();
                    $(".messgaeforgot").append("Please Check Your Email Acount Reset Link Sent.");
                }
            }
        });
        return false;
    });

// JS for Subscribe email
	$(".newsLetterSubscribe").submit(function(e){
        e.preventDefault();
		var url = document.URL+"home/subscribeNewsletter";
		
		var email =   $(".emailSubscribe").val();
	   	var datastring = $(".newsLetterSubscribe").serialize();
    	
        $.ajax({
            type: "POST",
            url: url,
            dataType: "Json",
            data: datastring,
            success: function(data) {
                if(data.status == 0)
                {
                    $( ".showmessagenews" ).empty();
                    $(".showmessagenews").append("Email is Already Subscribed.");
                }
                else
                {
                    $( ".showmessagenews" ).empty();
                    $(".showmessagenews").append("Thanks for Subscribe News-Letter.");
                }
            }
        });

        return false;
    });

//  js to get all state list
    $("#allcountry, #allstatelist, #allmakelist, #allcountryList ,#allstate").change(function(e) {
         e.preventDefault();

        var selectedModels  = "";
        var elementType     = $(this).attr("id");
        var elementValue    = this.value;
        var url             = document.URL;
        var datastring      = {};
        var elementToUpdate = "";
        var elementToUpdate1 = "";

        switch(elementType) {
            case 'allcountry' :
                datastring.countryId = elementValue;
                url += "/allStateList";
                elementToUpdate = "allstatelist";
                elementToUpdate1 = "allcitylist";
                break;
            case 'allstatelist' :
                datastring.stateId = elementValue;
                url += "/allCityList";
                elementToUpdate = "allcitylist";
                break;
            case 'allmakelist' :
                elementValue        = $(this).val();
                datastring.makeId   = elementValue;
                selectedModels      = $("#allmodellist").val();
                url                 += "/allmodellist";
                elementToUpdate     = "allmodellist";
                break; 
            case 'allcountryList' :
                datastring.countryId = elementValue;
                url += "/allStateList";
                elementToUpdate = "allstate";
                break;   
            case 'allstate' :
                datastring.stateId = elementValue;
                url += "/allCityList";
                elementToUpdate = "allcity";
                break;      
        }

        $.ajax({
            type: "POST",
            url: url,
            dataType: "Json",
            data: datastring, 
            success: function(data) { 
                $("#"+elementToUpdate).html("");

                if(elementToUpdate1 != "") {
                    $("#"+elementToUpdate1). html("");
                }
                
                var optionString = "";

                $.each(data, function(index, state) {

                    if($.inArray(state.id, selectedModels) !== -1) {
                        optionString += "<option value=\""+state.id+"\" selected=\"selected\">"+state.name+"</option>";
                    }
                    else {
                        optionString += "<option value=\""+state.id+"\">"+state.name+"</option>";
                    }
                });
                
                $("#"+elementToUpdate).append(optionString);
            }
        });
    });


    // js for load more

    $(".loadmore").click(function(){
        var url = document.URL;
        var n = url.search("category="); 
        var offset =   dataOffset;
        var formSet = {};
        formSet.query = $("#catform").serialize(); 
        url = url+"/pagination"
        formSet.offset = offset;


        if(n > 1)
        {
            var fields  = url.split(/=/);
            var catname = fields[1];
            var siteurl = url.split(/[?]/);
            //alert(siteurl[0]);
            var newurl  = siteurl[0]+"/"+"pagination?category="+catname;
            var url     = newurl ;
        }
        $.ajax({
            type: "POST",
            url: url,
            dataType: "Json",
            data: formSet,
            success: function(data) { 
            if(data.error == 0)
            {
                jQuery(".loadsearhbutton").hide();
                return false;
            }  
            
            $(".data-Searchappend").append(data.returnHtml);
            var newoffset = data.offset;
            dataOffset = newoffset;
            if(dataOffset >= totalResultsAvailable) {
                jQuery(".loadsearhbutton").hide();
            }

            console.log($(this).data("offset")); //  yes change you atribute
            }
        });
    });
});


$(document).ready(function() {

      var owl = $("#owl-demo");

      owl.owlCarousel({

      items : 4, //10 items above 1000px browser width
      itemsDesktop : [1000,3], //5 items between 1000px and 901px
      itemsDesktopSmall : [800,2], // 3 items betweem 900px and 601px
      itemsTablet: [400,1], //2 items between 600 and 0;
      itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
      
      });

      // Custom Navigation Events
      $(".next").click(function(){
        owl.trigger('owl.next');
      })
      $(".prev").click(function(){
        owl.trigger('owl.prev');
      })
      $(".play").click(function(){
        owl.trigger('owl.play',1000);
      })
      $(".stop").click(function(){
        owl.trigger('owl.stop');
      })
    
    


    });
    $(document).ready(function() {
      $("#owl-news").owlCarousel({

      navigation : true,
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem : true

      // "singleItem:true" is a shortcut for:
      // items : 1, 
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false

      });
    });
 
    //js to get advertisement price as per plan
    $("#allAdvertisePlan").change(function(e) {
        e.preventDefault();
        var elementType = $(this).attr("id"); 
        var elementValue = this.value; 
        var url = document.URL;
        var datastring = {};
        var elementToUpdate = "";
        var elementToUpdate1 = "";
        switch(elementType) {
            case 'allAdvertisePlan' :
                datastring.advertiseId = elementValue;
                url += "/allAdvertisementPrice";
                elementToUpdate = "allAdvertisementPrice";
                break;
        }//alert(JSON.stringify(datastring));
        $.ajax({
            type: "POST",
            url: url,
            dataType: "Json",
            data: datastring,
            success: function(data) {
                var priceValue 		= data.plan_payment;
                elementToUpdate1	= "adimage";
                $("#"+elementToUpdate).val(priceValue);
                $("#"+elementToUpdate1).attr("src",baseUrl+data.image);
                $("#hide_show_div").removeAttr("class","hidden");
                $("#hide_show_div").addClass("row visible");
            }
        });
    });


    $("#allMembershipPlan").change(function(e) {  
        e.preventDefault();
        var elementType = $(this).attr("id"); 
        var elementValue = this.value; 
        var url = baseUrl+ "myaccount/allMembershipPrice";
        var datastring = {};
        var elementToUpdate = "";
        switch(elementType) {
            case 'allMembershipPlan' :
                datastring.membershipPlanId = elementValue;
                elementToUpdate = "allMembershipPrice";
                break;
        }//alert(JSON.stringify(datastring));
        console.log(url);
        $.ajax({
            type: "POST",
            url: url,
            dataType: "Json",
            data: datastring,
            success: function(data) {
                
                var priceValue = data.plan_price;
                $("#"+elementToUpdate).val(priceValue);
            },
            error : function(data) {
                
            }
        });
    });