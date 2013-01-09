<?php

//Route::get('(:bundle)', array('before'=>'auth', function()
Route::get('(:bundle)', array(function()
{
	//Bundle::start('jupload');
	return View::make('jupload::index');
}));

//Route::any('(:bundle)/upload/(:any?)', array('as' => 'upload', 'before'=>'auth', function($folder = null)
Route::any('(:bundle)/upload/(:any?)', array('as' => 'upload', function($folder = null)
{

	if ( ! Request::ajax())
		return;

	//Bundle::start('jupload');
	if ($folder !== null)
		$folder .= '/';

	$uploader = IoC::resolve('Uploader');
	$uploader->handle_request();
}));