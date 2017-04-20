<?php namespace App\Http\Controllers\Admin;
 use App\Http\Controllers\Controller;
 use Session;
 use Auth;
 use Input;
 use Validator;
 use App\User;
 use Hash;
 use Form;
 use Html;
class HomeController extends Controller {

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
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$userData = Auth::user();
		$userData = json_decode($userData,true);
		$breadcrumb = array('Dashboard');
		$page_title = 'Dashboard';
		$data = array('main_content'=>"dashboard",'userData'=>$userData,'breadcrumb'=>$breadcrumb,'page_title'=>$page_title);
		return view('admin.includes.template',compact('data'));
	}

	public function profile(){
		$postData = Input::get();
		if(!empty($postData)){
			$userId = Auth::user()->user_id;
			//'email' => 'unique:users,email_address,'.$userId
			if(!empty($postData['password'])){
			$setVlaid = array("user_username"=>'required|unique:users,user_username,'.$userId.',user_id','password'=>'required|min:6|confirmed','email'=>'required|email|unique:users,email,'.$userId.',user_id');
			}else{
				$setVlaid = array("user_username"=>'required|unique:users,user_username,'.$userId.',user_id','email'=>'required|email|unique:users,email,'.$userId.',user_id');
			}
			$validator = Validator::make($postData,$setVlaid);
			if ($validator->fails())
		    {
		        return redirect()->back()->withErrors($validator->errors());
		    }

		    $userData = Auth::user();
		    if(!empty($postData['password'])){
		    	$password  = Hash::make($postData['password']);
		    }else{
		    	$password = Auth::user()->password;
		    }
			
		    User::where('user_id', '=', $userData['user_id'])->update(array('user_username'=>$postData['user_username'],'email'=>$postData['email'],'password'=>$password));

		    Session::flash('success', 'Profile was successfully updated.');
		    return redirect()->back();
		}    

		$userData = Auth::user();
		$userData = json_decode($userData,true);
		$breadcrumb = array('Profile');
		$page_title = 'Profile';
		$data = array('main_content'=>"profile",'userData'=>$userData,'breadcrumb'=>$breadcrumb,'page_title'=>$page_title);
		return view('admin.includes.template',compact('data'));
	}

}
