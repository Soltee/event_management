<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/events/{event}-{slug}', 'WelcomeController@event')->name('event');
Route::get('/events', 'WelcomeController@events')->name('events.all');

/** Booking */
Route::get('/events/{event}-{slug}/checkout', 'User\BookingController@index')->name('booking.checkout');
Route::post('/events/{event_id}/book', "User\BookingController@checkout")->name('event.book');
Route::get('/events/book/thankyou/{booking}', 'User\BookingController@show')->name('booking.thankyou');


/** Login & Register */
Route::get('/login', 'WelcomeController@login')->name('login');
Route::post('login', 'User\LoginController@login')->name('user.login');

/** User */
Auth::routes();
Route::group(['middleware' => ['role:user']], function () {
    Route::get('/home', 'User\HomeController@index')->name('home');
	Route::post('logout', 'User\LoginController@logout')->name('user.logout');
});


/** Company */
Route::prefix('admin')->group(function () {
	/* Before Authenctication*/
	Route::get('login', 'Admin\LoginController@index')->name('admin.login.view');
	Route::post('login', 'Admin\LoginController@login')->name('admin.login');

	/* After Authenctication*/
	Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');

	//Dashboard
	Route::get('dashboard', 'Admin\HomeController@index')->name('admin.dashboard');


	//Category
	Route::group(['middleware' => ['permission:add categories']], function () {
		Route::get('categories', 'Admin\CategoryController@index')->name('categories');
		Route::post('categories', 'Admin\CategoryController@store')->name('category.store');
		Route::patch('categories/{category}', 'Admin\CategoryController@update')->name('category.update');
		Route::delete('categories/{category}', 'Admin\CategoryController@destroy')->name('category.destroy');
	});

	//Events
	Route::group(['middleware' => ['permission:add events']], function () {
		Route::get('events', 'Admin\EventController@index')->name('events');
		Route::get('events/create', 'Admin\EventController@create')->name('event.create');
		Route::get('events/{event}', 'Admin\EventController@show')->name('event.show');
		Route::post('events', 'Admin\EventController@store')->name('event.store');
		Route::patch('events/{event}', 'Admin\EventController@update')->name('event.update');
		Route::delete('events/{event}', 'Admin\EventController@destroy')->name('event.destroy');
	});

	//Speakers
	Route::group(['middleware' => ['permission:add speakers']], function () {
		Route::get('speakers', 'Admin\SpeakerController@index')->name('speakers');
		Route::post('speakers', 'Admin\SpeakerController@store')->name('speaker.store');
		Route::patch('speakers/{speaker}', 'Admin\SpeakerController@update')->name('speaker.update');
		Route::delete('speakers/{speaker}', 'Admin\SpeakerController@destroy')->name('speaker.destroy');
	});

	//Sponsers
	Route::group(['middleware' => ['permission:add sponsers']], function () {
		Route::get('sponsers', 'Admin\SponserController@index')->name('sponsers');
		Route::post('sponsers', 'Admin\SponserController@store')->name('sponser.store');
		Route::patch('sponsers/{sponser}', 'Admin\SponserController@update')->name('sponser.update');
		Route::delete('sponsers/{sponser}', 'Admin\SponserController@destroy')->name('sponser.destroy');
	});

	//Super Admin
	// Route::group(['middleware' => ['role:super-admin']], function () {

	// 	//User
	// 	Route::get('users', 'Admin\UserController@index')->name('users');
	// 	Route::post('users', 'Admin\UserController@store')->name('user.store');
	// 	Route::patch('users/{user}', 'Admin\UserController@update')->name('user.update');
	// 	Route::get('users/{user}', 'Admin\UserController@show')->name('user.show');
	// 	Route::delete('users/{user}', 'Admin\UserController@destroy')->name('user.destroy');

	// 	//Booking
	// 	Route::get('bookings', 'Admin\BookingController@index')->name('bookings');
	// 	Route::post('bookings', 'Admin\BookingController@store')->name('booking.store');
	// 	Route::patch('bookings/{booking}', 'Admin\BookingController@update')->name('booking.update');
	// 	Route::get('bookings/{booking}', 'Admin\BookingController@show')->name('booking.show');
	// 	Route::delete('bookings/{booking}', 'Admin\BookingController@destroy')->name('booking.destroy');
	// });

});