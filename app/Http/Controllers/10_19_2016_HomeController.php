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
    public function index()
    {
       // return view('front.welcome');
    }

    public function resetpassword(){
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
                'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
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
                'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
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
               // pr($userdata);
                if (Auth::attempt($userdata)) {
                    $userData = Auth::user();
                //   prd($userData); 
                    if ($userData->user_is_active == 1) {
                      if($userData->role_id == 2 ) {
                        //prd($userData);
                            if($userData->is_confirmed == 1){
                                $login_count = $userData->user_login_count +1; 
                                User::where('user_id','=',$userData->user_id)
                                ->update(array('user_last_login'=>date('Y-m-d H:i:s'),'user_login_count'=>$login_count));

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
                        return redirect()->back()->withErrors("Your account has been deactived. Please contact the system administrator to reactivate your account.");
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
            $user->password = Hash::make($postData['password']);
            $user->user_parrent_id = 0;
            $user->confirmed = $confirmed;
            $user->remember_token = Hash::make($postData['password']);
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
                    $users_game_info->purchase_type = 1;
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
                        Mail::send('emails.trailverify', $confirmed = array('userData'=>$postData), function($message
                            ) use($str)  {
                            $message->to($str)
                                ->subject('Verify your email address');
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
            $setVlaid = array(
                "email"=>'required|email',
                //"user_username"=>'required|unique:users,user_username',
                'password' => 'required|min:3|confirmed',
                'first_name'=>'required',
                'last_name'=>'required',
                'country_id'=>'required',
                'user_type' => 'required'
                );
            
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
            $user->password = Hash::make($postData['password']);
            $user->user_parrent_id = 0;
            $user->user_type = $postData['user_type']; 
            $user->confirmed = $confirmed;
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
                if(!empty($info_id)){
                   /* $users_game_info = new  Users_game_info;
                    $users_game_info->game_id = 1;
                    $users_game_info->user_id = $user_id;
                    $users_game_info->game_licence = 2;
                    $users_game_info->save();
                    $game_id = DB::getPdo()->lastInsertId();
                    if(!empty($game_id)){*/
                        $str =  $postData['email'];
                        Mail::send('emails.purchase', $confirmed = array('confirmation_code'=>$confirmed), function($message) use ($str) {
                             $message->to($str)
                                ->subject('purchase link form britishgame.');
                        });


                        $return = array('status'=>1,'msg'=>'users register successfully pass to from 2.');
                        return $return;
                    /*}*/
                } 

            }

        }
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
            $paypal_email = 'sujen@gmail.com';
            $return_url = 'http://britishgame.projectstatus.in/payment-successful';
            $cancel_url = 'http://britishgame.projectstatus.in/payment-cancelled';
            $notify_url = 'http://britishgame.projectstatus.in/purchase';
            //pr($postData);
            $order_uniq_id = $this->generateRandomString(6);
            $txn_id = $this->generateRandomString(6);
            if (!isset($postData["txn_id"]) && !isset($postData["txn_type"])){
                $licence_info = Licence::where('licence_id',$postData['licenceType'])->first();
                $item_amount = $licence_info['licence_price'] ;
                $Game_purchase_order = new Game_purchase_order;
                $Game_purchase_order->user_id = $user['user_id'];
                $Game_purchase_order->licence_id = $postData['licenceType'];
                $Game_purchase_order->licence_user = $postData['numberoflicence'];
                $Game_purchase_order->txn_id = $txn_id;
                $Game_purchase_order->order_payment = $item_amount;
                // $Game_purchase_order->order_payment = '0.3';
                $Game_purchase_order->save();
                $querystring = '';
                
                // Firstly Append paypal account to querystring
                $querystring .= "?business=".urlencode($paypal_email)."&";
                
                // Append amount& currency (£) to quersytring so it cannot be edited in html
                
                //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.

                $querystring .= "item_name=".urlencode($licence_info['licence_type'])."&";
                $querystring .= "amount=".urlencode($item_amount)."&";
                //$querystring .= "amount=".urlencode('0.3')."&";
                $querystring .= "first_name=".urlencode($user['users_infos']['first_name'])."&";
                $querystring .= "last_name=".urlencode($user['users_infos']['last_name'])."&";
                $querystring .= "payer_email=".urlencode($user['email'])."&";
                $querystring .= "item_number=".urlencode($txn_id)."&";
                $querystring .= "no_note=".urlencode($postData['numberoflicence'])."&";
                $querystring .= "quantity=".urlencode($postData['numberoflicence'])."&";
                $querystring .= "txn_id=".urlencode($txn_id)."&";
                //
                //loop for posted values and append to querystring
                foreach($postData as $key => $value){
                    $value = urlencode(stripslashes($value));
                    $querystring .= "$key=$value&";
                }
                
                // Append paypal return addresses
                $querystring .= "return=".urlencode(stripslashes($return_url))."&";
                $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
                $querystring .= "notify_url=".urlencode($notify_url);
                
                // Append querystring with custom field
                //$querystring .= "&custom=".USERID;
                
                // Redirect to paypal IPN
                header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
                exit();
            }
            else {
            	//$this->file_write();
                /*echo "string";
                die();*/
                //Database Connection
                
                // Response from Paypal
                // read the post from PayPal system and add 'cmd'
                $req = 'cmd=_notify-validate';
                foreach ($_POST as $key => $value) {
                    $value = urlencode(stripslashes($value));
                    $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
                    $req .= "&$key=$value";
                }
                
                // assign posted variables to local variables
                $data['item_name']          = $postData['item_name'];
                $data['item_number']        = $postData['item_number'];
                $data['payment_status']     = $postData['payment_status'];
                $data['payment_amount']     = $postData['mc_gross'];
                $data['payment_currency']   = $postData['mc_currency'];
                $data['txn_id']             = $postData['txn_id'];
                $data['receiver_email']     = $postData['receiver_email'];
                $data['payer_email']        = $postData['payer_email'];
                $data['custom']             = $postData['custom'];

                $sv = json_encode($postData);
                $test = new Test;
                $test->responce = $sv;
                $test->save();
                //die();
                // post back to PayPal system to validate
                $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
                $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
                $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
                
                $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
                
                if (!$fp) {
                    // HTTP ERROR
                    
                } else {
                    fputs($fp, $header . $req);
                    while (!feof($fp)) {
                        $res = fgets ($fp, 1024);
                        if (strcmp($res, "VERIFIED") == 0) {
                            
                            // Used for debugging
                            // mail('user@domain.com', 'PAYPAL POST - VERIFIED RESPONSE', print_r($post, true));
                                    
                            // Validate payment (Check unique txnid & correct price)
                            $txnid_history  =  Game_purchase_order::where('txn_id','=',$data['txn_id'])->first();

                            if(!empty($txnid_history)){
                              $valid_txnid = true ; 
                            }

                            /**/
                            $valid_price_history  =  Game_purchase_order::where('order_payment','=',$data['payment_amount'])->where('txn_id','=',$data['txn_id'])->first();
                            if(!empty($valid_price_history)){
                                $valid_price = true;    
                            }
                             //= check_price($data['payment_amount'], $data['item_number']);
                            // PAYMENT VALIDATED & VERIFIED!
                            if ($valid_txnid && $valid_price) {
                                
                                $orderid = Game_purchase_order::where('txn_id','=',$data['txn_id'])->update(array('order_status'=>1));
                                
                                if ($orderid) {
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
                        
                        } else if (strcmp ($res, "INVALID") == 0) {
                        
                            // PAYMENT INVALID & INVESTIGATE MANUALY!
                            // E-mail admin or alert user
                            
                            // Used for debugging
                            //@mail("user@domain.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");
                        }
                    }
                fclose ($fp);
                }
            }


          //  prd($postData);
        }
        $allgamess = Games::where('game_is_active',1)->where('game_is_deleted',0)->get();
        $allLicence = Licence::where('licence_is_active',1)->where('licence_id','!=',1)->where('licence_id','!=',2)->where('licence_is_deleted',0)->get();
        $data = array('allgamess'=>$allgamess,'allLicence'=>$allLicence,'user'=>$user,'main_content'=>'purchase');
        return view('front.includes.template1',compact('data'));
    }

    public function getprice(){
        $postData = Input::get();
        $licenceType = $postData['licenceType'];
        
        $licenceData = Licence::where('licence_id',$licenceType)->first();

        $price = $licenceData['licence_price'] * $postData['number'];
        
        $return = array('price'=>$price);
        return $return;
    }

    public function payment_successful()
    {
        $postData = Input::get();
        if(!empty($postData)){
            $item_number= $postData['item_number'];
            $orderData = Game_purchase_order::where('txn_id',$item_number)->first();
            $user_id = $orderData['user_id'];
            $total = $orderData['licence_user'];
            $licence_id = $orderData['licence_id'];
            $payment = $orderData['order_payment'];
            $licenceData = Licence::where('licence_id',$licence_id)->first();
            if($total > 1){
                $this->genrate_user_accounts($user_id,$total,$licenceData,$payment);
            }else{
                $date = strtotime("+".$licenceData['licence_period']." day");
                $date1 =  date('M d, Y', $date);
                $game_id = $licenceData['game_id'];
                /*switch ($licenceData['licence_id']) {
                    case '3':
                        $game_id = 1;
                        break;
                    case '4':
                        $game_id = 2;
                    break;    

                    case '5':
                        $game_id = 3;
                    break;    
                }*/

                $users_game_info = new Users_game_info;
                $users_game_info->game_id = $game_id;
                $users_game_info->user_id = $user_id;
                $users_game_info->game_licence = $licenceData['licence_id'];
                $users_game_info->licence_valid_till = $date1;
                $users_game_info->purchase_type = 1;
                $users_game_info->save();

                $payment = $payment*$total;
                $invoice = 'Your Licence genrate for game plan '.$licenceData['licence_type'].' licence expired till '.$date1.'. for number of users '.$total.' and payement is '.$payment.'';
                $userData = User::where('user_id',$user_id)->first();
                $str =  $userData['email'];
                
                $pdf = PDF::loadView('emails.invoice', array('invoice' => $invoice));
                $mailarray = array('email'=>$str,'pdf'=>$pdf);
		        Mail::send('emails.invoice', $confirmed = array('invoice'=>$invoice), function($message) use ($mailarray) {
		        	$email = $mailarray['email'];
        			$pdf   =  $mailarray['pdf'];
		             $message->to($email)
		                ->subject('Game purchase invoice.');
		                $message->attachData($pdf->output(), "invoice.pdf");
		        });


            }
            Game_purchase_order::where('txn_id',$item_number)->update(array('order_status'=>1));
            User::where('user_id',$user_id)->update(array('confirmed'=>'','is_confirmed'=>1,'user_is_active'=>1));
           return redirect('payment-successful');
        }
        $data = array('main_content'=>'payment_successful');
        return view('front.includes.template1',compact('data'));
        
    }
    
    public function payment_cancelled()
    {
        $data = array('main_content'=>'payment_cancel');
        return view('front.includes.template1',compact('data'));
    }

    private function genrate_user_accounts($user_id,$total,$licenceData=array(),$payment){
        $userdata = User::with('users_infos')->where('user_id','=',$user_id)->first();
        $comapny_name = $userdata['users_infos']['company_name'];
        $new_comapny_name = str_split($comapny_name,4);
        $user_company_name = $new_comapny_name[0];
        $user_array = array();
        $a = 1;
        $totalusers = $total;
       // echo $total;
        while ($total > 0) {
            $user_array[$a]['user_username'] = $user_company_name."_user".$a;
            $password = "culturebuff";
            $user_array[$a]['password'] = Hash::make($password);
            $total = $total-1;
            $a = $a+1;
        }
        $date = strtotime("+".$licenceData['licence_period']." day");
        $date1 =  date('M d, Y', $date);
        foreach ($user_array as $key => $value) {
            $user = New User;
            //$user = new User;
            $user->user_username = $value['user_username'];
            $user->email = $value['user_username'];
            $user->user_is_active = 1;
            $user->password = $value['password'];
            $user->user_parrent_id = 0;
            $user->user_type = 1; 
            $user->is_confirmed = 1; 
            $user->remember_token = $value['password'];
            $user->user_parrent_id = $userdata['user_id'];
            $user->save();
            $user_id = DB::getPdo()->lastInsertId();
            if(!empty($user_id)){
                $user_info = new Users_info;
                $user_info->user_id=$user_id;
                $user_info->company_name=$comapny_name;
                $user_info->save();
                $info_id = DB::getPdo()->lastInsertId();

                if(!empty($info_id)){
                    switch ($licenceData['licence_id']) {
                        case '3':
                            $game_id = 1;
                            break;
                        case '4':
                            $game_id = 2;
                        break;    

                        case '5':
                            $game_id = 3;
                        break;    
                    }
                    $users_game_info = new Users_game_info;
                    $users_game_info->game_id = $game_id;
                    $users_game_info->user_id = $user_id;
                    $users_game_info->game_licence = $licenceData['licence_id'];
                    $users_game_info->licence_valid_till = $date1;
                    $users_game_info->save();
                }
            }
        }

        $str = $userdata['email'];
        $userList ='';
        $userList .= '<table>
                        <tr>
                            <th>Username</th>
                            <th>password</th>
                        </tr>';
                    foreach ($user_array as $key => $value) {
            $userList .= '<tr>
                            <th>'.$value['user_username'].'</th>
                            <th>culturebuff</th>
                        </tr>';                
                        }    
                        
        $userList .= '</table>';

      //  prd($userdata);
        

        $payment = $payment*$totalusers;
        $invoice = 'Your Licence genrate for game plan '.$licenceData['licence_type'].' licence expired till '.$date1.'. for number of users '.$totalusers.' and payement is '.$payment.'';
        
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

    public function trailMail(){
        $userList = '';
        Mail::send('emails.trailverify', $confirmed = array('userData'=>$userList), function($message
            ) use($email)  {
            $message->to($email)
                ->subject('trail mail');
        });
    }

}