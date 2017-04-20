<?php
namespace App\Http\Controllers\Front;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use Input;
use Validator;
use DB;
use Hash;
use App\User;
use App\Games;
use App\Licence;
use App\Static_pages;
use App\Users_info;
use App\Users_game_info;
use Redirect;
use App\Game_purchase_order;

class HomeController extends Controller
{
    public function index()
    {
        $userData = Auth::user();
        $userData = json_decode($userData,true);
        $breadcrumb = array('Dashboard');
        $page_title = 'Dashboard';
        /*echo "string";
        die();*/
        if(Auth::user()->user_type == 1){
            return redirect('front/game-activity');
        }
        $user_childs = User::select('user_id')->where('user_parrent_id',Auth::user()->user_id)->get();
        $user_childs_array = array();
        foreach ($user_childs as $key => $value) {
            $user_childs_array[$key] = $value->user_id;
        }
        $Licenceinfo = DB::table('users as u')
        ->leftJoin('users_game_infos as gi', 'gi.user_id', '=', 'u.user_id')
        ->leftJoin('licences as li', 'li.licence_id', '=', 'gi.game_licence')
        ->leftJoin('games as g', 'g.game_id', '=', 'gi.game_id')
        ->select('li.licence_type','gi.*',"g.game_title","u.user_username","li.licence_period","u.user_id")
        ->whereIn('u.user_id', $user_childs_array)
        ->paginate(10);
		//print_r($Licenceinfo);exit;

        $data = array('main_content'=>"dashboard",'userData'=>$userData,'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'licenceinfo'=>$Licenceinfo);
        return view('front.includes.template',compact('data'));
    }

    public function profile(){

    	$user_id = Auth::user()->user_id;
    	$userData =  User::with('users_infos')->where('user_id',$user_id)->first();
    	$postData = Input::get();
    	if(!empty($postData)){
    		//prd($postData);
            if(!empty($userData['user_parrent_id']) && $userData['user_parrent_id'] != 1 ){
                $setVlaid = array('country_id'=>'required');
            }else{
                 $setVlaid = array('first_name'=>'required','country_id'=>'required');
            }  

            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }
            unset($postData['_token']);
            //prd($postData);
            Users_info::where('user_id',Auth::user()->user_id)->update($postData);
            Session::flash('success', ' Profile was successfully updated.');
              return redirect('front/profile');
    	}


    	$breadcrumb = array('profile');
        $page_title = 'profile';

        $data = array('main_content'=>"profile",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'userData'=>$userData);
        //return $data;
        return view('front.includes.template',compact('data'));	
    }

    public function gameactivity(){
        //gameactivity
        $breadcrumb = array('game-activity');
        $page_title = 'game-activity';
        if(Auth::user()->user_type == 1 || Auth::user()->is_supertrial == 1 )
        {
            $Licenceinfo = DB::table('users as u')
            ->leftJoin('users_game_infos as gi', 'gi.user_id', '=', 'u.user_id')
            ->leftJoin('licences as li', 'li.licence_id', '=', 'gi.game_licence')
            ->leftJoin('games as g', 'g.game_id', '=', 'gi.game_id')
            ->select('li.licence_type','gi.*',"g.game_title","u.user_username","li.licence_period","u.user_id","g.game_url as game_link",'u.user_last_login')
            ->where('u.user_id',Auth::user()->user_id)
            ->where('gi.licence_is_deleted',0)
            ->paginate(10);
            //prd($Licenceinfo);

        }else{
            $user_childs = User::select('user_id')->where('user_parrent_id',Auth::user()->user_id)->get();
            $user_childs_array = array();
            foreach ($user_childs as $key => $value) {
                $user_childs_array[$key] = $value->user_id;
            }
            $Licenceinfo = DB::table('users as u')
            ->leftJoin('users_game_infos as gi', 'gi.user_id', '=', 'u.user_id')
            ->leftJoin('licences as li', 'li.licence_id', '=', 'gi.game_licence')
            ->leftJoin('games as g', 'g.game_id', '=', 'gi.game_id')
            ->select('li.licence_type','gi.*',"g.game_title","u.user_username","li.licence_period","u.user_id","g.game_url as game_link",'u.user_last_login')
            ->whereIn('u.user_id', $user_childs_array)
            ->paginate(10);
        }            

        $data = array('main_content'=>"gameactivity",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'licenceinfo'=>$Licenceinfo);
        return view('front.includes.template',compact('data')); 
    }

