<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User; //namepaced class importing

class Users_info extends Model
{
    //
    //users_info_id`, `user_id`, `first_name`, `middle_name`, `last_name`, `company_name`, `designation`, `sector`, `country_id`, `company_website
	protected $fillable = ['first_name','middle_name','user_id','last_name','company_name','designation','sector','country_id','company_website'];

    public $timestamps = false;
      
    
	 public function user()
    {
        return $this->belongsTo('App\User');
    }
}
