<?php

class Juploader_Dbupload_Controller extends Controller 
{
	public function action_index($folder = null)
	{
		//if ( ! Request::ajax())
			//return;

		//Bundle::start('juploader');

		$uploader = IoC::resolve('Uploader');
		$uploader
			->with_uploader('Uploader\DatabaseUploadHandler')
			//->with_uploader('Uploader\DbIdUploadHandler')
			->with_argument('1')
			->with_option('script_url' , URL::to_action('juploader::dbupload@index'))
			->Start();
		return $uploader->get_response();
	}
}