    public function resetpassword(){
        $postData = Input::get();
        if(!empty($postData)){
            $setVlaid = array('password' => 'required|min:3|confirmed');
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }
            $saveArray = array('password'=>Hash::make($postData['password']));
            User::where('user_id',Auth::user()->user_id)->update($saveArray);
            Session::flash('success', 'Password updated successfully.');
              return redirect('front/reset-password');
        }
        //reset-password
        $breadcrumb = array('Reset Password');
        $page_title = 'Reset Password';
        $data = array('main_content'=>"resetpassword",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title);
        return view('front.includes.template',compact('data')); 
    }

     public function change_password($id){
        $postData = Input::get();
        if(!empty($postData)){
            $setVlaid = array('password' => 'required|min:3|confirmed');
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }
            $saveArray = array('password'=>Hash::make($postData['password']));
            User::where('user_id',$id)->update($saveArray);
            Session::flash('success', 'Password updated successfully.');
              return redirect('front/home');
        }
        $userData = User::where('user_id',$id)->first();
        //reset-password
        $breadcrumb = array('User Reset Password');
        $page_title = 'User Reset Password';
        $data = array('main_content'=>"userresetpassword",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'userData'=>$userData);
        return view('front.includes.template',compact('data')); 
    }

    public function game($url){
        $url = "game/".$url;
        $urls = explode("_", $url);
        //prd($urls);
        error_reporting(0);
        if($urls['1'] != 3 && !empty($urls)){
            $gameinfo = Games::where('game_url',$url)->first();
            if(empty($gameinfo)){
                return redirect('front/game-activity');
            }
        } else{
            $gameinfo['game_id'] = 3;
        }   

        if($gameinfo['game_id'] != 3)
        {
            $licencesInfo = Users_game_info::where('user_id',Auth::user()->user_id)
            ->where('game_id',$gameinfo['game_id'])
            ->where('game_is_expire',1)
            ->where('licence_is_deleted','!=',1)
            ->first();
        }else{
            $licencesInfo = Users_game_info::where('user_id',Auth::user()->user_id)
            ->where('game_licence',5)
            ->where('game_is_expire',1)
            ->where('licence_is_deleted','!=',1)
            ->first();

        }    

        $gameinfo1 = Games::where('game_url',$urls[0])->first();
        if(empty($gameinfo)){
            Session::flash('error_1', '1');
            return redirect('front/game-activity');
        }

        //prd($licencesInfo);
        if(empty($licencesInfo)){
        	$user_type = Auth::user()->user_type;
        	if($user_type == 2){
        		$getAllChidsId = User::select('user_id')->where('user_parrent_id',Auth::user()->user_id)->get();
        		//prd($getAllChidsId);
        		$idarray = '';
        		$idarray .= '';
        		foreach ($getAllChidsId as $key => $value) {
        			$idarray .= $value->user_id.',';
        		}
        		$idarray = rtrim($idarray,",");
        		$idarray .= '';
        		$idarray = explode(",", $idarray);//($idarray,",");
        		/*prd($idarray);
        		die();*/


        		$ChildlicencesInfo = Users_game_info::whereIn('user_id', $idarray)
	            ->where('game_id',$gameinfo['game_id'])
	            ->where('game_is_expire',1)
	            ->first();
	            
	            if(empty($ChildlicencesInfo)){
                    Session::flash('error_1', '1');
					return redirect('front/game-activity');	            	
	            }

        	}else{
                Session::flash('error_1', '1');
            	return redirect('front/game-activity');   
            }
        }
        
        
        $breadcrumb = array('Play Game');
        $page_title = 'Play Game';
        $page = "game".$gameinfo1['game_id'];
        /*echo $page;
        die();*/
        //nedd to remove 
        if($page == 'game4'){
            $page = 'demogame';
        }
        if($page != 'demogame' && $page != 'game1' && $page != 'game2'){
        	$page = 'game1';
        }

        return view("front.game.htmlQuiz.$page",compact('data'));
        
        //$data = array('main_content'=>"game.game",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title);
        //return view('front.includes.template',compact('data')); 
    }

    public function buy_games(){
        //echo Auth::user()->user_id;
        $user = User::with('users_infos')->where('user_id','=',Auth::user()->user_id)->first();
        //prd($user);

        
        $postData = Input::get();
        if(!empty($postData))
        {
            if(empty($postData['licenceType'])){
                $setVlaid = array("purchase_licence"=>'required');
            
                $validator = Validator::make($postData,$setVlaid);
                if ($validator->fails())
                {
                    return redirect()->back()->withErrors($validator->errors());
                }

            }

            
           // prd($postData);
            //$paypal_email = 'sujen@gmail.com';
             $paypal_email = 'sujendra.kumar@dotsquares.com';
           // $paypal_email = 'praveen.puri-ds-business@dotsquares.com';
            $return_url = 'http://181.224.157.105/~hirepeop/host1/codebackup/payment-successful';
            $cancel_url = 'http://181.224.157.105/~hirepeop/host1/codebackup/payment-cancelled';
            $notify_url = 'http://181.224.157.105/~hirepeop/host1/codebackup/notify';
            //pr($postData);
            
            $txn_id = $this->generateRandomString(10);
            $txn_type = $this->generateRandomString(10);
            if (!isset($postData["txn_id"]) && !isset($postData["txn_type"])){
                //prd($postData);
                $querystring = '';
                // Firstly Append paypal account to querystring
                $querystring .= "?business=".urlencode($paypal_email)."&";
                $licenceType = $postData['licenceType'];

                foreach ($licenceType as $key => $value) {
                    $order_uniq_id = $this->generateRandomString(6);
                    $ka  = $key+1;
                    $licence_info = Licence::where('licence_id',$value)->first();
                    $item_amount = $licence_info['licence_price']; //* $postData['numberoflicence'][$value];
                    $Game_purchase_order = new Game_purchase_order;
                    $Game_purchase_order->user_id = $user['user_id'];
                    $Game_purchase_order->licence_id = $value;
                    $Game_purchase_order->licence_user = $postData['numberoflicence'][$value];
                    $Game_purchase_order->txn_id = $txn_id;
                    $Game_purchase_order->order_type = 1;
                    $Game_purchase_order->order_payment = $item_amount * $postData['numberoflicence'][$value];
                    // $Game_purchase_order->order_payment = '0.3';
                    $Game_purchase_order->save();

                    $querystring .= "item_name_$ka=".urlencode($licence_info['licence_type'])."&";
                    $querystring .= "amount_$ka=".urlencode($item_amount)."&";
                    $querystring .= "quantity_$ka=".urlencode($postData['numberoflicence'][$value])."&";
                    $querystring .= "item_number_$ka=".urlencode($order_uniq_id)."&";
                    
                }
                

              
                //$querystring .= "amount=".urlencode('0.3')."&";
                $querystring .= "to=".urlencode($user['users_infos']['first_name'])."&";
                $querystring .= "first_name=".urlencode($user['users_infos']['first_name'])."&";
                $querystring .= "last_name=".urlencode($user['users_infos']['last_name'])."&";
                $querystring .= "payer_email=".urlencode($user['email'])."&";
                
                $querystring .= "txn_id=".urlencode($txn_id)."&";
               // $querystring .= "verify_sign=".urlencode($txn_type)."&";
                    
                //
                //loop for posted values and append to querystring
                unset($postData['numberoflicence']);
                unset($postData['licenceType']);
                foreach($postData as $key => $value){
                    $value = urlencode(stripslashes($value));
                    $querystring .= "$key=$value&";
                }
                
                // Append paypal return addresses
                $querystring .= "return=".urlencode(stripslashes($return_url))."&";
                $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
                $querystring .= "notify_url=".urlencode($notify_url);
                
                // Append querystring with custom field
                $querystring .= "&custom=".$txn_id;
                /*echo $querystring;
                die();*/
                // Redirect to paypal IPN
                //header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
                header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
                exit();
            }
        }
        $allgamess = Games::where('game_is_active',1)->where('game_is_deleted',0)->get();
        $allLicence = Licence::where('licence_is_active',1)->where('licence_id','!=',1)->where('licence_id','!=',2)->where('licence_is_deleted',0)->get();
        $data = array('allgamess'=>$allgamess,'allLicence'=>$allLicence,'user'=>$user,'main_content'=>'purchasebyaccount');
        return view('front.includes.template',compact('data'));
    }

    public function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

