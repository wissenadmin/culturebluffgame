<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Games;
use App\User;
use App\Licence;
use App\Static_pages;
use App\Users_info;
use DB;
use Input;
use Validator;
use Session;
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
        /*$users = 1;*/
        $userData =  User::with('users_infos')->where('role_id',2)->where('user_parrent_id',Auth::user()->user_id)->where('user_is_deleted',0)->get();
        //prd($userData);
        /*if(empty($userData[0])){
            $users  = 0;
        }*/
        $breadcrumb = array('Users');
        $page_title = 'Users';
        $data = array('main_content'=>"users/index",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'userData'=>$userData);
        return view('front.includes.template',compact('data'));
    }
	
    public function jignesh()
    {
        //
		echo 111111;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        /*echo  bcrypt('ADKHLG00');
        die();*/

        $postData = Input::get();
        if(!empty($postData)){
            $setVlaid = array(
                "user_username"=>'required|unique:users,user_username',
                "email"=>'required|unique:users,email',
                'password' => 'required|min:3|confirmed',
                
                'first_name'=>'required',
                'company_name'=>'required',
                'sector'=>'required',
                'country_id'=>'required',
                );
            
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }
            $user = new User;
            $user->user_username = $postData['user_username'];
            $user->email = $postData['email'];
           // $user->user_is_active = $postData['user_is_active'];
            $user->password = Hash::make($postData['password']);
            $user->user_parrent_id = Auth::user()->id;
            $user->save();
            $user_id = DB::getPdo()->lastInsertId();
            
            if(!empty($user_id)){
                $user_info = new Users_info;
                $user_info->user_id=$user_id;
                $user_info->first_name=$postData['first_name'];
                $user_info->last_name=$postData['last_name'];
                $user_info->middle_name=$postData['middle_name'];
                $user_info->company_name=$postData['company_name'];
                $user_info->designation=$postData['designation'];
                $user_info->sector=$postData['sector'];
                $user_info->country_id=$postData['country_id'];
                $user_info->company_website=$postData['company_website'];
                $user_info->save();
                $info_id = $user_info->id;
                if(!empty($info_id)){
                    Session::flash('success', 'User Added successfully.');
                    return redirect('front/users');
                } 

            }

        }
        $oldData = array();
        $breadcrumb = array('Add User');
        $page_title = 'Add User';
        $data = array('main_content'=>"users/add",'breadcrumb'=>$breadcrumb,'oldData'=>$oldData,'page_title'=>$page_title);
        return view('front.includes.template',compact('data'));
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
        $userList = User::with('users_infos')->where('user_parrent_id',$id)->get();
        $breadcrumb = array(''.$userInfo[0]->user_username.'`s Users List');
        $page_title = ''.$userInfo[0]->user_username.'`s Users List';
        $data = array('main_content'=>"users/index",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'userData'=>$userList,'viewFlag'=>1);
        return view('front.includes.template',compact('data'));
        
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
            

            //prd($postData);
            if(empty($postData['password'])){
                $setVlaid = array("company_name"=>'required','first_name'=>'required','designation'=>'required','sector'=>'required','country_id'=>'required');
            }else{
                $setVlaid = array("company_name"=>'required','first_name'=>'required','designation'=>'required','sector'=>'required','country_id'=>'required','password' => 'required|min:3|confirmed');
            }
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }

            if(!empty($postData['password'])){
                $password = Hash::make($postData['password']);
                User::where('user_id',$id)->update(array('password'=>$password));
            }
            unset($postData['_token']);
            unset($postData['password']);
            unset($postData['password_confirmation']);
            //prd($postData);
            Users_info::where('user_id',$id)->update($postData);
            Session::flash('success', 'User updated successfully.');
            return redirect('front/users');   

        }
        $breadcrumb = array('Edit User');
        $page_title = 'Edit User';
        $data = array('main_content'=>"users/edit",'breadcrumb'=>$breadcrumb,'userData'=>$oldData,'page_title'=>$page_title);
        return view('front.includes.template',compact('data'));
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
        $id =  User::where('user_id',$id)->update($updateArray);
        if($id){
            return json_encode(array('1','newstatus'=>$newStatus));
        }
    }
}
