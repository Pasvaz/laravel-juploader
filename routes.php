<?php

//Route::get('(:bundle)', array('before'=>'auth', function()
Route::get('(:bundle)', array(function()
{
	//Bundle::start('juploader');
	return View::make('juploader::index')->nest('content', 'juploader::demo0');;
}));

Route::get('(:bundle)/demo/(:num?)', array(function($page='')
{
	//Bundle::start('juploader');
	return View::make('juploader::index')->nest('content', 'juploader::demo'.$page);;
}));

//Route::any('(:bundle)/upload/(:any?)', array('as' => 'upload', 'before'=>'auth', function($folder = null)
Route::any('(:bundle)/upload/(:any?)', array('as' => 'upload', function($folder = null)
{

	if ( ! Request::ajax())
		return;

	//Bundle::start('juploader');
	if ($folder !== null)
		$folder .= '/';

	$uploader = IoC::resolve('Uploader');
	$uploader->handle_request();
}));