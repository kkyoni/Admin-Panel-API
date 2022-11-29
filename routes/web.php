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
Route::group(['middleware' => 'preventBackHistory'],function(){
	Route::get('/', 'HomeController@welcome')->name('welcome');
	Route::get('admin','Admin\Auth\LoginController@showLoginForm')->name('admin.showLoginForm');
	Route::get('admin/login','Admin\Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('admin/login', 'Admin\Auth\LoginController@login');
	Route::get('admin/resetPassword','Admin\Auth\PasswordResetController@showPasswordRest')->name('admin.resetPassword');
	Route::post('admin/sendResetLinkEmail', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.sendResetLinkEmail');
	Route::get('admin/find/{token}', 'Admin\Auth\PasswordResetController@find')->name('admin.find');
	Route::post('admin/create', 'Admin\Auth\PasswordResetController@create')->name('admin.sendLinkToUser');
	Route::post('admin/reset', 'Admin\Auth\PasswordResetController@reset')->name('admin.resetPassword_set');
	
	Route::group(['prefix' => 'admin','middleware'=>'Admin','namespace' => 'Admin','as' => 'admin.'],function(){

		Route::get('/dashboard','MainController@dashboard')->name('dashboard');
		Route::get('/logout','Auth\LoginController@logout')->name('logout');

		//====================> Update Admin Profile =========================
		Route::get('/profile','UsersController@updateProfile')->name('profile');
		Route::post('/updateProfileDetail','UsersController@updateProfileDetail')->name('updateProfileDetail');
		Route::post('/updatePassword','UsersController@updatePassword')->name('updatePassword');

		
	});
});


Event::listen('send-notification-assigned-user', function($value,$data) {
	try {
		$path = public_path().'/webservice_logs/'.date("d-m-Y h:i:s").'_notification.log';
		file_put_contents($path, "\n\n".date("d-m-Y") . "_ : ".json_encode(['user'=>$value->id,'data'=>$data])."\n", FILE_APPEND);
		$response = [];
		$device_token = $value->token;
		if($value->type == 'android' || $value->type == 'ios'){
			file_put_contents($path, "\n\n".date("d-m-Y h:i:s") . "_Notification_data : ".json_encode($data)."\n", FILE_APPEND);
			$response[] = PushNotification::setService('fcm')->setMessage([
				'data' => $data
			])->setApiKey('AIzaSyCh1wuN2xJvXKI7PrY5ANrcud1kuHvvd9E')->setConfig(['dry_run' => false])->sendByTopic($data['type'])->setDevicesToken([$device_token])->send()->getFeedback();
		}
		file_put_contents($path, "\n\n".date("d-m-Y h:i:s") . "_Response_User_android : ".json_encode($response)."\n", FILE_APPEND);
		return $response;
	} catch (Exception $e) {
		file_put_contents($path, "\n\n".date("d-m-Y h:i:s") . "_Response : ".json_encode($e)."\n", FILE_APPEND);
	}
});