<?php

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

Route::any('(:bundle)/upload', array('as' => 'upload', function()
{
	//Bundle::start('juploader');

	$uploader = IoC::resolve('Uploader');
	$uploader->handle_request();

	return Response::make($uploader->get_response(), 200, $uploader->get_headers());
}));