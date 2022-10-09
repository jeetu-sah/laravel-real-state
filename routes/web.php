<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:cache');
     $exitCode = Artisan::call('cache:clear');
    // return what you want
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('removeHoldStatus','Home@removeHoldStatus');
//Route::group(['middleware'=>['web']] , function(){
Route::name('common.')->group(function () {
    Route::get('common/printInvoice/{plotId}', 'Home@printInvoice');
    Route::get('common/invoice/{paymentId}', 'Home@invoice');
    Route::get('find_states', 'Home@states')->name('find_states');
    Route::get('calculateCommission', 'Home@calculateCommission')->name('calculateCommission');
    Route::get('find_city', 'Home@cities')->name('find_city');
    Route::post('saveStatusOfplots', 'Home@saveStatusOfplots')->name('saveStatusOfplots');
});
//});

Route::get('admin-login', 'Auth\LoginController@index');
//Route::resource('login', 'Auth\LoginController');
Route::get("logout" , "Admin\Admin@logout");

Route::group(['middleware'=>['auth']] , function(){
  /*Manage customer routes*/
  Route::get('customer/{page}/{p1?}',"Admin\Customer@page");
  Route::name('customer.')->group(function () {
    Route::post('createCustomer',"Admin\Customer@createCustomer")->name('createCustomer');
    Route::post('editCustomer',"Admin\Customer@editCustomer")->name('editCustomer');
  });
  
  /*End*/  
  /*manage Admin Roles routes*/

    /*admin routes*/
    Route::get('markNotification', 'Home@markNotification')->name('markNotification');
    Route::get('admin/roles/{page?}/{p1?}',"Admin\AdminRoles@page");

    Route::name('admin.roles.')->group(function () {
        Route::get('allocate_deallocate_all_roles',"Admin\AdminRoles@allocate_deallocate_all_roles")->name('allocate_deallocate_all_roles');
        Route::get('allocate_deallocate_role_to_user',"Admin\AdminRoles@allocate_deallocate_role_to_user")->name('allocate_deallocate_role_to_user');
        Route::get('users_list',"Admin\AdminRoles@users_list")->name('users_list');
        Route::get('admin_users_list',"Admin\AdminRoles@admin_users_list")->name('admin_users_list');

        Route::get('roles_list',"Admin\AdminRoles@roles_list")->name('roles_list');
        Route::get('role_permission',"Admin\AdminRoles@role_permission")->name('role_permission');
        Route::get('assign_role_permission',"Admin\AdminRoles@assign_role_permission")->name('assign_role_permission');
        Route::get('allocate_deallocate_permissin_to_roles',"Admin\AdminRoles@allocate_deallocate_permissin_to_roles")->name('allocate_deallocate_permissin_to_roles');
        Route::get('allocate_deallocate_single_permissin_to_roles',"Admin\AdminRoles@allocate_deallocate_single_permissin_to_roles")->name('allocate_deallocate_single_permissin_to_roles');
        
        Route::get('permission_list',"Admin\AdminRoles@permission_list")->name('permission_list');
        Route::get('user_roles',"Admin\AdminRoles@user_roles")->name('user_roles');
        Route::get('user_permission',"Admin\AdminRoles@user_permission")->name('user_permission');
        Route::get('allocate_deallocate_permissin_to_user',"Admin\AdminRoles@allocate_deallocate_permissin_to_user")->name('allocate_deallocate_permissin_to_user');

        Route::post('save_roles',"Admin\AdminRoles@save_roles")->name('save_roles');
        Route::post('save_permission',"Admin\AdminRoles@save_permission")->name('save_permission');
    
    });
    /*End*/


    //plot routes start
    Route::prefix('admin/plot/')->name('admin.plot.')->group(function(){
        Route::get('plot-list',"Admin\PlotController@plotList")->name('plot-list');
        Route::get('plot-detail/{plotid}','Admin\PlotController@plotDetail')->name('plot-detail');
        Route::get('/{blockid}','Admin\PlotController@index')->name('index');
        //plot payment 
         Route::prefix('payment')->name('payment.')->group(function(){
            Route::get('add/{plotid}',"Admin\PlotPaymentController@index")->name('add');
         });
    });
   /*manage admin routes*/ 
   Route::get('admin/ajax/feature_list',"Admin\AdminAjax@feature_list");
   /*Route plots list start*/
   Route::get('admin/plots/removePayemntHistory/{paymentID}',"Admin\PlotPayment@removePayemntHistory");
   Route::get('admin/plots/removePlot/{plotID}',"Admin\Rooms@removePlot");
   Route::get('admin/plots/{p1}',"Admin\Rooms@index");
   Route::get('admin/plots/{page}/{p1}',"Admin\Rooms@pages");
   Route::get('admin/users_allocation',"Admin\UsersRoles@index");
   Route::get('admin/users_allocation/{page}/{p1?}',"Admin\UsersRoles@page");

   Route::get('admin/dashboard/{latest_payment}',"Admin\Dashboard@page");
   
   Route::get('admin/partner/{page?}/{p1?}',"Admin\Admin@partner");
   Route::get('admin/{page?}/{p1?}',"Admin\Admin@page");
   /*End plots for get methd*/
   /*admin routes*/
    Route::name('admin.')->group(function () {
        /*Manage Dashboard Routes */
        Route::name('dashboard.')->group(function () {
            Route::get('latest_payment',"Admin\Dashboard@latestPayment")->name('latest_payment');
            Route::get('plots',"Admin\Dashboard@plots")->name('plots');
        });
        /*End*/
        /*manage rooms routes script start*/
          Route::name('plots.')->group(function () {
            
            Route::get('setEmiStatus',"Admin\Rooms@setEmiStatus")->name('setEmiStatus');
            Route::get('setPriority',"Admin\Rooms@setPriority")->name('setPriority');
            Route::get('setBookingStatus',"Admin\Rooms@setBookingStatus")->name('setBookingStatus');
            Route::get('roomsList',"Admin\Rooms@roomsList")->name('roomsList');
            Route::post('saveRooms',"Admin\Rooms@saveRooms")->name('saveRooms');
            Route::post('savePlotPayment',"Admin\Rooms@savePlotPayment")->name('savePlotPayment');
            Route::post('editPlotPaymentDetail',"Admin\Rooms@editPlotPaymentDetail")->name('editPlotPaymentDetail');
            /*plot payment controller payment*/
           
            Route::post('editPlotPaymentHistory',"Admin\PlotPayment@editPlotPaymentHistory")->name('editPlotPaymentHistory');
            Route::post('addPlotPaymentHistory',"Admin\PlotPayment@addPlotPaymentHistory")->name('addPlotPaymentHistory');

            /*End*/
            Route::post('editPlot',"Admin\Rooms@editPlot")->name('editPlot');
			      Route::post('savePlotsNumber',"Admin\Rooms@savePlotsNumber")->name('savePlotsNumber');
			      Route::post('saveNewplots',"Admin\Rooms@saveNewplots")->name('saveNewplots');
			      Route::post('editNewplots',"Admin\Rooms@editNewplots")->name('editNewplots');
			      Route::get('getPlotsDetails',"Admin\Rooms@getPlotsDetails")->name('getPlotsDetails');
			     
          });
        /*End*/
        /*manage rooms routes script start*/
          Route::name('userAllocation.')->group(function () {
            Route::get('headAgentList',"Admin\UsersRoles@headAgentList")->name('headAgentList');
            Route::get('agentAllocation',"Admin\UsersRoles@agentAllocation")->name('agentAllocation');
            Route::get('agentAllocateToHeadagent',"Admin\UsersRoles@agentAllocateToHeadagent")->name('agentAllocateToHeadagent');
            Route::get('agentAllocateToHeadagent',"Admin\UsersRoles@agentAllocateToHeadagent")->name('agentAllocateToHeadagent');
          });
        /*End*/

        Route::get('allocate_deallocate_society_to_partner',"Admin\Admin@allocate_deallocate_society_to_partner")->name('allocate_deallocate_society_to_partner');
        Route::get('removeSocietyImage/{id}',"Admin\Admin@removeSocietyImage");
        /*datatable routes list*/
        Route::get('partnerlist',"Admin\AdminAjax@partnerlist")->name('partnerlist');
        Route::get('scietyList',"Admin\AdminAjax@scietyList")->name('scietyList');
        Route::get('usersList',"Admin\AdminAjax@usersList")->name('usersList');
        /*End */
        Route::post('change_credential',"Admin\Admin@change_credential")->name('change_credential');
        Route::post('uploadSocietyImage',"Admin\Admin@uploadSocietyImage")->name('uploadSocietyImage');
        Route::post('add_partners',"Admin\Admin@add_partners")->name('add_partners');
        Route::post('edit_partners',"Admin\Admin@edit_partners")->name('edit_partners');
        Route::post('add_society',"Admin\Admin@add_society")->name('add_society');
        Route::post('edit_society',"Admin\Admin@edit_society")->name('edit_society');
   });
   /*End*/
   //Route::post('door-plus-admin/remove_category/{catid}',"Admin\Admin@remove_category");
});

Route::group(['middleware'=>['auth']] , function(){
    Route::get('agent/{page?}/{p1?}',"Partner\Agent@page");
    Route::get('head_agent/{page?}/{p1?}',"Partner\HeadAgent@page");
    Route::get('partner/{page?}/{p1?}',"Partner\Partners@page");

    Route::name('partner.')->group(function () {
        /*partner routes start*/
          Route::get('blockList',"Partner\Partners@blockList")->name('blockList');
          Route::get('plotsNumberList',"Partner\Partners@plotNumberList")->name('plotsNumberList');
          Route::post('add_agents',"Partner\Partners@add_agents")->name('add_agents');
        /*End*/
    });
});





Route::get('/location/{location}', 'Home@location');
Route::get('/search', 'Home@search');
Route::get('/{page?}/{param?}', 'Home@index');
/*End*/

Auth::routes();


