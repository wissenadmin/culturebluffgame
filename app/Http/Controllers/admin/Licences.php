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
use App\Game_purchase_order;
use Input;
use Validator;
use Hash;
use Session;
use App\Country;
use PDF;
use Mail;

class Licences extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response`
     */
    public function index()
    {
        //
        $breadcrumb = array('License');
        $page_title = 'License';
        /*$licenceData = Licence::where('licence_is_deleted','!=',1)->where('licence_id','!=',1)->where('licence_id','!=',2)->paginate(10);*/
        $licenceData = DB::table('licences as li')
            ->leftJoin('games as g', 'g.game_id', '=', 'li.game_id')
            ->select('li.*','g.game_title')->where('licence_is_deleted','!=',1)
			->where('licence_id','!=',1)->where('licence_id','!=',2)
           ->paginate(10);

//echo '<pre>';
//print_r($licenceData);

        $data = array('main_content'=>"licences/index",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'licenceData'=>$licenceData);
        
        return view('admin.includes.template',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
		//echo 'Test';exit;
        $postData = Input::get();
        if(!empty($postData))
        {
            
            $postData['licence_type'] = str_replace(" ", "", $postData['licence_type']);
            $setVlaid = array("licence_type"=>'required|unique:licences,licence_type','licence_text'=>'required','licence_period'=>'required','licence_price'=>'required','licence_is_active'=>'required','game_id'=>'required');
            
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }
            $Licence =  new Licence;
            $Licence->licence_type = $postData['licence_type'];
            $Licence->licence_text = $postData['licence_text'];
            $Licence->licence_period = $postData['licence_period'];
            $Licence->licence_price = $postData['licence_price'];
            $Licence->game_id = $postData['game_id'];
            /*$Licence->licences_for_users = $postData['licences_for_users'];*/
            $Licence->licence_is_active = $postData['licence_is_active'];
            $Licence->save();            
            $Licence_id = $Licence->id;
            if(!empty($Licence_id))
            {
                Session::flash('success_add', 'Licence added successfully.');
                return redirect('admin/licences');
            }    
        }
        $oldData = array();
        $breadcrumb = array('Add License');
        $page_title = 'Add License';
        $games = Games::where('game_is_active',1)->where('is_trial','!=',1)->get();
        $data = array('main_content'=>"licences/add",'breadcrumb'=>$breadcrumb,'oldData'=>$oldData,'page_title'=>$page_title,'games'=>$games);
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
        $postData = Input::get();
        if(!empty($postData))
        {
            $postData['licence_type'] = str_replace(" ", "", $postData['licence_type']);
            $setVlaid = array("licence_type"=>'required|unique:licences,licence_type,'.$id.',licence_id','licence_text'=>'required','licence_period'=>'required','licence_price'=>'required','licence_is_active'=>'required','game_id'=>'required');
            
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }

            Licence::where('licence_id', '=', $id)->update(array('licence_type'=>$postData['licence_type'],'licence_period'=>$postData['licence_period'],'licence_price'=>$postData['licence_price'],'licence_is_active'=>$postData['licence_is_active'],'licence_text'=>$postData['licence_text'],'game_id'=>$postData['game_id']));

            Session::flash('success_update', 'licences updated successfully.');
            return redirect('admin/licences');
        }

        $oldData = Licence::where('licence_id',$id)->first();
        $breadcrumb = array('Edit License');
        $page_title = 'Edit License';
        
      $games = Games::where('game_is_active',1)->get();
        $data = array('main_content'=>"licences/add",'breadcrumb'=>$breadcrumb,'oldData'=>$oldData,'page_title'=>$page_title,'games'=>$games);
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
        $updateArray = array('licence_is_deleted'=>1);
        $id =  Licence::where('licence_id',$id)->update($updateArray);
        if($id){
            return json_encode(array('1'));
        }
    }

    public function status($id){
        $last_value = Licence::where('licence_id',$id)->first();
        if($last_value['licence_is_active'] == 1){
            $newStatus = 0;
        }else{
            $newStatus = 1;
        }
        $updateArray = array('licence_is_active'=>$newStatus);
        $id =  Licence::where('licence_id',$id)->update($updateArray);
        if($id){
            return json_encode(array('1','newstatus'=>$newStatus));
        }
    }

    public function report(){

        $breadcrumb = array('License Report');
        $page_title = 'License Report';
        $licenceData = array();
        
        $licenceData = DB::table('users as u')
            ->leftJoin('users_game_infos as gi', 'gi.user_id', '=', 'u.user_id')
            ->leftJoin('licences as li', 'li.licence_id', '=', 'gi.game_licence')
            ->leftJoin('games as g', 'g.game_id', '=', 'gi.game_id')
            ->select(DB::raw("(GROUP_CONCAT(brg_li.licence_type)) as licence_type"),'gi.*',DB::raw("(GROUP_CONCAT(brg_g.game_title)) as game_title"),"u.user_username","li.licence_period","u.user_id","g.game_url as game_link","u.user_type","u.is_supertrial","u.user_parrent_id","u.user_is_active")
            //DB::raw("(GROUP_CONCAT(brg_li.licence_type)) as licence_type")
            ->where('u.user_parrent_id','=','0')
            ->where('u.user_id','!=','1')
            //->where('u.is_confirmed','=','1')
            ->where('u.is_confirmed','=','1')

            //->where('gi.user_id','!=','')
            ->Orwhere('u.user_parrent_id','=','1')
            ->groupby('u.user_id')
            ->paginate(10);
           // pr($licenceData);
            $ldata = array();
            $is_count = 0;
            foreach ($licenceData as $key => $value) {
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
                                    //->Orwhere('u.user_parrent_id','=','1')
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
                
                //prd($value);
               // $ldata[$key] = $value;
                $licenceData[$key] = $value;
            }

          //  prd($licenceData);

        $data = array('main_content'=>"licences/report",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'licenceData'=>$licenceData);
        return view('admin.includes.template',compact('data'));
    }

    public function manual_generation(){
        //return "we are working ";
        $postData = Input::get();
        
        if(!empty($postData))
        {
           // prd($postData);
            //$postData['user_username'] = $postData['email'];
            if($postData['types'] == 0){
                Session::set('newuser_id', $postData['user_id']);
                return redirect('admin/licences/manual-generation-admin/1'); 
            }
            $setVlaid = array(
                "email"=>'required|unique:users,email',
                "user_username"=>'required|unique:users,user_username',
                'password' => 'required|min:3|confirmed',
                'first_name'=>'required',
                'last_name'=>'required',
                'country_id'=>'required',
                'user_type' => 'required'
                );
            
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withInput(Input::get())->withErrors($validator->errors());

            }
            //$confirmed = $this->generateRandomString(15);

            $user = new User;
            $user->user_username = $postData['user_username'];
            $user->email = $postData['email'];
            $user->user_is_active = 0;
            $user->password = Hash::make($postData['password']);
            $user->org_password = $postData['password'];
            $user->user_parrent_id = 0;
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
                if(!empty($info_id)){
                   // Session::set('newuser_id' => $user_id);
                    Session::set('newuser_id', $user_id);
                    return redirect("admin/licences/manual-generation-admin/0");
                } 
            }
        }


        $oldData = array();
        $breadcrumb = array('Create manual generation');
        $page_title = 'Create manual generation';
        $countryList = Country::all();
        $user_list = User::where('user_parrent_id','!',0)->where('role_id','=',2)->where('user_is_active',1)->get();
        $data = array('main_content'=>"licences/manual_generation",'breadcrumb'=>$breadcrumb,'oldData'=>$oldData,'page_title'=>$page_title,'countryList'=>$countryList,'user_list'=>$user_list);
        return view('admin.includes.template',compact('data'));
    }

    public function manual_generation_admin($flag = 0){
        $user_id = Session::get('newuser_id');
       // echo $user_id;
        $user = User::with('users_infos')->where('user_id','=',$user_id)->first();
        if(empty($user)){
            return redirect('admin');
        }
        $postData = Input::get();

        if(!empty($postData)){
            if(empty($postData['licenceType'])){
                $setVlaid = array("purchase_licence"=>'required');
            
                $validator = Validator::make($postData,$setVlaid);
                if ($validator->fails())
                {
                    return redirect()->back()->withErrors($validator->errors());
                }

            }

            $licenceType = $postData['licenceType'];
			
            $txn_id = $this->generateRandomString(15);
            foreach ($licenceType as $key => $value) {
                    $order_uniq_id = $this->generateRandomString(6);
                    $ka  = $key+1;
                    $licence_info = Licence::where('licence_id',$value)->first();
                    $item_amount = $licence_info['licence_price']; //* $postData['numberoflicence'][$value];
                    $Game_purchase_order = new Game_purchase_order;
                    $Game_purchase_order->user_id = $user_id;
                    $Game_purchase_order->licence_id = $value;
                    $Game_purchase_order->licence_user = $postData['numberoflicence'][$value];
                    $Game_purchase_order->txn_id = $txn_id;
                    $Game_purchase_order->order_payment = $item_amount * $postData['numberoflicence'][$value];
                    // $Game_purchase_order->order_payment = '0.3';
                    $Game_purchase_order->save();
            }

            $status = $this->orderSucess(array('cm'=>$txn_id),$flag);

            //check is trial 
                $isTrail = Users_game_info::where('game_licence',2)->where('user_id',$user_id)->first();
                if($isTrail){
                    Users_game_info::where('game_licence',2)->where('user_id',$user_id)->update(array('licence_is_deleted'=>1));
                }
            //

            if($status == 1){

                return redirect('admin/licences-report');
            }    


            /*$order_uniq_id = $this->generateRandomString(6);
            $txn_id = $this->generateRandomString(6);

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

            $orderData = Game_purchase_order::where('txn_id',$txn_id)->first();
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
            Game_purchase_order::where('txn_id',$txn_id)->update(array('order_status'=>1));
            User::where('user_id',$user_id)->update(array('confirmed'=>'','is_confirmed'=>1,'user_is_active'=>1));
           // Session::('newuser_id');
            Session::forget('newuser_id');
           return redirect('admin/licences-report');*/
        }



        $breadcrumb = array('Create manual generation');
        $page_title = 'Create manual generation';
        $allgamess = Games::where('game_is_active',1)->where('game_is_deleted',0)->get();
        $allLicence = Licence::where('licence_is_active',1)->where('licence_id','!=',1)->where('licence_id','!=',2)->where('licence_is_deleted',0)->get();
        $data = array('allgamess'=>$allgamess,'allLicence'=>$allLicence,'user'=>$user,'main_content'=>'licences/purchase','breadcrumb'=>$breadcrumb,'page_title'=>$page_title,);
        return view('admin.includes.template',compact('data'));
    }


    public function orderSucess($postData = array(),$flag=''){
        //$postData = Input::get();
        if(!empty($postData)){
            $item_number= $postData['cm'];
            $orderData = Game_purchase_order::where('txn_id',$item_number)->get();
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
                    $users_game_info->purchase_type = 2;
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
               // $username = strtolower($user_company_name."_user".$b);
				$username = strtolower($user_company_name."_user".$b);
                $user->user_username = $username;
                $user->email = $username;
                $user->user_is_active = 1;
                $user->password = Hash::make("culturebuff");
                $user->user_type = 1; 
                $user->is_confirmed = 1; 
                $user->remember_token = Hash::make("culturebuff");
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
                        $users_game_info->purchase_type = 2;
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

        //$pdf = PDF::loadView('emails.pdf.invoice', array('data' => $userdata));
        //$mailarray = array('email'=>$str,'pdf'=>$pdf);
        /*Mail::send('emails.invoice', $confirmed = array('data'=>$userdata), function($message) use ($mailarray) {
            $email = $mailarray['email'];
            $pdf   =  $mailarray['pdf'];
            $message->to($email)
                ->subject('Invoice For Purchase Of Culture Buff Games');
                $message->attachData($pdf->output(), "invoice.pdf");
                //$message->Output();
        });*/
        $data = array();
        //prd($userdata);
        $email = $str ;
		
        Mail::send('emails.invoice', $data = array('data' => $userdata), function($message) use ($userdata,$email)
        {
           $pdf =  PDF::loadView('emails.pdf.invoice', array('data' => $userdata));
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
        $pdf = '';
	//	Mail::send("emails.$file", $confirmed = array('data'=>$userdata), function($message) use ($mailarray) {
        Mail::send("emails.$file", $confirmed = array('data'=>$userdata,'user_accounts'=>$userList), function($message
            ) use ($userdata,$email,$file,$userList) {
          //  $email = $mailarray['email'];
           // $pdf   = $mailarray['pdf'];
		  
           
            $pdf = PDF::loadView("emails.$file", array('data' => $userdata,'user_accounts'=>$userList));

             $message->to($email)
                ->subject('Thanks for purchasing Culture Buff Games');
                //$message->attachData($pdf->output(), "accountlist.pdf");
        });
        return true;
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
