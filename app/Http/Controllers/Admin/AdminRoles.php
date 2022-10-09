<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Str;
use Auth;
use DB;
use App\Booking;
use Freshbitsweb\Laratables\Laratables;
use sHelper;
use Carbon\Carbon;
use App\MainService;
use App\CommonFeatures;
use App\CountriesCities;
use App\User;
use App\HotelRestaurant;	
use App\Gallery;
use App\Models\Role;
use App\Models\Permission;


class AdminRoles extends Controller
{
    public function page($page = "users_list" , $p1 = NULL){
        $data['title'] = "Lakhmanis - Admin | ".$page;
        /*manage roles */
        $data['notifications'] = auth()->user()->unreadNotifications;
        if($page == "role_permission"){
            $data['role_detail'] = Role::where([['name','=',$p1]])->first();

            /* echo "<pre>";
            print_r($data['role_detail']);exit; */
        }
        /*add role page */
        if($page == "add_roles"){
            $data['role_detail'] = NULL;
            if($p1 != NULL){
                $data['role_detail'] = Role::find($p1);
            }
        }
        /*End*/
        if($page == "add_permission"){
            $data['pemisison_detail']  = NULL;
            if($p1 != NULL){
                $data['pemisison_detail'] = Permission::find($p1);
            }
        }
        /*End*/
        /*user permission and roles*/
        if($page == "user_permission"){
            $data['sub_page'] = NULL;
            $data['user_detail'] = User::find($p1);
            if(request()->has('page')){
                if(request()->page == "roles"){
                    $data['sub_page'] = "user_roles";
                    
                }
                if(request()->page == "user_permission"){
                     $data['sub_page'] = "user_permission";
                }
            }
        }
        /*End*/
        
		if(! view()->exists("admin.roles.$page")){
           return view('admin.404');
        }
        return view("admin.roles.$page")->with($data);
    }

    /*save roles */
    public function save_roles(){
        $validatedData = request()->validate([
            'role_name' =>'required',
            'display_name' =>'required',
        ]);
        $response = Role::updateOrCreate(['id'=>request()->edit] , ['name'=>str::slug(request()->role_name, '-'),
                                                       'description'=>request()->description, 
                                                       'display_name'=>request()->display_name]);
        if($response){
            return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Role save Successfully  !!! </div>"]); 
        }else{
            return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
        }
    }
    /*End*/

    /*Save permission*/
    public function save_permission(){
        $validatedData = request()->validate([
            'name' =>'required',
            'display_name' =>'required',
        ]);
        $response = Permission::updateOrCreate(['id'=>request()->edit] , ['name'=>str::slug(request()->name, '-'),
                                                       'description'=>request()->description, 
                                                       'display_name'=>request()->display_name]);
        if($response){
            return redirect()->back()->with(["msg"=>"<div class='notice notice-success notice'><strong>Success </strong>  Role save Successfully  !!! </div>"]); 
        }else{
            return redirect()->back()->with(["msg"=>"<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>"]); 
        }
    }
    /*End*/


    public function users_list(){
        $columns = [0=>'id',1=>'id' , 2=>'f_name',3=>'mobile',4=>'email'];
        $dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
        else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $users_list = [];
        $users = User::all();
        //$users = User::where([['hidden_user','=',0]])->get();
        if($users->count() > 0){
            foreach($users as $key=>$user){
                $user_id = sHelper::user_id($user->id);
                $userTab = '<a href="'.url("admin/roles/user_permission/$user->id?page=roles").'">'.$user_id.'</a>';
                $user_arr = [];
				$user_arr['sn'] = $key + 1;
				$user_arr['userid'] = $userTab;
				$user_arr['name'] = sHelper::getFullName($user);
				$user_arr['mobile'] = $user->mobile;
				$user_arr['email'] = $user->email;
                $users_list[] = $user_arr;
            }
        }
        $json_data = array( "draw" => intval(request()->input('draw')),  
                            "recordsTotal" => intval($users->count()),  
                            "recordsFiltered" => intval($users->count()), 
                            "data"=> $users_list   
                         );
        return json_encode($json_data); exit;
    }


