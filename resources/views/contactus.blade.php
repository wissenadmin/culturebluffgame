@include('front.includes.header')
<main>
<div class="container contact-us">
<h1>Have questions? Contact us.</h1>
<div class="contacts__form">
<!-- <h3>Please fill in the fields below and click submit.</h3> -->
@if(!empty(Session::get('success')))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{Session::get('success')}}
        </div>
        @endif
<form action="{{url('contactmail')}}" method="post">
<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
<div class="row">
<div class="col-md-6 col-sm-6">
 <img src="{{url('resources/assets/front')}}/images/contact-img.jpg"> 
</div> 
<div class="col-md-6 col-sm-6">
<div class="form-group">
 <input placeholder="Name" type="text" name="name" required="required"> 
</div>
<div class="form-group">
 <input placeholder="Email" type="email" name="email" required="required"> 
</div>
<div class="form-group">
<textarea placeholder="Message" rows="3" cols="9" required="required" name="message"></textarea>
</div>
<div class="form-group">
<input type="submit" class="button-submit-pp" value="Send message">
</div>
</div> 
</div>  
</form>
</div>
</div>
</main>

@include('front.includes.footer')
