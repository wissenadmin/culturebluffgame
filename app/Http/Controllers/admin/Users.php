<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Games;
use App\User;
use App\Licence;
use App\Static_pages;
use App\Users_info;
use App\Users_game_info;
use DB;
use Input;
use Validator;
use Session;
use App\Country;
use Hash;
use Auth;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userData = DB::table('users as u')
            ->leftJoin('users_game_infos as gi', 'gi.user_id', '=', 'u.user_id')
            ->leftJoin('users_infos as ui', 'ui.user_id', '=', 'u.user_id')
            ->leftJoin('licences as li', 'li.licence_id', '=', 'gi.game_licence')
            ->leftJoin('games as g', 'g.game_id', '=', 'gi.game_id')
            ->select(DB::raw("(GROUP_CONCAT(brg_li.licence_type)) as licence_type"),'gi.*',DB::raw("(GROUP_CONCAT(brg_g.game_title)) as game_title"),"u.user_username","li.licence_period","u.user_id","g.game_url as game_link","u.user_type","u.user_parrent_id","ui.*","u.*")
            ->where('role_id',2)
            ->where('user_parrent_id','=',0)
            ->orWhere('u.Is_supertrial','=',1)
            // ->orWhere('name', 'John')
            ->where('user_is_deleted',0)
            ->groupby('u.user_id')
            ->paginate(10);
           // prd($userData);
            $is_count = 0;
            foreach ($userData as $key => $value) {
                $value->is_count = $is_count;
                if($value->user_type == 2 && empty($value->licence_type) ){
                    $childInfo  = array();
                    $childInfo = DB::table('users as u')
                                    ->leftJoin('users_game_infos as gi', 'gi.user_id', '=', 'u.user_id')
                                    ->leftJoin('licences as li', 'li.licence_id', '=', 'gi.game_licence')
                                    ->leftJoin('games as g', 'g.game_id', '=', 'gi.game_id')
                                    ->select(DB::raw("(GROUP_CONCAT(brg_li.licence_type)) as licence_type"),'gi.*',DB::raw("(GROUP_CONCAT(brg_g.game_title)) as game_title"),"li.licence_period","g.game_url as game_link")
                                    //DB::raw("(GROUP_CONCAT(brg_li.licence_type)) as licence_type")
                                    ->where('u.user_parrent_id','=',$value->user_id)
                                    ->where('u.user_id','!=','1')
                                    ->where('u.is_confirmed','=','1')

                                    //->where('gi.user_id','!=','')
                                    //->Orwhere('u.user_parrent_id','!=','1')
                                    ->groupby('u.user_id')
                                    ->first();

                    $is_count  = DB::table('users as u')
                                    ->leftJoin('users_game_infos as gi', 'gi.user_id', '=', 'u.user_id')
                                    ->leftJoin('licences as li', 'li.licence_id', '=', 'gi.game_licence')
                                    ->leftJoin('games as g', 'g.game_id', '=', 'gi.game_id')
                                    ->select(DB::raw("(GROUP_CONCAT(brg_li.licence_type)) as licence_type"),'gi.*',DB::raw("(GROUP_CONCAT(brg_g.game_title)) as game_title"),"li.licence_period","g.game_url as game_link")
                                    //DB::raw("(GROUP_CONCAT(brg_li.licence_type)) as licence_type")
                                    ->where('u.user_parrent_id','=',$value->user_id)
                                    ->where('u.user_id','!=','1')
                                    ->where('u.is_confirmed','=','1')

                                    //->where('gi.user_id','!=','')
                                    //->Orwhere('u.user_parrent_id','=','1')
                                   // ->groupby('u.user_id')
                                    ->count();                

                    //unset($childInfo['user_id']);  
                                    //prd($childInfo);
                    if(!empty($childInfo)){
                        unset($childInfo->user_id);
                        $childInfo = json_decode(json_encode($childInfo),true);
                        $value = json_decode(json_encode($value),true);              
                        $value = array_merge($value, $childInfo);
                        $value['is_count'] = $is_count;
                        $value = (object) $value;
                    }

                    
                }

               // $ldata[$key] = $value;
                $userData[$key] = $value;
            }

        $breadcrumb = array('Users');
        $page_title = 'Users';
        $data = array('main_content'=>"users/index",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'userData'=>$userData,'is_child'=>1);
        $data['is_user'] = 1;
        return view('admin.includes.template',compact('data'));
    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function superTrial()
    {
        
        $userData =  User::with('users_infos')->where('role_id',2)->where('is_supertrial',1)->where('user_is_deleted',0)->paginate(10);
        $breadcrumb = array('Super Trial');
        $page_title = 'Super Trial';
        
        $data = array('main_content'=>"users/supertrial",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'userData'=>$userData);
        $data['is_user'] = 0;
        return view('admin.includes.template',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSuperTrial()
    {
        $postData = Input::get();
        if(!empty($postData)){
            $setVlaid = array(
                "user_username"=>'required|unique:users,user_username',
                "email"=>'required|unique:users,email',
                'password' => 'required|min:3|confirmed',
                'first_name'=>'required',
                'last_name'=>'required',
                'country_id'=>'required',
                'user_is_active'=>'required',
                'user_type'=>'required',
                /*'licence_valid_till'=>'required',*/
                'updated_at'=>date("Y-m-d H:i:s")
                );
            
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {   
                
                return redirect()->back()->withErrors($validator->errors());
            }
            
            $user = new User;
            $user->user_username = $postData['user_username'];
            $user->email = $postData['email'];
            $user->user_is_active = $postData['user_is_active'];
            $user->password = Hash::make($postData['password']);
            $user->user_parrent_id = Auth::user()->user_id;
            $user->user_parrent_id = Auth::user()->user_id;
            $user->is_supertrial = 1;
            $user->user_type = $postData['user_type'];
            $user->is_confirmed = 1;
            $user->remember_token = Hash::make($postData['password']);
            $user->save();
            $user_id = DB::getPdo()->lastInsertId();
            
            if(!empty($user_id)){
                $user_info = new Users_info;
                $user_info->user_id=$user_id;
                $user_info->first_name=$postData['first_name'];
                $user_info->last_name=$postData['last_name'];
                $user_info->company_name=$postData['company_name'];
                $user_info->designation=$postData['designation'];
                $user_info->sector=$postData['sector'];
                $user_info->country_id=$postData['country_id'];
                $user_info->company_website=$postData['company_website'];
                $user_info->save();
                $info_id = DB::getPdo()->lastInsertId();
                $game_licence = Games::where('is_supertrial',1)->first();
                if(!empty($info_id)){
                    $users_game_info = new  Users_game_info;
                    $users_game_info->game_id = $game_licence['game_id'];;
                    $users_game_info->user_id = $user_id;
                    $users_game_info->game_licence = 1;
                    /*$users_game_info->licence_valid_till = $postData['licence_valid_till'];*/
                    $users_game_info->save();
                    $game_id = DB::getPdo()->lastInsertId();
                    if(!empty($game_id)){
                        Session::flash('success_add', 'User Added successfully.');
                        return redirect('admin/super-trial');
                    }
                } 

            }

        }
        $oldData = array();
        $breadcrumb = array('Create Super Trial');
        $page_title = 'Create Super Trial';
        $countryList = Country::all();
        $data = array('main_content'=>"users/adduser",'breadcrumb'=>$breadcrumb,'oldData'=>$oldData,'page_title'=>$page_title,'countryList'=>$countryList);
        return view('admin.includes.template',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $userInfo = User::with('users_infos')->where('user_id',$id)->get();
        //prd($userInfo);
        if($userInfo[0]->user_type == 2)
        {
            $userList = DB::table('users as u')
                ->leftJoin('users_game_infos as gi', 'gi.user_id', '=', 'u.user_id')
                ->leftJoin('users_infos as ui', 'ui.user_id', '=', 'u.user_id')
                ->leftJoin('licences as li', 'li.licence_id', '=', 'gi.game_licence')
                ->leftJoin('games as g', 'g.game_id', '=', 'gi.game_id')
                ->select('li.licence_type','gi.*',"g.game_title",'gi.updated_at as game_created_at',"u.user_username","li.licence_period","u.user_id","g.game_url as game_link","u.user_type","u.user_parrent_id","ui.*","u.*")
                ->where('user_parrent_id',$id)
                ->paginate(10);
            
            $breadcrumb = array(''.$userInfo[0]->user_username.'`s Users List');
            $page_title = ''.$userInfo[0]->user_username.'`s Users List';

            $data = array('main_content'=>"users/index",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'userData'=>$userList,'viewFlag'=>1,'is_child'=>0);
            $data['is_user'] = 1;
        }else{
            
                $userList = DB::table('users_game_infos as gi')
                ->leftJoin('users as u', 'gi.user_id', '=', 'u.user_id')
                ->leftJoin('users_infos as ui', 'ui.user_id', '=', 'u.user_id')
                ->leftJoin('licences as li', 'li.licence_id', '=', 'gi.game_licence')
                ->leftJoin('games as g', 'g.game_id', '=', 'gi.game_id')
                 ->select('li.licence_type','gi.*','gi.updated_at as game_created_at',"g.game_title","u.user_username","li.licence_period","u.user_id","g.game_url as game_link","u.user_type","u.user_parrent_id","ui.*","u.*")
                ->where('u.user_id',$id)
                ->paginate();

            $breadcrumb = array(''.$userInfo[0]->user_username.'`s Users List');
            $page_title = ''.$userInfo[0]->user_username.'`s Users List';

            $data = array('main_content'=>"users/inner_index",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'userData'=>$userList,'viewFlag'=>1,'is_child'=>1);
            $data['is_user'] = 1;    
                
                //prd($userList);

        }
        return view('admin.includes.template',compact('data'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $oldData = User::with('users_infos')->where('user_id',$id)->first();
        $postData = Input::get();
        if(!empty($postData)){
         //   prd($postData);
            if(!empty($oldData['user_parrent_id']) && $oldData['user_parrent_id'] != 1 ){
                $setVlaid = array(
                "user_username"=>'required|unique:users,user_username,'.$id.',user_id',
                "email"=>'required|unique:users,email,'.$id.',user_id',
                //'first_name'=>'required',
                //'company_name'=>'required',
               // 'sector'=>'required',
                'country_id'=>'required',
                'user_is_active'=>'required');


            }else{
        	$setVlaid = array(
                "user_username"=>'required|unique:users,user_username,'.$id.',user_id',
                "email"=>'required|unique:users,email,'.$id.',user_id',
                'first_name'=>'required',
                //'company_name'=>'required',
               // 'sector'=>'required',
                'country_id'=>'required',
                'user_is_active'=>'required');
            }
        	if(!empty($postData['password'])){
        		$setVlaid['password'] =  'required|min:3|confirmed';
        	}
            
            
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }

            if(empty($postData['password'])){
        		User::where('user_id', '=', $id)->update(array('user_username'=>$postData['user_username'],'email'=>$postData['email'],'user_is_active'=>$postData['user_is_active']));
        	}else{
        		User::where('user_id', '=', $id)->update(array('user_username'=>$postData['user_username'],'email'=>$postData['email'],'user_is_active'=>$postData['user_is_active'],'password'=>Hash::make($postData['password'])));
        	}

            

            Users_info::where('user_id', '=', $id)->update(array(
                'first_name'=>$postData['first_name'],
                'last_name'=>$postData['last_name'],
                'middle_name'=>$postData['middle_name'],
                'company_name'=>$postData['company_name'],
                'designation'=>$postData['designation'],
                'sector'=>$postData['sector'],
                'country_id'=>$postData['country_id'],
                'company_website'=>$postData['company_website']));

            Session::flash('success_update', 'User updated successfully.');
            if(!empty($oldData['user_parrent_id']))
            {
                if($oldData['user_parrent_id'] == 1){
                    return redirect('admin/super-trial');
                }else{
                    return redirect('admin/users/view/'.$oldData['user_parrent_id'].'');
                }    
            }else{
                return redirect('admin/users');
            }    
        }

        if($oldData['user_parrent_id'] == 1){
            $breadcrumb = array('Edit SuperTrial User');
            $page_title = 'Edit SuperTrial User';
            $returnurl  = 'super-trial'  ;  
        }else{
            $breadcrumb = array('Edit User');
            $page_title = 'Edit User';    
            $returnurl  = 'users'  ;
        }
        
        
      $countryList = Country::all();
        $data = array('main_content'=>"users/edit",'breadcrumb'=>$breadcrumb,'oldData'=>$oldData,'page_title'=>$page_title,'returnurl'=>$returnurl,'countryList'=>$countryList);
        return view('admin.includes.template',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $updateArray = array('user_is_deleted'=>1);
        $id =  User::where('user_id',$id)->update($updateArray);
        if($id){
            return json_encode(array('1'));
        }

    }

    public function status($id)
    {
        $last_value = User::where('user_id',$id)->first();
        if($last_value['user_is_active'] == 1){
            $newStatus = 0;
        }else{
            $newStatus = 1;
        }
        $updateArray = array('user_is_active'=>$newStatus);
        $get_parrent_status = User::where('user_id',$last_value['user_parrent_id'])->first();
       // prd($get_parrent_status);
        if(!empty($get_parrent_status)){
            if($get_parrent_status['user_is_active'] != 0){

                $id1 =  User::where('user_id',$id)->update($updateArray);
                if($id1){
                    if($last_value['user_type'] == 2){


                      // $getAllUser = $
                        User::where('user_parrent_id','=',$id)->update($updateArray);

                    }
                    return json_encode(array('1','newstatus'=>$newStatus));
                }
            }else{
                return json_encode(array('1','newstatus'=>2));
            }
        }else{
            $id1 =  User::where('user_id',$id)->update($updateArray);
            User::where('user_parrent_id','=',$id)->update($updateArray);
            return json_encode(array('1','newstatus'=>$newStatus));
        }
    }
}