    public function admin_users_list(){
        /*This function is used to dispplay users to admin */
        $columns = [0=>'id',1=>'id' , 2=>'f_name',3=>'mobile',4=>'email'];
        $dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
        else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $users_list = [];
        //$users = User::all();
        $users = User::where([['hidden_user','=',0], ['id','!=',Auth::user()->id]])->get();
        if($users->count() > 0){
            foreach($users as $key=>$user){
                $user_id = sHelper::user_id($user->id);
                $userTab = '<a href="'.url("admin/roles/user_permission/$user->id?page=roles").'">'.$user_id.'</a>';
                $user_arr = [];
				$user_arr['sn'] = $key + 1;
				$user_arr['userid'] = $userTab;
				$user_arr['name'] = sHelper::getFullName($user);
				$user_arr['mobile'] = $user->mobile;
				$user_arr['email'] = $user->email;
				$user_arr['loginid'] = $user->login_id;
                $users_list[] = $user_arr;
            }
        }
        $json_data = array( "draw" => intval(request()->input('draw')),  
                            "recordsTotal" => intval($users->count()),  
                            "recordsFiltered" => intval($users->count()), 
                            "data"=> $users_list   
                         );
        return json_encode($json_data); exit;
    }
    

    public function permission_list(){
        $columns = [0=>'id',1=>'name',2=>'display_name'];
        $dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
        else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $permission_list = [];
        $permissions = Permission::all();
        if($permissions->count() > 0){
            foreach($permissions as $key=>$permission){
                $userTab = '<a href="'.url("admin/roles/add_permission/$permission->id").'">'.$permission->name.'</a>';
                $permission_arr = [];
				$permission_arr['sn'] = $key + 1;
				$permission_arr['name'] = $userTab;
				$permission_arr['display_name'] = $permission->display_name;
				$permission_arr['description'] = $permission->description;
                $permission_list[] = $permission_arr;
            }
        }
        $json_data = array( "draw" => intval(request()->input('draw')),  
                            "recordsTotal" => intval($permissions->count()),  
                            "recordsFiltered" => intval($permissions->count()), 
                            "data"=> $permission_list   
                         );
        return json_encode($json_data); exit;
    }

    public function roles_list(){
        $columns = [0=>'id',1=>'name',2=>'display_name'];
        $dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
        else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $role_list = [];
        $roles = Role::all();
        if($roles->count() > 0){
            foreach($roles as $key=>$role){
                $userTab = '<a href="'.url("admin/roles/role_permission/$role->name").'">'.$role->name.'</a>';
                $role_arr = [];
				$role_arr['sn'] = $key + 1;
				$role_arr['name'] = $userTab;
				$role_arr['display_name'] = $role->display_name;
				$role_arr['description'] = $role->description;
                $role_list[] = $role_arr;
            }
        }
        $json_data = array( "draw" => intval(request()->input('draw')),  
                            "recordsTotal" => intval($roles->count()),  
                            "recordsFiltered" => intval($roles->count()), 
                            "data"=> $role_list   
                         );
        return json_encode($json_data); exit;
    }

    /*in this function we have show all permissions which has activated or not activated for  users*/
    public function role_permission(){
       $columns = [0=>'id',1=>'name',2=>'display_name'];
        $dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
        else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $permission_list = [];
        $permissions = Permission::all();
        if($permissions->count() > 0){
            foreach($permissions as $key=>$permission){
                $userTab = '<a href="'.url("admin/roles/role_permission/$permission->name").'">'.$permission->name.'</a>';
                $permission_arr = [];
				$permission_arr['sn'] = $key + 1;
				$permission_arr['name'] = $userTab;
				$permission_arr['display_name'] = $permission->display_name;
				$permission_arr['description'] = $permission->description;
                $permission_list[] = $permission_arr;
            }
        }
        $json_data = array( "draw" => intval(request()->input('draw')),  
                            "recordsTotal" => intval($permissions->count()),  
                            "recordsFiltered" => intval($permissions->count()), 
                            "data"=> $permission_list   
                         );
        return json_encode($json_data); exit;
    }
    /*End*/


