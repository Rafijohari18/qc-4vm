<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => ['auth']], function () {

    //jenis project
        Route::get('/jenis/project', 'App\Http\Controllers\Admin\JenisProjectController@index')->name('jenis.project.index');
        Route::post('/jenis/project/store', 'App\Http\Controllers\Admin\JenisProjectController@store')->name('jenis.project.store');
        Route::put('jenis/project/{id}/update', 'App\Http\Controllers\Admin\JenisProjectController@update')->name('jenis.project.update');
        Route::delete('jenis/project/delete/{id}', 'App\Http\Controllers\Admin\JenisProjectController@destroy')->name('jenis.project.destroy');
        
        Route::get('/project', 'App\Http\Controllers\Admin\ProjectController@index')->name('project.index');
        Route::get('/project/create', 'App\Http\Controllers\Admin\ProjectController@create')->name('project.create');
        Route::post('/project/store', 'App\Http\Controllers\Admin\ProjectController@store')->name('project.store');
        Route::get('project/{id}/edit', 'App\Http\Controllers\Admin\ProjectController@edit')->name('project.edit');
        Route::put('project/{id}/update', 'App\Http\Controllers\Admin\ProjectController@update')->name('project.update');
        Route::delete('project/delete/{id}', 'App\Http\Controllers\Admin\ProjectController@destroy')->name('project.destroy');        //project
      
        
        //project modul
        Route::get('project/{id}/modul', 'App\Http\Controllers\Admin\ProjectController@modul')->name('project.modul');
        Route::get('project/change/modul/status', 'App\Http\Controllers\Admin\ProjectController@changemodulStatus')->name('project.modul.status');
        Route::get('/project/modul/create/{id}', 'App\Http\Controllers\Admin\ProjectController@createModul')->name('project.modul.create');
        Route::post('/project/modul/store', 'App\Http\Controllers\Admin\ProjectController@storeModul')->name('project.modul.store');
        Route::get('project/{id}/modul/edit', 'App\Http\Controllers\Admin\ProjectController@editModul')->name('project.modul.edit');
        Route::put('project/{id}/modul/update', 'App\Http\Controllers\Admin\ProjectController@updateModul')->name('project.modul.update');
        Route::delete('project/modul/delete/{id}', 'App\Http\Controllers\Admin\ProjectController@destroyModul')->name('project.modul.destroy');
        
        //report
        Route::get('report/create', 'App\Http\Controllers\Admin\ReportController@create')->name('report.create');
        Route::post('report/store', 'App\Http\Controllers\Admin\ReportController@store')->name('report.store');
        Route::get('report/{id}/edit', 'App\Http\Controllers\Admin\ReportController@edit')->name('report.edit');
        Route::get('report/{id}/{issue_id}/reissue', 'App\Http\Controllers\Admin\ReportController@reissue')->name('report.reissue');
        Route::get('report/{id}/{issue_id}/close', 'App\Http\Controllers\Admin\ReportController@close')->name('report.close');
        Route::get('report/{id}/{issue_id}/solved', 'App\Http\Controllers\Admin\ReportController@solved')->name('report.solved');
        Route::get('report/{id}/comment', 'App\Http\Controllers\Admin\ReportController@comment')->name('report.comment');
        Route::post('report/{issue_id}/comment/post', 'App\Http\Controllers\Admin\ReportController@commentPost')->name('report.comment.post');

        Route::put('report/{id}/update', 'App\Http\Controllers\Admin\ReportController@update')->name('report.update');
        Route::put('report/{id}/update/occurences', 'App\Http\Controllers\Admin\ReportController@updateOccurences')->name('report.update.occurences');
        Route::delete('report/delete/{id}/{issue_id}', 'App\Http\Controllers\Admin\ReportController@destroy')->name('report.destroy');
        Route::get('report/remove/photo/{id}/{attachments_key}', 'App\Http\Controllers\Admin\ReportController@removePhoto')->name('report.remove.photo');
        Route::get('all/report', 'App\Http\Controllers\Admin\ReportController@all')->name('all.report');
        Route::get('my/report', 'App\Http\Controllers\Admin\ReportController@myreport')->name('my.report');
        Route::get('update/handle/{id}/{issue_id}', 'App\Http\Controllers\Admin\ReportController@updateHandle')->name('report.handled');
        Route::get('update/hold/{id}/{issue_id}', 'App\Http\Controllers\Admin\ReportController@updateHold')->name('report.hold');
        Route::put('update/fixed/{id}/{issue_id}', 'App\Http\Controllers\Admin\ReportController@fixed')->name('report.fixed');
        Route::get('report/getModul/{id}', 'App\Http\Controllers\Admin\ReportController@getModul');

        //project pic
        Route::get('list/project', 'App\Http\Controllers\Admin\ListProjectController@index')->name('list.project.pic');
        Route::get('list/project/support/{id}', 'App\Http\Controllers\Admin\ListProjectController@prevSuport')->name('project.preview.support');
        Route::get('list/project/programmer/{id}', 'App\Http\Controllers\Admin\ListProjectController@prevProgrammer')->name('project.preview.programmer');
        
        /**users */
       Route::get('/user', 'App\Http\Controllers\Admin\UsersController@index')->name('users.index');
       Route::get('/user/create', 'App\Http\Controllers\Admin\UsersController@create')->name('users.create');
       Route::post('/user/store', 'App\Http\Controllers\Admin\UsersController@store')->name('users.store');
       Route::get('/user/edit/{id}', 'App\Http\Controllers\Admin\UsersController@edit')->name('users.edit');
       Route::put('user/update/{id}', 'App\Http\Controllers\Admin\UsersController@update')->name('users.update');
       Route::put('user/status/{id}', 'App\Http\Controllers\Admin\UsersController@status')->name('users.status');
       Route::delete('user/delete/{id}', 'App\Http\Controllers\Admin\UsersController@destroy')->name('users.destroy');
       Route::get('user/profile', 'App\Http\Controllers\Admin\UsersController@profile')->name('users.profile');
       Route::post('user/update-profile/{id}', 'App\Http\Controllers\Admin\UsersController@updateProfile')->name('users.update-profile');
       Route::put('user/change-photo/{id}', 'App\Http\Controllers\Admin\UsersController@changePhoto')->name('users.change-photo');
       Route::put('user/remove-photo/{id}', 'App\Http\Controllers\Admin\UsersController@removePhoto')->name('users.remove-photo');
   
   
       //roles
        Route::get('/roles', 'App\Http\Controllers\Admin\RolesController@index')->name('roles.index');
        Route::get('/roles/create', 'App\Http\Controllers\Admin\RolesController@create')->name('roles.create');
        Route::post('/roles/store', 'App\Http\Controllers\Admin\RolesController@store')->name('roles.store');
        Route::get('roles/{id}/edit', 'App\Http\Controllers\Admin\RolesController@edit')->name('roles.edit');
        Route::put('roles/{id}/update', 'App\Http\Controllers\Admin\RolesController@update')->name('roles.update');
        Route::delete('roles/delete/{id}', 'App\Http\Controllers\Admin\RolesController@destroy')->name('roles.destroy');
        
   
        #--permission
        Route::get('/permission', 'App\Http\Controllers\Admin\PermissionController@index')->name('permission.index');
        Route::get('permission/create', 'App\Http\Controllers\Admin\PermissionController@create')->name('permission.create');
        Route::post('permission/store', 'App\Http\Controllers\Admin\PermissionController@store')->name('permission.store');
        Route::get('permission/{id}/edit', 'App\Http\Controllers\Admin\PermissionController@edit')->name('permission.edit');
        Route::put('permission/update/{id}', 'App\Http\Controllers\Admin\PermissionController@update')->name('permission.update');
        Route::delete('permission/delete/{id}', 'App\Http\Controllers\Admin\PermissionController@destroy')->name('permission.destroy');
    
        #--role has permission  
        Route::get('/role-has-permission', 'App\Http\Controllers\Admin\RoleHasPermissionController@index')->name('role-has-permission.index');
        Route::get('role-has-permission/create', 'App\Http\Controllers\Admin\RoleHasPermissionController@create')->name('role-has-permission.create');
        Route::post('role-has-permission/store', 'App\Http\Controllers\Admin\RoleHasPermissionController@store')->name('role-has-permission.store');
        Route::get('role-has-permission/{id}/edit', 'App\Http\Controllers\Admin\RoleHasPermissionController@edit')->name('role-has-permission.edit');
        Route::put('role-has-permission/update/{id}', 'App\Http\Controllers\Admin\RoleHasPermissionController@update')->name('role-has-permission.update');
        Route::delete('role-has-permission/delete/{id}', 'App\Http\Controllers\Admin\RoleHasPermissionController@destroy')->name('role-has-permission.destroy');
   
   });


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');






Route::get('/cache/clear', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    return 'DONE'; //Return anything
});
