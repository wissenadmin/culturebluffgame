
<!-- Form validations -->              
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add Users
            </header>
            <div class="panel-body">
                <div class="form">
                <?php $success =  Session::get('success');?>
                @if(!empty($success))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ $success }}
                </div>
                @endif
                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $error }}</div>
                    @endforeach
                @endif
               
                    <!-- <form action="" method="get" id="feedback_form" class="form-validate form-horizontal" novalidate="novalidate"> -->
                    {!! Form::open(['role' => 'form','method'=>'post','class'=>'form-validate form-horizontal','id'=>'feedback_form','novalidate'=>'novalidate']) !!}

                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="cname">First Name <span class="required">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" required="" minlength="5" name="first_name" id="cname" class="form-control" value="{{old('first_name')}}" placeholder="First Name">
                                
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="cname">Middle Name <span class="required">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" required="" value="{{old('middle_name')}}" minlength="5" name="middle_name" id="cname" class="form-control" placeholder="Middle Name">
                                
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="cname">Last Name <span class="required">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" required="" value="{{old('last_name')}}" minlength="5" name="last_name" id="cname" class="form-control" placeholder="Last Name">
                                
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="cname">Company Name <span class="required">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" required="" value="{{old('company_name')}}"  minlength="5" name="company_name" id="cname" class="form-control" placeholder="Company Name">
                                
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="cname">Account Type <span class="required">*</span></label>
                            <div class="col-lg-10">
                                <!-- <input type="text" required="" value="{{old('company_name')}}"  minlength="5" name="company_name" id="cname" class="form-control" placeholder="Company Name"> -->
                                <select name="user_type" class="form-control" >
                                    <option value="1">Individual User</option>
                                    <option value="2">Individual User</option>
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="cname">Designation <span class="required">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" required="" value="{{old('designation')}}" minlength="5" name="designation" id="cname" class="form-control" placeholder="Designation">
                                
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="cname">Sector <span class="required">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" required="" value="{{old('sector')}}" minlength="5" name="sector" id="cname" class="form-control" placeholder="Sector">
                                
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="cname">Country <span class="required">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" required="" minlength="5" name="country_id" id="cname" class="form-control" placeholder="Country">
                                
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="cname">Company Website <span class="required">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" required="" value="{{old('company_website')}}" minlength="5" name="company_website" id="cname" class="form-control" placeholder="Company Website">
                            </div>
                        </div>

                       
                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="cemail">E-Mail <span class="required">*</span></label>
                            <div class="col-lg-10">
                                <input type="email"  required="" value="{{old('email')}}" name="email" id="cemail" class="form-control" placeholder="Email">
                               
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="cemail">UserName <span class="required">*</span></label>
                            <div class="col-lg-10">
                                <input type="text"  required="" value="{{old('user_username')}}" name="user_username" id="cemail" class="form-control" placeholder="Username">
                               
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="curl">Password</label>
                            <div class="col-lg-10">
                                <input type="password" name="password" id="curl" class="form-control valid">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label col-lg-2" for="curl">Confirm Password</label>
                            <div class="col-lg-10">
                                <input type="password" name="password_confirmation" id="curl" class="form-control valid">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-primary">Add User</button>
                                <button type="button" class="btn btn-default">Cancel</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </section>
    </div>
</div>


<!-- page end-->
