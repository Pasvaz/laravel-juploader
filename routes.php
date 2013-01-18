<?php

Route::get('(:bundle)', array(function()
{
	//Bundle::start('juploader');
	return View::make('juploader::index')->nest('content', 'juploader::demo0');;
}));

Route::get('(:bundle)/demo/(:num?)', array(function($page='')
{
	//Bundle::start('juploader');
	if ($page == 4)
		return View::make('juploader::database')->nest('content', 'juploader::demo'.$page);
	else
		return View::make('juploader::index')->nest('content', 'juploader::demo'.$page);
}));

Route::any('(:bundle)/upload', array('as' => 'upload', function()
{
	if ( ! Request::ajax())
		return;

	//Bundle::start('juploader');

	$uploader = IoC::resolve('Uploader');
	$uploader->Start();
	return $uploader->get_response();
}));

Route::controller('juploader::dbupload');