    /*this function we are use to display permission list for roles which permission has assign to roles*/
    public function assign_role_permission(){
        $columns = [0=>'id',1=>'name',2=>'display_name'];
        $dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
        else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $permission_list = [];
        $permissions = Permission::all();
        if($permissions->count() > 0){
            $roll_id = request()->role_id;
            foreach($permissions as $key=>$permission){
                $selected_status = NULL;
                $check_exists = DB::table('permission_role')->where([['role_id','=',$roll_id],['permission_id','=',$permission->id]])->first();
                if($check_exists != NULL){
                    $selected_status = "Checked";
                } 
                $checkbox = '<div class="form-group">
                            <input type="checkbox" class="select_checkbox_permission" name="permision[]" value="'.$permission->id.'" '.$selected_status.' />
                        </div>';
                $userTab = $permission->name;
                $permission_arr = [];
				$permission_arr['sn'] = $checkbox;
				$permission_arr['name'] = $userTab;
				$permission_arr['display_name'] = $permission->display_name;
				$permission_arr['description'] = $permission->description;
                $permission_list[] = $permission_arr;
            }
        }
        $json_data = array( "draw" => intval(request()->input('draw')),  
                            "recordsTotal" => intval($permissions->count()),  
                            "recordsFiltered" => intval($permissions->count()), 
                            "data"=> $permission_list   
                         );
        return json_encode($json_data); exit;
    }
    /*End*/

   /*this function is used for display roles list and show how many roles assign to users*/
    public function user_roles(){
        $columns = [0=>'id',1=>'name',2=>'display_name'];
        $dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
        else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $role_list = [];
        $roles = Role::all();
        $user_id = request()->input('userid');
        if($roles->count() > 0){
            foreach($roles as $key=>$role){
                $selected_status = NULL;
                $check_exists = DB::table('role_user')->where([['role_id','=',$role->id] , ['user_id','=',$user_id]])->first();
                if($check_exists != NULL){
                    $selected_status = "Checked";
                }
                /*check checkbox selected status*/
                $checkbox = '<div class="form-group">
                                <input type="checkbox" class="select_checkbox" name="role_id[]" value="'.$role->id.'" '.$selected_status.' />
                            </div>';
                $userTab = '<a href="'.url("admin/roles/role_permission/$role->name").'">'.$role->name.'</a>';
                $role_arr = [];
				$role_arr['sn'] = $checkbox;
				$role_arr['name'] = $userTab;
				$role_arr['display_name'] = $role->display_name;
				$role_arr['description'] = $role->description;
                $role_list[] = $role_arr;
            }
        }
        $json_data = array( "draw" => intval(request()->input('draw')),  
                            "recordsTotal" => intval($roles->count()),  
                            "recordsFiltered" => intval($roles->count()), 
                            "data"=> $role_list   
                         );
        return json_encode($json_data); exit;
    }
/*End*/

/*this function is use d for get and display userd assign permission */
    public function user_permission(){
        $columns = [0=>'id',1=>'name',2=>'display_name'];
        $dir = request()->input('order.0.dir');
		if($dir == "asc"){ $dir = "ASC"; }
        else{ $dir = "DESC"; }
        $order = $columns[request()->input('order.0.column')];
        $permission_list = [];
        $permissions = Permission::all();
        $user_id = request()->input('userid');
        if($permissions->count() > 0){
            foreach($permissions as $key=>$permission){
                $selected_status = NULL;
                $check_exists = DB::table('permission_user')->where([['permission_id','=',$permission->id] , ['user_id','=',$user_id]])->first();
                if($check_exists != NULL){
                    $selected_status = "Checked";
                }
                
                $checkbox = '<div class="form-group">
                                <input type="checkbox" class="select_permission" name="permissions[]" value="'.$permission->id.'" '.$selected_status.' />
                            </div>';
                $userTab = '<a href="'.url("admin/roles/role_permission/$permission->name").'">'.$permission->name.'</a>';
                $permission_arr = [];
				$permission_arr['sn'] = $checkbox;
				$permission_arr['name'] = $userTab;
				$permission_arr['display_name'] = $permission->display_name;
				$permission_arr['description'] = $permission->description;
                $permission_list[] = $permission_arr;
            }
        }
        $json_data = array( "draw" => intval(request()->input('draw')),  
                            "recordsTotal" => intval($permissions->count()),  
                            "recordsFiltered" => intval($permissions->count()), 
                            "data"=> $permission_list   
                         );
        return json_encode($json_data); exit;
    }

/*End*/




