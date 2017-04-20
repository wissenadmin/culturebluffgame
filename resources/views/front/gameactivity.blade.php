<link rel="stylesheet" href="{{url('/resources/admin-html')}}/assets/css/sweetalert.css" />
<script src="{{url('/resources/admin-html')}}/assets/js/sweetalert.min.js"></script>
<script type="text/javascript">
    //swal("error", "Your game licence has been expired please renew.", "success");
</script>
<div class="right-sec bg-white">
    <div class="edt-wrap">
        <h3 class="page-header"><b>Available Games</b></h3>
        <div class="table-responsive">
          
          @if(!empty(Session::get('error_1') && Auth::user()->user_parrent_id ==0))
            <script type="text/javascript">
                swal({
                  title: "",
                  text: "Your game licence has been expired please renew .",
                  type: "info",
                  //showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  confirmButtonText: "Renew",
                  closeOnConfirm: false
                },
                function(){
                  window.location.href = "{{url('front/buy-games')}}";
                });
          </script>
          @endif

            <table class="table">
                <thead class="thead-inverse">
                    <tr>
                        <!-- <th class="text-center">Game Title</th> -->
                        <th class="text-center">Game Link</th>
                        <!-- <th class="text-center">Licence Type</th> -->
                        <th class="text-center">Username</th>

                        <th class="text-center">Last Login</th>
                        <th class="text-center">License Expires</th>
                    </tr>
                </thead>
                <tbody>

                
                    @foreach($data['licenceinfo'] as $key => $value)
                    <tr style="<?php echo $key % 2 == 0 ? 'background-color: rgba(0, 0, 0, 0.05);' : ''; ?>">

                        <!-- <td class="text-center">{{$value->game_title}}</td> -->
                        <td class="text-center">
                        <!-- @if($value->game_licence == 5)
                        
                        Play <a target="_blank" href="{{url('front/game/CultureBuffBritainGame1_3')}}"> <button class="btn btn-info"> Game 1 </button></a> Or
                        <a target="_blank" href="{{url('front/game/CultureBuffBritainGame2_3')}}"> <button class="btn btn-info"> Game 2 </button></a>

                        @elseif($value->game_licence == 1 || $value->game_licence == 2 || $value->game_licence == 3 )
                         <a target="_blank" href="{{$value->game_link}}"> <button class="btn btn-info"> Play Game 1 </button></a>
                         @else 
                         <a target="_blank" href="{{$value->game_link}}"> <button class="btn btn-info"> Play Game 2</button></a>
                        @endif -->
                        @if($value->game_licence == 2)
                            <a  href="{{$value->game_link}}"> <button class="btn btn-info"> Play Trial Game </button></a>
                        @elseif($value->game_licence == 1)
                            <a  href="{{$value->game_link}}"> <button class="btn btn-info"> Play SuperTrial Game </button></a>
                        @else
                            <a  href="{{$value->game_link}}"> <button class="btn btn-info"> Play  {{$value->game_title}} Game </button></a>
                        @endif
                        
                        </td>
                        <!-- <td class="text-center">{{ucfirst($value->licence_type)}}</td> -->
                        <td class="text-center">{{$value->user_username}}</td>
                        
                        <td class="text-center 11">@if(Auth::user()->user_type == 1) {{changeDateFormat(Auth::user()->user_last_login)}} @else {{changeDateFormat($value->user_last_login)}}  @endif </td>
                        @if($value->game_licence == 2)
                            <td class="text-center">
                        <?php 
                            $date = strtotime($value->created_at);
                            $date = strtotime("+5 day", $date);
                            echo date('M d, Y', $date); ?></td>
                        @elseif($value->game_licence == 1 || count($data['licenceinfo']) > 1)    
                        <td class="text-center"> NA </td>
                        @else
                        <td class="text-center"><?php
                            $date = strtotime($value->created_at);
                            $licence_period   = $value->licence_period;
                            $date2 = "+".$licence_period." day";
                            $date = strtotime($date2, $date);
                            echo date('M d, Y', $date);

                         ?>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                   
                </tbody>


            </table>
            {!! $data['licenceinfo']->render()!!}
        </div>


    </div>
</div>