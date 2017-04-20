<link rel="stylesheet" href="{{url('/resources/admin-html')}}/assets/css/sweetalert.css" />
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                User List
            </header>
            @if(!empty(Session::get('success')))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{Session::get('success')}}
                </div>
                @endif
            <?php error_reporting(0); ?>
            @if(empty($data['userData'][0]->user_id ))
                <h4 class="text-center" style="margin-top:20px;"> No user in userlist.</h4>
            @else
            <h4 style="margin-top:20px;margin-left:10px;"> <a href="{{url('front/users/add')}}"><button class="btn btn-info">Add User</button></a></h4>
                <table class="table table-striped table-advance table-hover">
                    <tbody>
                        <tr>
                            <th><i class="icon_profile"></i>SR Number</th>
                            <th><i class="icon_profile"></i> Full Name</th>
                            <th><i class="icon_mail_alt"></i> Email</th>
                            <th><i class="icon_profile"></i> Username</th>
                            <th><i class=""></i> Status</th>
                            <th><i class="icon_cogs"></i> Action</th>
                        </tr>
                        @foreach($data['userData'] as $key => $value)
                            <tr class="rowclass_{{$value->user_id}}">
                            <td>{{$key+1}}</td>
                            <td>{{$value['users_infos']->first_name}} {{$value['users_infos']->middle_name}}  {{$value['users_infos']->last_name}}</td>
                            <td>{{$value->email}}</td>
                            <td>{{$value->user_username}}</td>
                            @if($value->user_is_active == 1)
                                <td class="statusClass_{{$value->user_id}}">Active</td>
                            @else
                                <td class="statusClass_{{$value->user_id}}">Inactive</td>
                            @endif
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-success" href="#">
                                    @if($value->user_is_active)  
                                        <i class="ace-icon fa fa-check-square bigger-130 deactiveRecord" data-status="{{$value->user_is_active}}" data-id="{{$value->user_id}}" data-url="{{url('front/users/status',$value->user_id)}}"></i>
                                    @else
                                    
                                    <i class="ace-icon fa fa fa-ban bigger-130 deactiveRecord" data-id="{{$value->user_id}}" data-status="{{$value->user_is_active}}" data-url="{{url('front/users/status',$value->user_id)}}"></i>
                                    @endif
                                        

                                    </a>
                                    <a class="btn btn-primary" href="{{url('front/users/edit')}}/{{$value->user_id}}"><i class="fa fa-edit"></i></a>

                                    <a class="btn btn-danger" ><i class="ace-icon fa fa-trash-o bigger-130 delete" data-id="{{$value->user_id}}" data-url="{{url('front/users/delete',$value->user_id)}}"></i></a>
                                </div>
                            </td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>
            @endif
        </section>
    </div>
</div>
<script src="{{url('/resources/admin-html')}}/assets/js/sweetalert.min.js"></script>

<script type="text/javascript">
jQuery(function($) {
  //initiate dataTables plugin
  //var oTable =   $('#dynamic-table').dataTable();
    $(".delete").click(function(){
        var url = $(this).attr("data-url");

        row_id  = $(this).attr("data-id");
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this User!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel plz!",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm) {
                /*alert(url);
                return false;*/
                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'json',
                    success: function(data){
                        swal("Deleted", "Selected data has been deleted.", "success");
                        bResetDisplay = false;
                        //oTable.fnDraw();
                        bResetDisplay = true;
                        $(".rowclass_"+row_id).remove();
                    },
                    error: function(){
                        swal("warning", "dont have permision to actived User.", "error");
                    }
                });
          } else {
                swal("Cancelled", "Your User is safe :)", "error");
          }
        });
    });

    $(".deactiveRecord").click(function(){
        var url = $(this).attr("data-url");    
        var status = jQuery(this).attr('status');
        var button=jQuery(this);
        var id = $(this).attr("data-id");
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success: function(data){
               if(data.newstatus == 1){
                    button.removeClass('fa fa-ban').addClass('fa fa-check-square');
                    button.attr('title','Inactive');
                    /*$(".statusClass_"+id).removeClass('label label-sm label-inverse').addClass('label label-sm label-info');*/
                    $(".statusClass_"+id).html('Active');
                    swal("Good job", "User activated successfully!", "success");
                }else{
                    button.removeClass('fa fa-check-square').addClass('fa fa-ban');
                    button.attr('title','Active');
                    /*$(".statusClass_"+id).removeClass('label label-sm label-info').addClass('label label-sm label-inverse');*/
                    $(".statusClass_"+id).html('Inctive');
                    swal("Good job", "User deactivated successfully!", "success");
                }
            },
            error: function(){
                swal("warning", "dont have permision to change Status of User.", "error");
            }
        });
    });



});
</script>