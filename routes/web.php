<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'WelcomeController@index')
				->name('welcome');

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
})->middleware('role:super-admin');

Route::get('/events/{event}-{slug}', 'WelcomeController@event')
										->name('event');
Route::get('/event', 'WelcomeController@events')
										->name('events.all');

/*Livewire*/
Route::livewire('/events/schedules', 'user.schedule')
									 ->name('calender');

Route::livewire('/events/search', 'user.search')
									 ->name('search.events');

/** Booking */
Route::get('/events/{event}-{slug}/checkout', 'User\BookingController@index')
												->name('booking.checkout');
Route::post('/events/{event_id}/book', "User\BookingController@checkout")
												->name('event.book');
Route::get('/events/book/thankyou/{booking}', 'User\BookingController@show')
												->name('booking.thankyou');


/** Login & Register */
Route::get('/login', 'AuthController@login')
					->name('login');
Route::get('/register', 'AuthController@register')
					->name('register');

/** User */
Auth::routes();
Route::group(['middleware' => ['role:user']], function () {
    Route::get('/home', 'User\HomeController@index')
    					->name('home');
	Route::post('logout', 'User\HomeController@logout')
						->name('user.logout');

	//Profile
	Route::livewire('/profile', 'user.auth.profile')
								->name('profile');

	//Booking
	Route::livewire('/bookings/{book}', 'user.bookings.booking');

});


/** Company */
Route::prefix('admin')->group(function () {
	/* Before Authenctication*/
	Route::get('login', 'Admin\LoginController@index')
						->name('admin.login.view');
	Route::post('login', 'Admin\LoginController@login')
						->name('admin.login');

	
	/* After Authenctication*/
	Route::post('logout', 'Admin\LoginController@logout')
							->middleware('auth')
							->name('admin.logout');

	//Dashboard
	Route::get('dashboard', 'Admin\HomeController@index')
							->middleware('auth')
							->name('admin.dashboard');


	//Category
	Route::group(['middleware' => ['permission:add categories']], function () {
		Route::get('categories', 'Admin\CategoryController@index')
												->name('categories');
		Route::post('categories', 'Admin\CategoryController@store')
												->name('category.store');
		Route::patch('categories/{category}', 'Admin\CategoryController@update')
												->name('category.update');
		Route::delete('categories/{category}', 'Admin\CategoryController@destroy')
												->name('category.destroy');
	});

	//Events
	Route::group(['middleware' => ['permission:add events']], function () {
		Route::get('events', 'Admin\EventController@index')
										->name('events');
		Route::get('events/create', 'Admin\EventController@create')
										->name('event.create');
		Route::post('events', 'Admin\EventController@store')
										->name('event.store');
		Route::get('events/{event}', 'Admin\EventController@show')
										->name('event.show');
		Route::get('events/{event}/edit', 'Admin\EventController@edit')
										->name('event.edit');
		Route::patch('events/{event}', 'Admin\EventController@update')
										->name('event.update');
		Route::delete('events/{event}', 'Admin\EventController@destroy')
										->name('event.destroy');


		//Api
		Route::get('api/events', 'Admin\Api\EventController@index');
	});

	//Speakers
	Route::group(['middleware' => ['permission:add speakers']], function () {
		Route::get('speakers', 'Admin\SpeakerController@index')
											->name('speakers');
		Route::get('speakers/create', 'Admin\SpeakerController@create')
											->name('speaker.create');
		Route::get('speakers/{speaker}', 'Admin\SpeakerController@show')
											->name('speaker.show');
		Route::get('speakers/{speaker}/edit', 'Admin\SpeakerController@edit')
											->name('speaker.edit');
		Route::post('speakers', 'Admin\SpeakerController@store')
											->name('speaker.store');
		Route::patch('speakers/{speaker}', 'Admin\SpeakerController@update')
											->name('speaker.update');
		Route::delete('speakers/{speaker}', 'Admin\SpeakerController@destroy')
											->name('speaker.destroy');
	});

	//Sponsers
	Route::group(['middleware' => ['permission:add sponsers']], function () {
		Route::get('sponsers', 'Admin\SponserController@index')
								->name('sponsers');
		Route::get('sponsers/create', 'Admin\SponserController@create')	
								->name('sponser.create');
		Route::get('sponsers/{sponser}', 'Admin\SponserController@show')
								->name('sponser.show');
		Route::get('sponsers/{sponser}/edit', 'Admin\SponserController@edit')
								->name('sponser.edit');
		Route::post('sponsers', 'Admin\SponserController@store')
								->name('sponser.store');
		Route::patch('sponsers/{sponser}', 'Admin\SponserController@update')
								->name('sponser.update');
		Route::delete('sponsers/{sponser}', 'Admin\SponserController@destroy')
								->name('sponser.destroy');
	});

	//Super Admin
	Route::group(['middleware' => ['role:super-admin']], function () {
		Route::livewire('/profile', 'admin.auth.profile')
							->name('admin.profile')
							->layout('layouts.admin');

		//User
		Route::get('users', 'Admin\UserController@index')
							->name('users');
		Route::get('users/create', 'Admin\UserController@create')
							->name('user.create');
		Route::post('users', 'Admin\UserController@store')
							->name('user.store');
		Route::patch('users/{user}', 'Admin\UserController@update')
							->name('user.update');
		Route::get('users/{user}', 'Admin\UserController@show')
							->name('user.show');
		Route::delete('users/{user}', 'Admin\UserController@destroy')
							->name('user.destroy');


		//Role
		Route::post('roles', 'Admin\RoleController@store');
		Route::delete('roles/{role}', 'Admin\RoleController@destroy');

		//Permissions
		Route::post('permissions', 'Admin\PermissionController@store');
		Route::delete('permissions/{permission}', 'Admin\PermissionController@destroy');


		Route::group(['layout' => 'layouts.admin'], function () {
		    
			//Booking
			Route::livewire('/bookings', 'admin.bookings.index')
										->name('bookings');
			Route::livewire('/bookings/{booking}', 'admin.bookings.show')
										->name('booking');
		});

		// Route::get('bookings', 'Admin\BookingController@index')->name('bookings');
		// Route::post('bookings', 'Admin\BookingController@store')->name('booking.store');
		// Route::patch('bookings/{booking}', 'Admin\BookingController@update')->name('booking.update');
		// Route::get('bookings/{booking}', 'Admin\BookingController@show')->name('booking.show');
		// Route::delete('bookings/{booking}', 'Admin\BookingController@destroy')->name('booking.destroy');
	});

});