@include('front.includes.header')
<section id="account-sec">
<div class="container-fluid">




<?php 

/*$users = User::where('id',1)->first();
print_r($users);*/
$content = $data['main_content'];
$content = "front.$content"; ?>
@include("{$content}")
</div>
</section>
@include('front.includes.footer')