    /*allocate or deallocate all roles to user*/
    public function allocate_deallocate_all_roles(){
        if(!empty(request()->userid)){
            /*find user details*/
            $userDetail = User::find(request()->userid);
            /*End*/
            if($userDetail != NULL){
                /*allocate roles*/
                if(request()->roles == "allocate"){
                    $allRoles = Role::all();
                    foreach($allRoles as $role){
                        $userDetail->attachRole($role);
                    }
                }
                /*End*/
                /*de allocate roles*/
                if(request()->roles == "deallocate"){
                    $allRoles = Role::all();
                    foreach($allRoles as $role){
                        $userDetail->detachRole($role);
                    }
                }
                /*End*/
                
            }else{}
    
        }else{
           echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit;
        }
    }


    /*allocate and deallocate role to users*/
    public function allocate_deallocate_role_to_user(){
        if(!empty(request()->userid)){
            /*find user details*/
            $userDetail = User::find(request()->userid);
            /*End*/
            if($userDetail != NULL){
                /*allocate roles*/
                $role = Role::find(request()->rollid);
                if(request()->roles == "allocate"){
                    $userDetail->attachRole($role);
                    echo "Success Roles assign successfully !!!";exit;
                }
                /*End*/
                /*de allocate roles*/
                if(request()->roles == "deallocate"){
                    $userDetail->detachRole($role);
                     echo "Success , Roles Remove successfully !!!";exit;
                }
                /*End*/
                
            }else{
                   echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit;
            }
    
        }else{
           echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit;
        }
    }

    /*End*/


    /*this sfunction used for allocate or deallocate permisison to users*/
    public function allocate_deallocate_permissin_to_user(){
         if(!empty(request()->userid)){
            /*find user details*/
            $userDetail = User::find(request()->userid);
            /*End*/
            if($userDetail != NULL){
                /*allocate roles*/
                $permission = Permission::find(request()->permissionid);
                if(request()->permission == "allocate"){
                    $userDetail->attachPermission($permission);
                }
                /*End*/
                /*de allocate roles*/
                if(request()->permission == "deallocate"){
                    $userDetail->detachPermission($permission);
                }
                /*End*/
                 echo "<div class='notice notice-success notice'><strong>Success </strong> Roles assign sucessfully  !!! </div>";exit;
                
            }else{
                   echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit;
            }
    
        }else{
           echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit;
        }
    }
    /*End*/


    /* This function is used for allocate or dellocate permisison to users*/
    public function allocate_deallocate_permissin_to_roles(){
        if(!empty(request()->rollid)){
            /*find roles*/
                $role = Role::find(request()->rollid);
                if($role  != NULL){
                    /*find all permission*/
                    $allPermission = Permission::all();
                    if($allPermission->count() > 0){
                        foreach($allPermission as $permission){
                            if(request()->permission == "allocate"){
                                $role->attachPermission($permission);
                            }
                            if(request()->permission == "deallocate"){
                                $role->detachPermission($permission);
                            }
                        }
                        if(request()->permission == "deallocate"){
                            echo "<div class='notice notice-success notice'><strong>Success </strong> All permission deallocated Successfully !!! </div>";exit;  
                        }
                        if(request()->permission == "allocate"){
                            echo "<div class='notice notice-success notice'><strong>Success </strong> All permission allocated Successfully !!! </div>";exit;  
                        }
                    }else{
                        echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit;  
                    }
                    /*End*/
                }else{
                    echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit;  
                }
            /*End*/
        }else{
            echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit; 
        }
  
    }
    /*End*/


    /*Allocate deallocate permission to login*/
    public function allocate_deallocate_single_permissin_to_roles(){
        if(!empty(request()->permission_id)){
            if(!empty(request()->rollid)){
                $role = Role::find(request()->rollid);
                $permission = Permission::find(request()->permission_id);
                if(request()->permission == "allocate"){
                     $role->attachPermission($permission);
                }
                if(request()->permission == "deallocate"){
                    $role->detachPermission($permission);
                }
            }else{
                echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit; 
            }
        }else{
            echo "<div class='notice notice-danger notice'><strong>Wrong </strong>  Something , went wrong please try again !!! </div>";exit; 
        }
        
    }
    /*End*/

}
