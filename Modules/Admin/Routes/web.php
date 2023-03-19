<?php

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


Route::group(['prefix'=>ADMIN_PREFIX_KEYWORD(),'middleware'=>'web','as'=>'admin.'],function()
{
    Route::any('login', 'LoginController@login')->name('login');
    Route::any('postlogin', 'LoginController@postLogin')->name('postlogin')->middleware("throttle:3,2");
    Route::any('forgot-password-post', 'LoginController@forgotPassword')->name('forgot_password')->middleware("throttle:3,2");
    Route::any('forgot-password', 'LoginController@forgotPasswordForm')->name('forgot_password_form');
    Route::any('reset-password/{id}', 'LoginController@resetPassword')->name('reset_password');
    Route::any('update-password/{id}', 'LoginController@updatePassword')->name('update_password');


  
});

Route::group(['prefix' => ADMIN_PREFIX_KEYWORD(),'middleware'=>['auth','web','live_match'],'as'=>'admin.'], function()
{
    // Routes
    Route::get('/', 'AdminController@dashboard')->name('dashboard');

    Route::any('logout', 'LoginController@logout')->name('logout');

    // Basic Settings Routes
    Route::group(['prefix'=>BASIC_SETTING_PREFIX_KEYWORD(),'as'=>BASIC_SETTING_ROUTE_NAME()],function()
    {
       Route::any('favicon', 'BasicSettingController@favicon')->name('favicon');
       Route::any('logo', 'BasicSettingController@logo')->name('logo');
       Route::any('scripts', 'BasicSettingController@script')->name('script');
       Route::any('mail-config', 'BasicSettingController@mailConfig')->name('mail_config');
       Route::any('mail-config-update/{id}', 'BasicSettingController@mailConfigUpdate')->name('mail_config_update');
       Route::any('mail-config-sendmail/{id}', 'BasicSettingController@mailConfigSendMail')->name('mail_config_send_mail');
       Route::any('update_favicon', 'BasicSettingController@updateFavicon')->name('update_favicon');
       Route::any('update_logo', 'BasicSettingController@updateLogo')->name('update_logo');
       Route::any('basicinfo', 'BasicSettingController@basicInfo')->name('basicinfo');
       Route::any('update_basicinfo/{id}', 'BasicSettingController@updateBasicinfo')->name('update_basicinfo');
       Route::any('update_script/{id}', 'BasicSettingController@updateScript')->name('update_script');
    });


    // Admin User Routes
    Route::group(['prefix'=>ADMIN_USER_PREFIX_KEYWORD(),'as'=>ADMIN_USER_ROUTE_NAME()],function()
    {
       Route::any('create', 'LoginController@create')->name('create');
       Route::any('profile', 'AdminController@profile')->name('profile');
       Route::any('change-password', 'AdminController@changePassword')->name('change_password');
       Route::any('store', 'AdminController@store')->name('store');
       Route::any('edit/{id}', 'AdminController@edit')->name('edit');
       Route::any('update/{id}', 'AdminController@update')->name('update');
       Route::any('profile_update/{id}', 'AdminController@profile_update')->name('profile_update');
       Route::any('password_update/{id}', 'AdminController@passwordUpdate')->name('password_update');
       Route::any('destroy/{id}', 'AdminController@destroy')->name('destroy');
       Route::any('/', 'AdminController@index')->name('index');
       Route::any('any_data', 'AdminController@anyData')->name('any_data');
       Route::any('delete-all','AdminController@deleteAll')->name('delete_all');
       Route::any('status-all','AdminController@statusAll')->name('status_all');
       Route::any('single_status_change', 'AdminController@singleStatusChange')->name('single_status_change');
       
    });
   
   

    // Panel Activity Routes
    Route::group(['prefix'=>PANEL_ACTIVTY_PREFIX_KEYWORD(),'as'=>PANEL_ACTIVTY_ROUTE_NAME()],function()
    {
       Route::any('create', 'PanelActivityController@create')->name('create');
       Route::any('store', 'PanelActivityController@store')->name('store');
       Route::any('edit/{id}', 'PanelActivityController@edit')->name('edit');
       Route::any('update/{id}', 'PanelActivityController@update')->name('update');
       Route::any('destroy/{id}', 'PanelActivityController@destroy')->name('destroy');
       Route::any('/', 'PanelActivityController@index')->name('index');
       Route::any('all-notifications', 'PanelActivityController@allNotifications')->name('all_notifications');
       Route::any('/see-detail/{slug}', 'PanelActivityController@seeDetail')->name('see_detail');
       Route::any('any_data', 'PanelActivityController@anyData')->name('any_data');
       Route::any('delete-all','PanelActivityController@deleteAll')->name('delete_all');
       Route::any('status-all','PanelActivityController@statusAll')->name('status_all');
       Route::any('single_status_change', 'PanelActivityController@singleStatusChange')->name('single_status_change');
       
    });

    // Admin Modules Routes
    Route::group(['prefix'=>MODULE_PREFIX_KEYWORD(),'as'=>MODULE_ROUTE_NAME()],function()
    {
       Route::any('create', 'ModuleController@create')->name('create');
       Route::any('store', 'ModuleController@store')->name('store');
       Route::any('edit/{id}', 'ModuleController@edit')->name('edit');
       Route::any('update/{id}', 'ModuleController@update')->name('update');
       Route::any('destroy/{id}', 'ModuleController@destroy')->name('destroy');
       Route::any('/', 'ModuleController@index')->name('index');
       Route::any('any_data', 'ModuleController@anyData')->name('any_data');
       Route::any('delete-all','ModuleController@deleteAll')->name('delete_all');
       Route::any('status-all','ModuleController@statusAll')->name('status_all');
       Route::any('single_status_change', 'ModuleController@singleStatusChange')->name('single_status_change');
       
    });

    // Admin Right Routes
    Route::group(['prefix'=>RIGHT_PREFIX_KEYWORD(),'as'=>RIGHT_ROUTE_NAME()],function()
    {
       Route::any('create', 'RightController@create')->name('create');
       Route::any('store', 'RightController@store')->name('store');
       Route::any('edit/{id}', 'RightController@edit')->name('edit');
       Route::any('update/{id}', 'RightController@update')->name('update');
       Route::any('destroy/{id}', 'RightController@destroy')->name('destroy');
       Route::any('/', 'RightController@index')->name('index');
       Route::any('any_data', 'RightController@anyData')->name('any_data');
       Route::any('delete-all','RightController@deleteAll')->name('delete_all');
       Route::any('status-all','RightController@statusAll')->name('status_all');
       Route::any('single_status_change', 'RightController@singleStatusChange')->name('single_status_change');
       
    });

  

    // EMail Template Routes
    Route::group(['prefix'=>EMAIL_TEMPLATE_PREFIX_KEYWORD(),'as'=>EMAIL_TEMPLATE_ROUTE_NAME()],function()
    {
       Route::any('create', 'EmailTemplateController@create')->name('create');
       Route::any('store', 'EmailTemplateController@store')->name('store');
       Route::any('edit/{id}', 'EmailTemplateController@edit')->name('edit');
       Route::any('update/{id}', 'EmailTemplateController@update')->name('update');
       Route::any('destroy/{id}', 'EmailTemplateController@destroy')->name('destroy');
       Route::any('/', 'EmailTemplateController@index')->name('index');
       Route::any('any_data', 'EmailTemplateController@anyData')->name('any_data');
       Route::any('delete-all','EmailTemplateController@deleteAll')->name('delete_all');
       Route::any('status-all','EmailTemplateController@statusAll')->name('status_all');
       Route::any('email-template/preview/{id}','EmailTemplateController@preview')->name('preview');
       Route::any('single_status_change', 'EmailTemplateController@singleStatusChange')->name('single_status_change');
       
    });

   
    // Contact  Routes
    Route::group(['prefix'=>CONTACT_PREFIX_KEYWORD(),'as'=>CONTACT_ROUTE_NAME()],function()
    {
       Route::any('create', 'ContactController@create')->name('create');
       Route::any('store', 'ContactController@store')->name('store');
       Route::any('edit/{id}', 'ContactController@edit')->name('edit');
       Route::any('update/{id}', 'ContactController@update')->name('update');
       Route::any('destroy/{id}', 'ContactController@destroy')->name('destroy');
       Route::any('set_main_contact/{id}', 'ContactController@setMainContact')->name('set_main_contact');
       Route::any('/', 'ContactController@index')->name('index');
       Route::any('any_data', 'ContactController@anyData')->name('any_data');
       Route::any('delete-all','ContactController@deleteAll')->name('delete_all');
       Route::any('status-all','ContactController@statusAll')->name('status_all');
       Route::any('single_status_change', 'ContactController@singleStatusChange')->name('single_status_change');
       
    });

    // File Management  Routes
    Route::group(['prefix'=>FILE_PREFIX_KEYWORD(),'as'=>FILE_ROUTE_NAME()],function()
    {
       Route::any('/', 'FileController@index')->name('index');

       Route::any('store', 'FileController@store')->name('store');
       Route::any('store-folder', 'FileController@storeFolder')->name('store_folder');
       Route::any('store-sub-folder', 'FileController@storeSubFolder')->name('store_sub_folder');
       Route::any('store-sub-file', 'FileController@storeSubFile')->name('store_sub_file');
       Route::any('delete-file', 'FileController@deleteFile')->name('delete_file');
       Route::any('delete-folder', 'FileController@deleteFolder')->name('delete_folder');
       Route::any('store-file', 'FileController@storeFile')->name('store_file');
       Route::any('add-sub-folder/{parent_id}', 'FileController@addSubFolder')->name('add_sub_folder');
       Route::any('edit/{id}', 'FileController@edit')->name('edit');
       Route::any('update/{id}', 'FileController@update')->name('update');
       Route::any('destroy/{id}', 'FileController@destroy')->name('destroy');
       Route::any('delete-all','FileController@deleteAll')->name('delete_all');
       Route::any('status-all','FileController@statusAll')->name('status_all');
       Route::any('single_status_change', 'FileController@singleStatusChange')->name('single_status_change');
       
    });

    // Support  Routes
    Route::group(['prefix'=>SUPPORT_PREFIX_KEYWORD(),'as'=>SUPPORT_ROUTE_NAME()],function()
    {
       Route::any('create', 'SupportController@create')->name('create');
       Route::any('store', 'SupportController@store')->name('store');
       Route::any('edit/{id}', 'SupportController@edit')->name('edit');
       Route::any('view/{id}', 'SupportController@view')->name('view');
       Route::any('update/{id}', 'SupportController@update')->name('update');
       Route::any('destroy/{id}', 'SupportController@destroy')->name('destroy');
       Route::any('/', 'SupportController@index')->name('index');
       Route::any('/mark-all-as-read', 'SupportController@markAllAsRead')->name('mark_all_as_read');
       Route::any('any_data', 'SupportController@anyData')->name('any_data');
       Route::any('delete-all','SupportController@deleteAll')->name('delete_all');
       Route::any('status-all','SupportController@statusAll')->name('status_all');
       Route::any('single_status_change', 'SupportController@singleStatusChange')->name('single_status_change');
       
    });

   
   

    // Search  Routes
    Route::group(['prefix'=>SEARCH_PREFIX_KEYWORD(),'as'=>SEARCH_ROUTE_NAME()],function()
    {
       Route::any('/', 'DashboardController@search')->name('search');
       Route::any('/any_data/{model}', 'DashboardController@anyData')->name('any_data');
       
    });


    
});

