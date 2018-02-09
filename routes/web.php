<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/instrucciones', function () {
    return view('instructions');
});

Route::get('/acerca-de', function () {
    return view('credits');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index');
Route::get('/seleccionar/proyecto/{id}', 'HomeController@selectProject');

Route::group(['middleware' => 'auth', 'namespace' => 'User'], function (){
    Route::post('/profile/image', 'ProfileController@postImage');
});

Route::group(['middleware' => 'support', 'namespace' => 'Support'], function (){
//clients
    Route::get('/cliente', 'ClientController@create');
    Route::post('/cliente', 'ClientController@store');
    Route::get('/cliente/{id}', 'ClientController@edit');
    Route::post('/cliente/{id}', 'ClientController@update');

    Route::get('/cliente/{id}/eliminar', 'ClientController@delete');
});

// Incident

Route::get('/reportar', 'IncidentController@create');
Route::post('/reportar', 'IncidentController@store');

Route::get('/incidencia/{id}/editar', 'IncidentController@edit');
Route::post('/incidencia/{id}/editar', 'IncidentController@update');

Route::get('/ver/{id}', 'IncidentController@show');

Route::get('/vista/{id}', 'IncidentController@preview');

Route::get('/incidencia/{id}/atender', 'IncidentController@take');
Route::get('/incidencia/{id}/resolver', 'IncidentController@solve');
Route::get('/incidencia/{id}/abrir', 'IncidentController@open');
Route::get('/incidencia/{id}/derivar', 'IncidentController@nextLevel');


// Message
Route::post('/mensajes', 'MessageController@store');


Route::group(['middleware' => 'admin', 'namespace' => 'Admin'], function () {

    //Incidents
    Route::get('/incidencias', 'IncidentController@index');
    Route::get('/incidencia/{id}', 'IncidentController@show');
    // User
    Route::get('/usuarios', 'UserController@index');
    Route::post('/usuarios', 'UserController@store');
    
    Route::get('/usuario/{id}', 'UserController@edit');
    Route::post('/usuario/{id}', 'UserController@update');

    Route::get('/usuario/{id}/eliminar', 'UserController@delete');

    // Project
	Route::get('/proyectos', 'ProjectController@index');
	Route::post('/proyectos', 'ProjectController@store');

	Route::get('/proyecto/{id}', 'ProjectController@edit');
    Route::post('/proyecto/{id}', 'ProjectController@update');

    Route::get('/proyecto/{id}/eliminar', 'ProjectController@delete');
    Route::get('/proyecto/{id}/restaurar', 'ProjectController@restore');

    // Category
    Route::post('/categorias', 'CategoryController@store');
    Route::post('/categoria/editar', 'CategoryController@update');
    Route::get('/categoria/{id}/eliminar', 'CategoryController@delete');
    // Level
    Route::post('/niveles', 'LevelController@store');
    Route::post('/nivel/editar', 'LevelController@update');
    Route::get('/nivel/{id}/eliminar', 'LevelController@delete');

    // Project-User
    Route::post('/proyecto-usuario', 'ProjectUserController@store');
    Route::get('/proyecto-usuario/{id}/eliminar', 'ProjectUserController@delete');

	// Route::get('/config', 'ConfigController@index');
});
