<!-- sidebar -->
<div class="right-sec bg-white">
<div class="edt-wrap">
  <h3 class="page-header"><b>Purchased Licenses</b></h3>
   <div class="table-responsive">
    @if(!empty(Session::get('success')))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{Session::get('success')}}
        </div>
        @endif
      <table class="table">
       <thead class="thead-inverse">
        <tr>
          <th class="text-center">License Title</th>
          <th class="text-center">Username</th>
          <th class="text-center">Purchase Date</th>
          <th class="text-center">License Duration (Days)</th>
          <th class="text-center">License Expires</th>
          <th class="text-center"> Action </th>
        </tr>
      </thead>
      <tbody>
    @foreach($data['licenceinfo'] as $key => $value) 
        <tr>
          <td class="text-center">{{$value->licence_type}}</td>
          <td class="text-center">{{$value->user_username}}</td>
          
          <?php
            $date = strtotime($value->created_at);
            $date1 = date('M d, Y', $date);
           ?>
           <td class="text-center">{{$date1}}</td>
          <td class="text-center">{{$value->licence_period}}</td>
          <td class="text-center">{{changeDateFormat($value->licence_valid_till)}}</td>
          <td class="text-center"><a href="{{url('front/change-userpassword',$value->user_id)}}"><button class="btn btn-success"> Change Password</button></a></td>
        </tr>
    @endforeach
      </tbody>
     </table>
     {!! $data['licenceinfo']->render()!!}
      </div>
    </div>
</div>

    