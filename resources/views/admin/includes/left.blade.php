<div id="main-container" class="main-container">

<div class="sidebar                  responsive" id="sidebar" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
  <script type="text/javascript">
    try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
  </script>
  <div id="sidebar-shortcuts" class="sidebar-shortcuts">
    <!-- <div id="sidebar-shortcuts-large" class="sidebar-shortcuts-large">
      <button class="btn btn-success">
      <i class="ace-icon fa fa-signal"></i>
      </button>
      <button class="btn btn-info">
      <i class="ace-icon fa fa-pencil"></i>
      </button>
      <button class="btn btn-warning">
      <i class="ace-icon fa fa-users"></i>
      </button>
      <button class="btn btn-danger">
      <i class="ace-icon fa fa-cogs"></i>
      </button>
    </div> -->
    <div id="sidebar-shortcuts-mini" class="sidebar-shortcuts-mini">
      <span class="btn btn-success"></span>
      <span class="btn btn-info"></span>
      <span class="btn btn-warning"></span>
      <span class="btn btn-danger"></span>
    </div>
  </div>
  <!-- /.sidebar-shortcuts -->
  <ul class="nav nav-list" style="top: 0px;">
    <!-- <li @if(empty(Request::segment(2))) class="active" @endif>
      <a href="{{url('admin')}}">
      <i class="menu-icon fa fa-tachometer"></i>
      <span class="menu-text"> Dashboard </span>
      </a>
      <b class="arrow"></b>
    </li> -->
    <li @if(Request::segment(2) == 'games' || empty(Request::segment(2))) class="active" @endif>
      <a  href="{{url('admin/games')}}">
      <i class="menu-icon fa fa-gamepad"></i>
      <span class="menu-text">
      Games 
      </span>
      </a>
    </li>
    
    <li @if(Request::segment(2) == 'users' ) class="active" @endif>
      <a  href="{{url('admin/users')}}">
      <i class="menu-icon fa fa-users"></i>
      <span class="menu-text">
      Users
      </span>
      </a>
    </li>

    <li @if(Request::segment(2) == 'super-trial') class="active" @endif>
      <a  href="{{url('admin/super-trial')}}">
      <i class="menu-icon fa fa-users"></i>
      <span class="menu-text">
       Super Trial
      </span>
      </a>
    </li>
    
    <li @if(Request::segment(2) == 'licences' && Request::segment(3) != 'manual-generation' ) class="active" @endif>
      <a  href="{{url('admin/licences')}}">
      <!--i class="menu-icon  fa-chevron-circle-right"></i-->
      <i class="menu-icon fa fa-certificate" aria-hidden="true"></i>
      <span class="menu-text">
      License Master
      </span>
      </a>
    </li>

    <li @if(Request::segment(2) == 'licences-report' || Request::segment(2) == 'licences-view' || Request::segment(3) == 'manual-generation' ) class="active" @endif>
      <a  href="{{url('admin/licences-report')}}">
      <!--i class="menu-icon  fa-chevron-circle-right"></i-->
      <i class="menu-icon fa fa-certificate" aria-hidden="true"></i>
      <span class="menu-text">
      Licence Report
      </span>
      </a>
    </li>


    <li @if(Request::segment(2) == 'static-page' ) class="active" @endif>
      <a  href="{{url('admin/static-page')}}">
      <i class="menu-icon fa fa-file"></i>
      <span class="menu-text">
      Page Manager
      </span>
      </a>
    </li>
  </ul>
  <!-- /.nav-list --> 
  <div id="sidebar-collapse" class="sidebar-toggle sidebar-collapse">
    <i data-icon2="ace-icon fa fa-angle-double-right" data-icon1="ace-icon fa fa-angle-double-left" class="ace-icon fa fa-angle-double-left"></i>
  </div>
  <script type="text/javascript">
    try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
  </script>
</div>