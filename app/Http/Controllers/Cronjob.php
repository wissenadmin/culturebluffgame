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
class Cronjob extends Controller
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
        $this->expire();
        $this->expireInmonth();
       // return view('front.welcome');
    }

    private function expire(){
       $licenceData = DB::table('users_game_infos as gi')
        ->leftJoin('users as u', 'gi.user_id', '=', 'u.user_id')
        ->leftJoin('licences as li', 'li.licence_id', '=', 'gi.game_licence')
        ->leftJoin('games as g', 'g.game_id', '=', 'gi.game_id')
        ->select('li.licence_type','gi.*',"g.game_title","u.user_username","u.email","li.licence_period","u.user_id","g.game_url as game_link","u.user_type","u.user_parrent_id","li.licence_type")  
        ->where('gi.game_is_expire','!=','2')
        ->where('u.user_is_active','=','1')
        ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`licence_valid_till`, '%M %d,%Y'), '%Y-%m-%d')"),"<",DB::raw('now()'))
        ->get();
        foreach ($licenceData as $key => $value) {
            User::where('user_id',$value->user_id)->update(array('user_is_active'=>0));
            Users_game_info::where('user_id',$value->user_id)->where('users_game_info_id',$value->users_game_info_id)->update(array('game_is_expire'=>2));
            
            if(!empty($value->user_parrent_id)){
                $parrent_data = User::where('user_id',$value->user_parrent_id)->first();
                $str    = $parrent_data['email'];
            }else{
                $str    = $value->email;
            }


           // $str = 'manish.s@dotsquares.com';
            Mail::send('emails.expiremail', $userList =array('key'=>$value,'mailtype'=>1), function($message) use ($str) {
                $message->to($str)
                ->subject('Account expire on Culture Buff Games');
            });
        }
    }

    private function expireInmonth(){

        $licenceData = DB::table('users_game_infos as gi')
        ->leftJoin('users as u', 'gi.user_id', '=', 'u.user_id')
        ->leftJoin('licences as li', 'li.licence_id', '=', 'gi.game_licence')
        ->leftJoin('games as g', 'g.game_id', '=', 'gi.game_id')
        ->select('li.licence_type','gi.*',"g.game_title","u.user_username","u.email","li.licence_period","u.user_id","g.game_url as game_link","u.user_type","li.licence_type","u.user_parrent_id") 
        ->where('gi.game_is_expire','!=','2')
        ->where('u.user_is_active','=','1')
        ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(`licence_valid_till`, '%M %d,%Y'), '%Y-%m-%d')"),"<",DB::raw('NOW() + INTERVAL 30 DAY'))
        ->get();
        foreach ($licenceData as $key => $value) {
            /*Users_game_info::where('user_id',$value->user_id)->where('users_game_info_id',$value->users_game_info_id)->update(array('game_is_expire'=>2));*/
            if(!empty($value->user_parrent_id)){
                $parrent_data = User::where('user_id',$value->user_parrent_id)->first();
                $str    = $parrent_data['email'];
            }else{
                $str    = $value->email;
            }
            
           // $str = 'manish.s@dotsquares.com';
            Mail::send('emails.expiremailonmonth', $userList =array('key'=>$value,'mailtype'=>1), function($message) use ($str) {
                $message->to($str)
                ->subject('Account expire on Culture Buff Games');
            });
        }

    }
}