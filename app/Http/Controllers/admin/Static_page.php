<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Games;
use App\User;
use App\Licence;
use App\Static_pages;
use DB;
use Input;
use Validator;
use Session;

class Static_page extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $breadcrumb = array('Static Page');
        $page_title = 'Static Page';
        $static_pages = Static_pages::where('page_is_deleted','!=',1)->paginate(10);
        $data = array('main_content'=>"staticpage/index",'breadcrumb'=>$breadcrumb,'page_title'=>$page_title,'static_pages'=>$static_pages);
     //   prd($data);

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
            $setVlaid = array("page_title"=>'required|unique:static_pages,page_title','page_description'=>'required','page_is_active'=>'required');
            
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }
            $staticpage =  new Static_pages;
            $staticpage->page_title = $postData['page_title'];
            $staticpage->page_description = $postData['page_description'];
            
            $staticpage->page_is_active = $postData['page_is_active'];
            $staticpage->save();
            $page_id = $staticpage->id;
            if(!empty($page_id)){
                Session::flash('success_add', 'page added successfully.');
                return redirect('admin/static-page');
            }    
        }

        $oldData = array();
        $breadcrumb = array('Add Page');
        $page_title = 'Add Page';
        
        $data = array('main_content'=>"staticpage/add",'breadcrumb'=>$breadcrumb,'oldData'=>$oldData,'page_title'=>$page_title);
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
        $postData = Input::get();
        if(!empty($postData)){
            $setVlaid = array("page_title"=>'required|unique:static_pages,page_title,'.$id.',page_id','page_description'=>'required','page_is_active'=>'required');
            
            $validator = Validator::make($postData,$setVlaid);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }
            $updateArray = array('page_title'=>$postData['page_title'],'page_description'=>$postData['page_description'],'page_is_active'=>$postData['page_is_active']);
            $page_id = Static_pages::where('page_id',$id)->update($updateArray);
            if(!empty($page_id)){
                Session::flash('success_update', 'page update successfully.');
                return redirect('admin/static-page');
            }    
        }


        $oldData = Static_pages::where('page_id',$id)->first();
        $breadcrumb = array('Edit Page');
        $page_title = 'Edit Page';
        $data = array('main_content'=>"staticpage/add",'breadcrumb'=>$breadcrumb,'oldData'=>$oldData,'page_title'=>$page_title);
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
        $updateArray = array('page_is_deleted'=>1);
        $id =  Static_pages::where('page_id',$id)->update($updateArray);
        if($id){
            return json_encode(array('1'));
        }

    }


    public function status($id){
        $last_value = Static_pages::where('page_id',$id)->first();
        if($last_value['page_is_active'] == 1){
            $newStatus = 0;
        }else{
            $newStatus = 1;
        }
        $updateArray = array('page_is_active'=>$newStatus);
        $id =  Static_pages::where('page_id',$id)->update($updateArray);
        if($id){
            return json_encode(array('1','newstatus'=>$newStatus));
        }
    }
}
