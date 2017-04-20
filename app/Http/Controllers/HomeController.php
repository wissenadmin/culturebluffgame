<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use Input;
use Validator;
use App\Games;
use App\User;
use App\Licence;
use App\Inquiry_list;
use App\Users_info;
use App\Users_game_info;
use DB;
use Hash;
use Redirect;
use App\ClientAuth;
use Mail;
use App\Game_purchase_order;
use App\Test;
use PDF;
class HomeController extends Controller
{
    /*
    
    |--------------------------------------------------------------------------
    
    | Home Controller
    
    |--------------------------------------------------------------------------
    
    |
    
    | This controller renders your application's "dashboard" for users that
    
    | are authenticated. Of course, you are free to change or remove the
    
    | controller as you wish. It is just here to get your app started!
    
    |
    
    */
    /**
    
    * Show the application dashboard to the user.
    
    *
    
    * @return Response
    
    */
    var $pdf = '';
    var $email = '';
    public function index()
    {
       // return view('front.welcome');
    }

    public function resetpassword(){
        /*echo  bcrypt('abcd147852');
        die();*/
        return view('front.auth.resetpassword');
    }
    /**
    
    * Show the application dashboard to the user.
    
    *
    
    * @return Response
    
    */
    public function login()
    {
        $userData = Auth::user();
        /*print_r($userData);
        die();*/
        if (!empty($userData)) {
            switch ($userData->type) {
                case 1:
                    return Redirect::to('admin');
                    break;
                default:
                    return Redirect::to('front/home');
                    break;
            }
        }
        return view('auth.login');
    }
    public function checklogin()
    {
        $postData = Input::get();
        if (!empty($postData)) {
            $rules     = array(
                'username' => 'required', // make sure the email is an actual email
                'password' => 'required|min:3' // password can only be alphanumeric and has to be greater than 3 characters
            );

           //
            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);
            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                return redirect()->back()->withErrors("Please check username and password.");
            } else {
                $userdata = array(
                    'user_username' => Input::get('username'),
                    'password' => Input::get('password')
                );
                if (Auth::attempt($userdata)) {
                    $userData = Auth::user();
                     //Session::put('current_user',Auth::user());
                       // print_r($userData);
                    //                    die();
                    if ($userData->user_is_active == 1) {
                        switch ($userData->user_type) {

                            case '1':
                                return redirect('admin');
                                break;
                            case '2':
                                return redirect('front/home');
                                break;
                        }
                        return redirect('front/home');
                    } else {
                        Auth::logout();
                        Session::flush();
                        return redirect()->back()->withErrors("Your account has been deactived. Please contact the system administrator to reactivate your account.");
                    }
                   
                } else {
                    return redirect()->back()->withErrors("Please check username and password.");
                }
            }
        }
    }

    public function checkfrontlogin(){
        $postData = Input::get();
        if (!empty($postData)) {
            $rules     = array(
                'username' => 'required', // make sure the email is an actual email
                'password' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
            );
                
             $validator = Validator::make(Input::all(), $rules);
            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                return redirect()->back()->withErrors("Please check username and password.");
            } else {
                $userdata = array(
                    'user_username' => Input::get('username'),
                    'password' =>Input::get('password')
                );
               // prd($userdata);
               // pr($userdata);
                if (Auth::attempt($userdata)) {
                    $userData = Auth::user();
                   //prd($userData); 
                    if ($userData->user_is_active == 1) {
                      if($userData->role_id == 2 ) {
                        
                            if($userData->is_confirmed == 1){
                                $login_count = $userData->user_login_count +1; 
                                User::where('user_id','=',$userData->user_id)
                                ->update(array('user_last_login'=>date('Y-m-d H:i:s'),'user_login_count'=>$login_count));
                               /* echo "string";
                                die();*/
                                if($userData->user_type == 2){

                                    return redirect('front/home');
                                }else{
                                    return redirect('front/game-activity');
                                }
                            
                            }else{
                                Auth::logout();
                                Session::flush();
                                return redirect()->back()->withErrors("Please confirm your account.");    
                            }
                        
                        }else{
                            Auth::logout();
                            Session::flush();
                            return redirect()->back()->withErrors("Please check username and password.");
                        }
                        
                    } else {
                        Auth::logout();
                        Session::flush();
                        return redirect()->back()->withErrors(" Your account has been deactived. Please contact Culture Buff Games at techsupport@culturebuffgames.com to reactivate your account.");
                    }
                   
                } else {
                    return redirect()->back()->withErrors("Please check username and password.");
                }
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('admin/login'); 
    }

    public function frontlogout(){
        Auth::logout();
        Session::flush();
        return redirect('login');    
    }
    
    

    public function frontlogin(){
        $userData = Auth::user();
        /*print_r($userData);
        die();*/
        if (!empty($userData)) {
            switch ($userData->type) {
                case 1:
                    return Redirect::to('admin');
                    break;
                default:
                    return Redirect::to('front/home');
                    break;
            }
        }
        return view('front.auth.login');
    }

    public function request_trial(){
        $postData = Input::get();
        if(!empty($postData)){

            $postData['user_username'] = $postData['email'];
            $setVlaid = array(
                "email"=>'required|email',
               // "user_username"=>'required|unique:users,user_username',
                'password' => 'required|min:3|confirmed',
                'first_name'=>'required',
                'last_name'=>'required',
                'country_id'=>'required',
                );
            /*$messages = array( 'email' => 'The email address entered has been taken. Please use a different email address to access the Trial version of the game.' );*/
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                $errors = $validator->errors();
                $errors =  json_decode($errors); 

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ]);
               // die();
            }else{
                $already = User::where('email','=',$postData['email'])->first();
                if(!empty($already)){
                    $errors = array('email'=>array('0'=>'The email address entered has been taken. Please use a different email address to access the Trial version of the game.'));
                    //$errors =  json_decode($errors); 
                    return response()->json([
                        'success' => false,
                        'message' => $errors
                    ]);
                }
            }


            $confirmed = $this->generateRandomString(15);
            $user = new User;
            $user->user_username = $postData['email'];
            $user->email = $postData['email'];
            $user->user_is_active = 0;
            $user->password = bcrypt($postData['password']);
            $user->user_parrent_id = 0;
            $user->org_password = $postData['password'];
            $user->confirmed = $confirmed;
            $user->remember_token = bcrypt($postData['password']);
            $user->save();
            $user_id = DB::getPdo()->lastInsertId();
                        
            $trial =  Games::where('is_trial',"=",1)->first();    
            if(!empty($trial)){
                $trial_id = $trial['game_id'];
            }else{
                $trial_id = 1;
            }

            if(!empty($user_id)){
                $user_info = new Users_info;
                $user_info->user_id=$user_id;
                $user_info->first_name=$postData['first_name'];
                $user_info->last_name=$postData['last_name'];
               // $user_info->company_name=$postData['company_name'];
             //   $user_info->designation=$postData['designation'];
              //  $user_info->sector=$postData['sector'];
                $user_info->country_id=$postData['country_id'];
            //    $user_info->company_website=$postData['company_website'];
                $user_info->save();
                $info_id = DB::getPdo()->lastInsertId();
                if(!empty($info_id)){
                    $Date = date('Y-m-d');
                    $date =  date('Y-m-d', strtotime($Date. ' + 5 days'));
                    $users_game_info = new  Users_game_info;
                    $users_game_info->game_id = $trial_id;
                    $users_game_info->user_id = $user_id;
                    $users_game_info->game_licence = 2;
                    $users_game_info->licence_valid_till = $date;
                    $users_game_info->purchase_type = 0;
                    $users_game_info->save();
                    $game_id = DB::getPdo()->lastInsertId();
                    if(!empty($game_id)){
                        $str = $postData['email'];
                        /*Mail::send('emails.verify', $confirmed = array('confirmation_code'=>$confirmed), function($message) use ($str) {
                             $message->to($str)
                                ->subject('Verify your email address');
                        });*/

                       // $userList = '';
                        $postData['link'] = $confirmed;
                        $postData['licence_valid_till'] = $date;
                        Mail::send('emails.trailverify', $confirmed = array('userData'=>$postData), function($message
                            ) use($str)  {
                            $message->to($str)
                                ->subject('Login information for Culture Buff Games Trial');
                        });


                        $return = array('status'=>1,'msg'=>'request trial started please check your email for login password.');
                        return $return;
                       // return redirect('admin/supertrial');
                    }
                } 

            }

        }
    }

    public function purchase_game(){
        $postData = Input::get();


        if(!empty($postData)){
            $postData['user_username'] = $postData['email'];
            if($postData['user_type'] == 1){
                $setVlaid = array(
                    "email"=>'required|email',
                    //"user_username"=>'required|unique:users,user_username',
                    'password' => 'required|min:3|confirmed',
                    'first_name'=>'required',
                    'last_name'=>'required',
                    'country_id'=>'required',
                    'user_type' => 'required'
                    );
            }else{
                $setVlaid = array(
                    "email"=>'required|email',
                    "company_name"=>'required',
                    'password' => 'required|min:3|confirmed',
                    'first_name'=>'required',
                    'last_name'=>'required',
                    'country_id'=>'required',
                    'user_type' => 'required'
                    );
            }
            
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                $errors = $validator->errors();
                $errors =  json_decode($errors); 

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ]);

            }else{
                $already = User::where('email','=',$postData['email'])->first();
                if(!empty($already)){
                    $errors = array('email'=>array('0'=>'The email address entered has been taken. Please use a different email address to purchase new game.'));
                    //$errors =  json_decode($errors); 
                    return response()->json([
                        'success' => false,
                        'message' => $errors
                    ]);
                }
            }

            $confirmed = $this->generateRandomString(15);

            $user = new User;
            $user->user_username = $postData['email'];
            $user->email = $postData['email'];
            $user->user_is_active = 0;
            $user->password = bcrypt($postData['password']);
            $user->user_parrent_id = 0;
            $user->user_type = $postData['user_type']; 
            $user->confirmed = $confirmed;
            $user->org_password = $postData['password'];
            $user->remember_token = bcrypt($postData['password']);
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
                if(!empty($info_id)){
                   /* $users_game_info = new  Users_game_info;
                    $users_game_info->game_id = 1;
                    $users_game_info->user_id = $user_id;
                    $users_game_info->game_licence = 2;
                    $users_game_info->save();
                    $game_id = DB::getPdo()->lastInsertId();
                    if(!empty($game_id)){*/
                        $str =  $postData['email'];
                        /*Mail::send('emails.purchase', $confirmed = array('confirmation_code'=>$confirmed), function($message) use ($str) {
                             $message->to($str)
                                ->subject('Purchase Game Link From Culture Buff Games');
                        });*/
                        $postData['confirmation_code'] = $confirmed;
                        Mail::send('emails.purchase', $data = array('data'=>$postData), function($message) use ($str) {
                             $message->to($str)
                                ->subject('Purchase Game Link From Culture Buff Games');
                        });


                        $return = array('status'=>1,'msg'=>'users register successfully pass to from 2.');
                        return $return;
                    /*}*/
                } 

            }

        }
    }

    public function get_one(){
        echo "asdsd";die;
    }

    public function checkMailTemplates(){
        
        /*$confirmed = $this->generateRandomString(15);
        $postData = array('first_name'=>'Manish','link'=>$confirmed,'email'=>'manish.s@dotsquares.com','password'=>'12345678','licence_valid_till'=>'30-oct-2016');
        $str =  "manish.s@dotsquares.com";
        Mail::send('emails.trailverify', $data = array('userData'=>$postData), function($message) use ($str) {
             $message->to($str)
                ->subject('Invoice For Purchase Of Culture Buff Games');
        });*/


        $str = 'archirayan46@gmail.com';
        $data = array();
        $data['purchase_date'] = '10-04-1994';
        $data['first_name'] = 'Manish';
        $data['last_name'] = 'Sharma';
        $data['company'] = 'Dotsquares';
        $data['email'] = 'archirayan46@gmail.com';
        $data['total_price'] = '70';
        $data['invoice_number'] = 'AKGHTKJL';

        $data['purchase_info'] = array('0'=>array('game_title'=>'test','licence_price'=>40,'currency'=>'GBP','numbers'=>'2','licence_valid_till'=>'10-04-2017','subtotal'=>80),'1'=>array('game_title'=>'test','licence_price'=>40,'currency'=>'GBP','numbers'=>'2','licence_valid_till'=>'10-04-2017','subtotal'=>80));
        $data['total_price'] = 80;
       //   prd($data); 
       //$return = array('data'=>$data);
        
        //return $pdf->stream();

        /*$mailarray = array('email'=>$str,'pdf'=>$pdf);
        
        $mailarray = json_encode($mailarray);
        
        $this->pdf = $pdf;
        $this->email = $str;
        $user = '';*/
        /*Mail::queue('emails.pdf.invoicetest', $data = array('data'=>$data), function($message)  {
            $message->to("manish.s@dotsquares.com")
                ->subject('Game purchase invoice.');
                $message->attachData($this->pdf, "invoice.pdf");
        });*/

        Mail::queue('emails.pdf.invoicetest', $data = array('data' => $data), function($message) use ($data)
        {

           //$pdf = PDF::loadView('layouts.factuur', array('factuur' => $factuur));
           $pdf = PDF::loadView('emails.pdf.invoicetest', array('data' => $data))->save( "downloads/one.pdf" );
           
       
           //return $pdf->stream();
           
           $message->to('archirayan15@gmail.com', 'Manish')
           ->subject('Onderwerp');
           $message->attachData($pdf->output(), "invoice.pdf");
        });


        echo "string";
        die();

        
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

    public function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
         //   throw new InvalidConfirmationCodeException;
            Session::flash('error', "no confirmation code.");
            return redirect('login');
        }
        $user = User::where('confirmed','=',$confirmation_code)->first();
        if (empty($user->confirmed))
        {
            Session::flash('error', "no confirmation code not matched.");
            return redirect('login');
        }
        $user->is_confirmed = 1;
        $user->user_is_active = 1;
        $user->confirmed = null;
        $user->save();
        Session::flash('success', "You have successfully verified your account.");
        return redirect('login');
    }


    public function purchase($confirmation_code){
        if( ! $confirmation_code)
        {
          //  Session::flash('error', "no confirmation code.");
            return redirect('');
        }
        $user = User::with('users_infos')->where('confirmed','=',$confirmation_code)->first();
        if (empty($user->confirmed))
        {
            return redirect('');
        }
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
          //  $paypal_email = 'praveen.puri-ds-business@dotsquares.com';
            $paypal_email = 'sujendra.kumar@dotsquares.com';
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
        $data = array('allgamess'=>$allgamess,'allLicence'=>$allLicence,'user'=>$user,'main_content'=>'purchase');
        return view('front.includes.template1',compact('data'));
    }

    public function notify(){
        $postDatasave = json_encode(Input::get());
        DB::table('tests')->insert(array('postdata'=>$postDatasave));

        //$postData1 = DB::table('tests')->get();
        $postData = Input::get();//json_decode($postData1[0]->postdata,true);
        
       // $postData = Input::get();
        if(empty($postData['custom'])){
            die();
        }
        $req = 'cmd=_notify-validate';
        foreach ($postData as $key => $value) {
            $value = urlencode(stripslashes($value));
            $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
            $req .= "&$key=$value";
        }

        /*$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";*/
        $header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Host: www.sandbox.paypal.com\r\n";  // www.paypal.com for a live site
        $header .= "Content-Length: " . strlen($req) . "\r\n";
        $header .= "Connection: close\r\n\r\n";

       

        
        $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
        
        if (!$fp) {
            // HTTP ERROR
            
        } else {

            fputs($fp, $header . $req);
            while (!feof($fp)) {
                $res = fgets ($fp, 1024);
                //echo $res;
                /*echo $res;
                print_r($res);*/
                //die();
                //if (strcmp($res, "VERIFIED") === 0) {
                if (strcmp (trim($res), "VERIFIED") !== 0) {
                   // echo "string";
                    //die();
                    
                    $txnid_history  =  Game_purchase_order::where('txn_id','=',$postData['custom'])->get();
                    //echo "string";
                    //prd($txnid_history);
                    if(!empty($txnid_history)){
                      $valid_txnid = true ; 
                    }

                    $postData['mc_gross_1'] = $postData['mc_gross_1'] + 0 ;
                    $valid_price_history  =  Game_purchase_order::where('order_payment','=',$postData['mc_gross_1'])->where('txn_id','=',$postData['custom'])->first();
                   /* pr($valid_price_history);
                    die();*/
                    if(!empty($valid_price_history)){
                        $valid_price = true;    
                    }

                     //= check_price($data['payment_amount'], $data['item_number']);
                    // PAYMENT VALIDATED & VERIFIED!
                    if ($valid_txnid && $valid_price) {
                        
                      //  $orderid = Game_purchase_order::where('txn_id','=',$postData['custom'])->update(array('order_status'=>1));
                       /* echo $orderid;
                        die();*/
                        $orderid = 1;
                        if ($orderid) {
                            $flag = $txnid_history[0]->order_type;
                            $this->orderSucess($postData,$flag);
                            //code for genrate user accounts.

                            // Payment has been made & successfully inserted into the Database
                        } else {
                            // Error inserting into DB
                            // E-mail admin or alert user
                            // mail('user@domain.com', 'PAYPAL POST - INSERT INTO DB WENT WRONG', print_r($data, true));
                        }
                    } else {
                        // Payment made but data has been changed
                        // E-mail admin or alert user
                    }
                
                }// else if (strcmp ($res, "INVALID") === 0) {
                    else if (strcmp (trim($res), "INVALID") !== 0) {
                    
                    
                    // PAYMENT INVALID & INVESTIGATE MANUALY!
                    // E-mail admin or alert user
                    
                    // Used for debugging
                    //@mail("user@domain.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");
                }
                
            }
        fclose ($fp);
        }



    }

   

    public function orderSucess($postData = array(),$flag=''){
        //$postData = Input::get();
        if(!empty($postData)){
            $item_number= $postData['custom'];
            $orderData = Game_purchase_order::where('txn_id',$item_number)->where('order_status',0)->get();
            if(empty($orderData)){
                die();
            }
            //prd($orderData);
            $user_id = $orderData[0]->user_id;
            $userInfo = User::where('user_id',$user_id)->first();
            User::where('user_id','=',$userInfo['user_id'])->update(array('user_is_active'=>1));
            $licence_names = '';
            $payment = 0;
            $orderSaveData = array();
            $user_total_array = array();
			
            if($userInfo['user_type'] == 1){
                // single user
                $saveGames =  array();
                $a = 0;
                $total_pirce = 0;
                $invoice_number = $this->generateRandomString(13);
                foreach ($orderData as $key => $value) {
                    $licenceData = Licence::where('licence_id',$value->licence_id)->first();
                    DB::table('invoices')->insert(array('invoice_number'=>$invoice_number,'order_id'=>$value->id));

                    $date = strtotime("+".$licenceData['licence_period']." day");
                    $date1 =  date('M d, Y', $date);
                    $game_id = $licenceData['game_id'];
                    $users_game_info = new Users_game_info;
                    $users_game_info->game_id = $game_id;
                    $users_game_info->user_id = $user_id;
                    $users_game_info->game_licence = $licenceData['licence_id'];
                    $users_game_info->licence_valid_till = $date1;
                    $users_game_info->purchase_type = 1;
                    $users_game_info->save();
                    //$licence_names .= $licenceData['licence_type'].",";
                    //$payment = $payment + $licenceData['order_payment'];
                    $info = array('game_licence'=>$licenceData['licence_type'],'licence_valid_till'=>$date1);
                    $saveGames[$key] = $info;

                    $user_total_array[$key][$a] = array('game_licence'=>$licenceData['licence_type'],'expired'=>$date1);
                    $total_pirce = $total_pirce + (int)$value->order_payment;

                    $orderSaveData[$key] = array('licence_type'=>$licenceData['licence_type'],'licence_price'=>$licenceData['licence_price'],'currency'=>'GBP','numbers'=>1,'licence_valid_till'=>$date1,'subtotal'=>$value->licence_user*$licenceData['licence_price']);

                    $a = $a+1;

                }
                $userdata = User::with('users_infos')->where('user_id',$user_id)->first();
                $str =  $userdata['email'];
                $userdata['games_info'] =  $saveGames;
                
                $userList = array();
                foreach ($user_total_array as $key => $value) {
                    foreach ($value as $k => $v) {
                        $userList[$key] = array('user_username'=>$userInfo['user_username'],'org_password'=>$userInfo['org_password'],'game_licence'=>$v['game_licence'],'expired'=>$v['expired']);
                    }
                }

                $invoiceData = array('invoice_number'=>$invoice_number,'purchase_date'=>date("d-M-Y"),'orderSaveData'=>$orderSaveData,'total_price'=>$total_pirce);
                $userdata['invoiceData'] = $invoiceData;
                //$userData[''] = $orderSaveData;

                $pdf = PDF::loadView('emails.pdf.invoice', array('data' => $userdata));
                $mailarray = array('email'=>$str,'pdf'=>$pdf);
                Mail::send('emails.invoice', $confirmed = array('data'=>$userdata), function($message) use ($mailarray) {
                    $email = $mailarray['email'];
                    $pdf   =  $mailarray['pdf'];
                    $message->to($email)
                        ->subject('Invoice For Purchase Of Culture Buff Games');
                        $message->attachData($pdf->output(), "invoice.pdf");
                        //$message->Output();
                });

                if($flag == 1){
                    $file = 'existing_individual_purchaser';
                }else{
                    $file = 'new_individual_purchaser';
                }

                $pdf = PDF::loadView("emails.$file", array('data' => $userdata));
                $mailarray = array('email'=>$str,'pdf'=>$pdf);
                Mail::send("emails.$file", $confirmed = array('data'=>$userdata), function($message) use ($mailarray) {
                    $email = $mailarray['email'];
                    $pdf   =  $mailarray['pdf'];
                     $message->to($email)->subject('Thanks for purchasing Culture Buff Games.');
                        //$message->attachData($pdf->output(), "info.pdf");
                });
            
                Game_purchase_order::where('txn_id',$item_number)->update(array('order_status'=>1));
                User::where('user_id',$user_id)->update(array('confirmed'=>'','is_confirmed'=>1,'user_is_active'=>1));
            }else{
                //carporte
                $this->genrate_user_accounts($user_id,$orderData,$flag);
            }

            $user_info = User::where('user_id','=',$user_id)->first();

            User::where('user_id','=',$user_id)->update(array('is_confirmed'=>1,'confirmed'=>'','user_is_active'=>1));
            //check is trial 
            $isTrail = Users_game_info::where('game_licence',2)->where('user_id',$user_id)->first();
            if($isTrail){
                Users_game_info::where('game_licence',2)->where('user_id',$user_id)->update(array('licence_is_deleted'=>1));
            }
            //return redirect('login');
            return 1;
        }

    }



    private function genrate_user_accounts($user_id1,$orderData=array(),$flag=''){
        set_time_limit(150);
        $last_user = 0;
        $userdata = User::with('users_infos')->where('user_id','=',$user_id1)->first();
        $user_array = array();
        $a = 0;
        $user_total_array = array();
        $usercountArray_str = 0;
        $orderSaveData = array();
        $total_pirce = 0;
        $invoice_number = $this->generateRandomString(13);

        $num_users =  0;
        foreach ($orderData as $key => $value) {
            DB::table('invoices')->insert(array('invoice_number'=>$invoice_number,'order_id'=>$value->id));
            $licenceData = Licence::where('licence_id',$value->licence_id)->first();
            $comapny_name = $userdata['users_infos']['company_name'];
            $new_comapny_name = str_split($comapny_name,4);
            $user_company_name = $new_comapny_name[0];
            $getAlradyUsers = User::where('user_parrent_id',$user_id1)->count();
            $a = 0;
            $b = 0;
            $b = $getAlradyUsers+1;
            $date = strtotime("+".$licenceData['licence_period']." day");
            $date1 =  date('M d, Y', $date);
            $total = $value->licence_user;

            $orderSaveData[$key] = array('licence_type'=>$licenceData['licence_type'],'licence_price'=>$licenceData['licence_price'],'currency'=>'GBP','numbers'=>$value->licence_user,'licence_valid_till'=>$date1,'subtotal'=>$value->licence_user*$licenceData['licence_price']);
            $total_pirce = $total_pirce + (int)$orderSaveData[$key]['subtotal'];
            while ($total > 0) {
                $user = New User;
                $username = strtolower($user_company_name."_user".$b);
                $user->user_username = $username;
                $user->email = $username;
                $user->user_is_active = 1;
                $user->password = bcrypt("culturebuff");
                $user->user_type = 1; 
                $user->is_confirmed = 1; 
                $user->remember_token = bcrypt("culturebuff");
                $user->user_parrent_id =  $user_id1;
                $user->save();
                $user_id = DB::getPdo()->lastInsertId();
                if(!empty($user_id)){
                    $user_info = new Users_info;
                    $user_info->user_id=$user_id;
                    $user_info->company_name=$comapny_name;
                    $user_info->save();
                    $info_id = DB::getPdo()->lastInsertId();

                    if(!empty($info_id)){
                        $game_id = $licenceData['game_id'];
                        $users_game_info = new Users_game_info;
                        $users_game_info->game_id = $game_id;
                        $users_game_info->user_id = $user_id;
                        $users_game_info->game_licence = $licenceData['licence_id'];
                        $users_game_info->purchase_type = 1;
                        $users_game_info->licence_valid_till = $date1;
                        $users_game_info->save();
                    }
                }
                $user_total_array[$num_users][$a] = array('user_username'=>$user->user_username,'game_licence'=>$licenceData['licence_type'],'expired'=>$date1);

                $total = $total-1;
                $a = $a+1;
                $b = $b+1;
                $num_users =  $num_users+1;
            }

              Game_purchase_order::where('txn_id',$value->txn_id)->update(array('order_status'=>1));
        }
      
        $str = $userdata['email'];
        $userList = array();
        foreach ($user_total_array as $key => $value) {
            foreach ($value as $k => $v) {
                $userList[$key] = array('user_username'=>$v['user_username'],'org_password'=>'culturebuff','game_licence'=>$v['game_licence'],'expired'=>$v['expired']);
            }
        }    
        //$invoice = 'Your Licence genrate for games. please check userlist mail.';
        $invoiceData = array('invoice_number'=>$invoice_number,'purchase_date'=>date("d-M-Y"),'orderSaveData'=>$orderSaveData,'total_price'=>$total_pirce);
        $userdata['invoiceData'] = $invoiceData;
        //$userData[''] = $orderSaveData;
        $pdf = PDF::loadView('emails..pdf.invoice', array('data' => $userdata));
        $mailarray = array('email'=>$str,'pdf'=>$pdf);
        Mail::send('emails.invoice', $confirmed = array('data'=>$userdata), function($message) use ($mailarray) {
            $email = $mailarray['email'];
            $pdf   =  $mailarray['pdf'];
            $message->to($email)
            
                ->subject('Invoice For Purchase Of Culture Buff Games');
                $message->attachData($pdf->output(), "invoice.pdf");
                //$message->Output();
        });
        if($flag == 1){
            $file = 'existing_corparte_purchaser';
        }else{
            $file = 'new_corparte_purchaser';
        }
        $userdata['user_accounts'] = $userList;
  $email = $str ;
        $pdf = '';
	//	Mail::send("emails.$file", $confirmed = array('data'=>$userdata), function($message) use ($mailarray) {
        Mail::send("emails.$file", $confirmed = array('data'=>$userdata,'user_accounts'=>$userList), function($message
            ) use ($userdata,$email,$file,$userList) {
          //  $email = $mailarray['email'];
           // $pdf   = $mailarray['pdf'];
             $message->to($email)
                ->subject('Thanks for purchasing Culture Buff Games');
                //$message->attachData($pdf->output(), "accountlist.pdf");
        });
/*
        $data = array();
        //prd($userdata);
        $email = $str ;
		
		$invoiceData = array('invoice_number'=>$invoice_number,'purchase_date'=>date("d-M-Y"),'orderSaveData'=>$orderSaveData,'total_price'=>$total_pirce);
                $userdata['invoiceData'] = $invoiceData;
                //$userData[''] = $orderSaveData;

                $pdf = PDF::loadView('emails.pdf.invoice', array('data' => $userdata));
                $mailarray = array('email'=>$str,'pdf'=>$pdf);
        Mail::send('emails.invoice', $confirmeda = array('data' => $userdata), function($message) use ($mailarray)
        {
			$email = $mailarray['email'];
			$pdf   =  $mailarray['pdf'];
           $message->to($email)
           ->subject('Invoice For Purchase Of Culture Buff Games');
           $message->attachData($pdf->output(), "invoice.pdf");

        });

       
        
        if($flag == 1){
            $file = 'existing_corparte_purchaser';
        }else{
            $file = 'new_corparte_purchaser';
        }
        
        $userdata['user_accounts'] = $userList;

        /*$pdf = PDF::loadView("emails.$file", array('data' => $userdata));

        $mailarray = array('email'=>$str,'pdf'=>$pdf);
       
 
        Mail::send("emails.$file", $confirmed = array('data'=>$userdata,'user_accounts'=>$userList), function($message
            ) use ($userdata,$email,$file,$userList) {
          //  $email = $mailarray['email'];
           // $pdf   = $mailarray['pdf'];
            
            $pdf = PDF::loadView("emails.$file", array('data' => $userdata,'user_accounts'=>$userList));

             $message->to($email)
                ->subject('Thanks for purchasing Culture Buff Games');
                //$message->attachData($pdf->output(), "accountlist.pdf");

        });

*/

        return 1;
    }

    public function getprice(){
        $postData = Input::get();
        $licenceType = $postData['licenceType'];
        $licenceData = Licence::where('licence_id',$licenceType)->first();
        $price = $licenceData['licence_price'] * $postData['number'];
        $return = array('price'=>$price);
        return $return;
    }

   /* private function genrate_user_accounts($user_id1,$orderData=array(),$flag = ''){
    	$last_user = 0;
    	$userdata = User::with('users_infos')->where('user_id','=',$user_id1)->first();
    	$user_array = array();
    	$a = 0;
    	$user_total_array = array();
        $usercountArray_str = 0;
    	foreach ($orderData as $key => $value) {
    		$licenceData = $licenceData = Licence::where('licence_id',$value->licence_id)->first();
	        $comapny_name = $userdata['users_infos']['company_name'];
	        $new_comapny_name = str_split($comapny_name,4);
	        $user_company_name = $new_comapny_name[0];
	        $getAlradyUsers = User::where('user_parrent_id',$user_id1)->count();
	        $a = 0;
            $b = 0;
	        $b = $getAlradyUsers+1;
	        $date = strtotime("+".$licenceData['licence_period']." day");
	        $date1 =  date('M d, Y', $date);
	       	$total = $value->licence_user;
	       	
            while ($total > 0) {
                $user = New User;
                //$user = new User;
                $username = strtolower($user_company_name."_user".$b);
                $user->user_username = $username;
                $user->email = $user_company_name."_user".$b;
                $user->user_is_active = 1;
                $user->password = bcrypt("culturebuff");
                //$user->user_parrent_id = $user_id1;
                $user->user_type = 1; 
                $user->is_confirmed = 1; 
                $user->remember_token = bcrypt("culturebuff");
                $user->user_parrent_id =  $user_id1;
                $user->save();
                $user_id = DB::getPdo()->lastInsertId();
                if(!empty($user_id)){
                    $user_info = new Users_info;
                    $user_info->user_id=$user_id;
                    $user_info->company_name=$comapny_name;
                    $user_info->save();
                    $info_id = DB::getPdo()->lastInsertId();

                    if(!empty($info_id)){
                        $game_id = $licenceData['game_id'];
                        $users_game_info = new Users_game_info;
                        $users_game_info->game_id = $game_id;
                        $users_game_info->user_id = $user_id;
                        $users_game_info->game_licence = $licenceData['licence_id'];
                        $users_game_info->licence_valid_till = $date1;
                        $users_game_info->save();
                    }
                }

                $user_total_array[$key][$a] = array('user_username'=>$user->user_username,'game_licence'=>$licenceData['licence_type'],'expired'=>$date1);

                $total = $total-1;
                $a = $a+1;
                $b = $b+1;
	        }
	       
	      
	            
        }
      // prd($user_total_array);

        

        $str = $userdata['email'];
        $userList ='';
        $userList .= '<table>
                        <tr>
                            <th>Username</th>
                            <th>password</th>
                            <th>licence type</th>
                            <th>expire date</th>
                        </tr>';
                    foreach ($user_total_array as $key => $value) {
                            
	                    foreach ($value as $k => $v) {
	            		$userList .= '<tr>
	                            <td>'.$v['user_username'].'</td>
	                            <td>culturebuff</td>
	                            <td>'.$v['game_licence'].'</td>
	                            <td>'.$v['expired'].'</td>
	                        </tr>';                
	                        }
                    }    
                        
        $userList .= '</table>';
        
        //$payment = $payment*$totalusers;
       

        $invoice = 'Your Licence genrate for games. please check userlist mail.';
        
        $pdf = PDF::loadView('emails.invoice', array('invoice' => $invoice));
        $mailarray = array('email'=>$str,'pdf'=>$pdf);
        Mail::send('emails.invoice', $confirmed = array('invoice'=>$invoice), function($message) use ($mailarray) {
        	$email = $mailarray['email'];
        	$pdf   =  $mailarray['pdf'];
             $message->to($email)
                ->subject('Game purchase invoice.');
                $message->attachData($pdf->output(), "invoice.pdf");
        });
        
        $pdf = PDF::loadView('emails.accountlist', array('userList' => $userList));

        $mailarray = array('email'=>$str,'pdf'=>$pdf);
        Mail::send('emails.accountlist', $confirmed = array('userList'=>$userList), function($message
        	) use ($mailarray) {
        	$email = $mailarray['email'];
        	$pdf   = $mailarray['pdf'];
             $message->to($email)
                ->subject('User list form britishgame.');
                $message->attachData($pdf->output(), "accountlist.pdf");

        });
        return true;


    }*/

    public function payment_successful()
    {
        $postData = Input::get();
        //return redirect('payment-successful'); 
        //prd($postData);
        if(!empty($postData['cm'])){
            $flag = 0;
            //$order_status = $this->orderSucess($postData,$flag);
            /* if($order_status == 1){
                //die();
                 
             }*/
             return redirect('payment-successful'); 
            //
        }

        $data = array('main_content'=>'payment_successful');
        return view('front.includes.template1',compact('data'));
        
    }
    
    public function payment_cancelled()
    {
        $data = array('main_content'=>'payment_cancel');
        return view('front.includes.template1',compact('data'));
    }




    public function pdf(){
        $factuur = "";
        $pdf = PDF::loadView('emails.accountlist', array('userList' => $factuur));
        Mail::send('emails.accountlist', $confirmed = array('userList'=>$factuur), function($message,$email) use ($pdf,$email) {
             $message->to('manish.s@dotsquares.com')
                ->subject('User list form britishgame.');
                    $message->attachData($pdf->output(), "invoice.pdf");  
        });
    }

    public function contactmail(){
        $postData = Input::get();
        $userList = $postData;
        Mail::send('emails.inquiry', $confirmed = array('userList'=>$userList), function($message
            ) use ($postData) {
            $message->to('manish.s@dotsquares.com')
                ->subject('enquiry mail form britishgame.');
        });
        $Inquiry_list = new Inquiry_list;
        $Inquiry_list->name = $postData['name'];
        $Inquiry_list->email = $postData['email'];
        $Inquiry_list->message = $postData['message'];
        $Inquiry_list->save();
        Session::flash('success', 'enquiry sent successfully.');
        return redirect('contactus');
    }

    /*public function trailMail(){
        $userList = '';
        Mail::send('emails.trailverify', $confirmed = array('userData'=>$userList), function($message
            ) use($email)  {
            $message->to($email)
                ->subject('trail mail');
        });
    }*/

}