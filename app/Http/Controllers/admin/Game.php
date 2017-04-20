<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Games;
use App\User;
use App\Licence;
use App\Static_pages;
use App\Country;
use DB;
use Input;
use Validator;
use Session;

class Game extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $breadcrumb = array('Games');
        $page_title = 'Games';
        $gameData   = DB::table('games as g')
        ->leftJoin('countries as c','g.country_id',"=","c.country_id")
		//->where('is_supertrial','=',0)->where('is_trial','=',0)
		->paginate(10);
        //->paginate(10);
        //Games::where('is_supertrial','=',0)->where('is_trial','=',0)->paginate(10);
      
        $data = array('main_content'=>"game/index",'breadcrumb'=>$breadcrumb,'gameData'=>$gameData,'page_title'=>$page_title);
        return view('admin.includes.template',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $postData = Input::get();
        if(!empty($postData)){
            $postData['game_title'] = str_replace(" ", "", $postData['game_title']);
            $setVlaid = array("game_title"=>'required|unique:games,game_title','game_description'=>'required','game_is_active'=>'required');
            
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }
            if(!empty($postData['is_supertrial']))
            {
                $is_supertrial = 1;
            }else{
                $is_supertrial = 0;
            }

            if(!empty($postData['is_trial']))
            {
                $is_trial = 1;
            }else{
                $is_trial = 0;
            }

            $postData['game_url'] = "game/".str_replace(" ", "", $postData['game_title']); 
            $games =  new Games;
            $games->game_title = $postData['game_title'];
            $games->game_description = $postData['game_description'];
            $games->game_url = $postData['game_url'];
            $games->game_is_active = $postData['game_is_active'];
            $games->country_id = $postData['country_id'];
            $games->is_supertrial = $is_supertrial;
            $games->is_trial = $is_trial;
            $games->save();
            $game_id = $games->id;
            if(!empty($game_id)){
                Session::flash('success_add', 'game added successfully.');
                return redirect('admin/games');
            }    
        }

        $oldData = array();
        $breadcrumb = array('Add Game');
        $page_title = 'Add Game';
        $countryList = Country::all();
        $data = array('main_content'=>"game/add",'breadcrumb'=>$breadcrumb,'oldData'=>$oldData,'page_title'=>$page_title,'countryList'=>$countryList);
        return view('admin.includes.template',compact('data'));
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $postData = Input::get();
        if(!empty($postData)){
            $postData['game_title'] = str_replace(" ", "", $postData['game_title']);
            $setVlaid = array("game_title"=>'required|unique:games,game_title,'.$id.',game_id','game_description'=>'required','game_is_active'=>'required');
            
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }

            if(!empty($postData['is_supertrial']))
            {
                $is_supertrial = 1;
            }else{
                $is_supertrial = 0;
            }

            if(!empty($postData['is_trial']))
            {
                $is_trial = 1;
            }else{
                $is_trial = 0;
            }

            $postData['game_url'] = "game/".str_replace(" ", "", $postData['game_title']);
            Games::where('game_id', '=', $id)->update(array('game_title'=>$postData['game_title'],'game_description'=>$postData['game_description'],'game_url'=>$postData['game_url'],'game_is_active'=>$postData['game_is_active'],'country_id'=>$postData['country_id'],'is_supertrial'=>$is_supertrial,'is_trial'=>$is_trial));

            Session::flash('success_update', 'game updated successfully.');
            return redirect('admin/games');
        }

        $oldData = Games::where('game_id',$id)->first();
        $breadcrumb = array('Edit Game');
        $page_title = 'Edit Game';
        
        $countryList = Country::all();
        $data = array('main_content'=>"game/add",'breadcrumb'=>$breadcrumb,'oldData'=>$oldData,'page_title'=>$page_title,'countryList'=>$countryList);
        return view('admin.includes.template',compact('data'));

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
        $updateArray = array('game_is_deleted'=>1);
        $id =  Games::where('game_id',$id)->update($updateArray);
        if($id){
            return json_encode(array('1'));
        }

    }

    public function checktrial(){
        $postData = Input::get();
        //prd($postData);
        $editFlag = $postData['editFlag'];
        if(!empty($postData['supertrial'])){
            if(!empty($editFlag)){
                $checkFlag =  Games::where('is_supertrial',1)->where('game_id','!=',$editFlag)->first();
            }else{
                $checkFlag =  Games::where('is_supertrial',1)->first();
            }
            if(!empty($checkFlag))
           {
             $return = 0;
           }else{
            $return = 1;
           }
           $avilable = array('avilable'=>$return);
           return $avilable;
        }
        if(!empty($postData['trial'])){
           //$checkFlag =  Games::where('is_trial',1)->first();
           if(!empty($editFlag)){
                $checkFlag =  Games::where('is_trial',1)->where('game_id','!=',$editFlag)->first();
            }else{
                $checkFlag =  Games::where('is_trial',1)->first();
            }
            //    prd($checkFlag);
           if(!empty($checkFlag))
           {
             $return = 0;
           }else{
            $return = 1;
           }
           $avilable = array('avilable'=>$return);
           return $avilable;
        }
    }


    public function status($id){
        $last_value = Games::where('game_id',$id)->first();
        if($last_value['game_is_active'] == 1){
            $newStatus = 0;
        }else{
            $newStatus = 1;
        }
        $updateArray = array('game_is_active'=>$newStatus);
        $id =  Games::where('game_id',$id)->update($updateArray);
        if($id){
            return json_encode(array('1','newstatus'=>$newStatus));
        }
    }
}
