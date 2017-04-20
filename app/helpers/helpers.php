<?php
use App\Static_pages;
use App\Country;
use App\User;
//use Auth;

function pr($array)
{
   echo "<pre>";
   print_r($array);
   echo "</pre>";
}

function prd($array)
{
   echo "<pre>";
   print_r($array);
   echo "</pre>";
   die;
}

function create_unique_slug($string, $table,$field='slug',$key=NULL,$value=NULL){
	$t =& get_instance();
	$slug = url_title($string);
	$slug = strtolower($slug);
	$i = 0;
	$params = array ();
	$params[$field] = $slug;

	if($key)$params["$key !="] = $value;

	while ($t->db->where($params)->get($table)->num_rows()) {
		if (!preg_match ('/-{1}[0-9]+$/', $slug )) {
			$slug .= '-' . ++$i;
		} else {
			$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
		}
		$params [$field] = $slug;
		}
	return $slug;

}

function getInnerContent($page_id){

	$Static_pages =  Static_pages::where('page_id',$page_id)->first();
	echo $Static_pages['page_description'];
}

function getCountryOptionSrt($id=''){

	$countryList = Country::all();
	$str = '';
	foreach ($countryList as $key => $value) {

		$str.= '<option ';
		if($id == $value['country_id']){
			
			$str.= 'selected="selected"';
		}else{
			$str.= '';
		}
		$str.= 'value="'.$value['country_id'].'">'.$value['country_name'].'</option>';
	}
	echo  $str;
	//die();
}

function userdata($getparam = ''){
	$user_id = Auth::user()->user_id;
	$userData = User::with('users_infos')->where('user_id',$user_id)->first();
	return $userData['users_infos']['company_name'];
}

function changeDateFormat($date){
	if(!empty($date)){
		$date = strtotime($date);
		$date1 =  date('M d, Y', $date);
		echo $date1;
	}
	echo "";
}

?>