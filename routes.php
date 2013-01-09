<?php

Route::get('(:bundle)', function()
{
	//Bundle::start('jupload');
	return View::make('jupload::index');
});

Route::any('(:bundle)/upload/(:any?)', array('as' => 'upload', function($folder = null)
{
	if ( ! Request::ajax())
		return;

	//Bundle::start('jupload');
	if ($folder !== null)
		$folder .= '/';

	$options = Config::get('jupload::settings');

	new Uploader\UploadHandler($options);
}));