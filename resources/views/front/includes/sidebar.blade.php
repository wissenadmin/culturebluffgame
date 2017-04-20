<div class="sidebar">
    <aside class="pro-side-wrap">
	  @if(Auth::user()->user_type == 2)
        <div class="thumbnail text-center customer-name @if(Auth::user()->user_type != 1  || Auth::user()->user_parrent_id != 0) compny_name_rect @endif">
            <!-- <img class="img-responsive radius-0" src="{{url('/resources/dashboard')}}/images/Client-icon.png" width="200px" alt="profile image"> -->
            @if(Auth::user()->user_type != 1  || Auth::user()->user_parrent_id != 0)
                <h4><i class="fa fa-university" aria-hidden="true"></i> {{userdata()}} </h4>
            @endif    

        </div>
  @endif    
        <div class="text-center customer-name">
            <h4> <i class="fa fa-user" aria-hidden="true"></i>  {{Auth::user()->user_username}}</h4>
        </div>
        <div class="list-wrap">
            <ul class="avi-list-group">
                @if(Auth::user()->user_type == 2)
                <a class="avi-list-group-item @if(Request::segment(2) == 'home' ) active @endif " href="{{url('front/home')}}"><i class="fa fa-heart"></i> Purchased Licenses</a>
                @endif

                <a class="avi-list-group-item @if(Request::segment(2) == 'game-activity' ) active @endif" href="{{url('front/game-activity')}}"><i class="fa fa-key"></i>Available Games</a>
                @if(Auth::user()->user_parrent_id ==0)
                <a class="avi-list-group-item @if(Request::segment(2) == 'profile' ) active @endif" href="{{url('front/profile')}}"><i class="fa fa-edit"></i>Edit Profile</a>

                <a class="avi-list-group-item @if(Request::segment(2) == 'buy-games' ) active @endif" href="{{url('front/buy-games')}}"><i class="fa fa-money"></i>Buy Games</a>

                @endif
                <a class="avi-list-group-item @if(Request::segment(2) == 'reset-password' ) active @endif" href="{{url('front/reset-password')}}"><i class="fa fa-lock"></i>Reset Password</a>
                <a class="avi-list-group-item" href="{{url('frontlogout')}}"><i class="fa fa-sign-out "></i>Logout</a>
            </ul>
        </div>
    </aside>
</div>