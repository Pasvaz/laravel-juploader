<?php

return array(

	'UploaderClass' => 'Uploader\FileUploadHandler',
	//'UploaderClass' => 'Uploader\DatabaseUploadHandler',
	//'UploaderClass' => 'Uploader\DbIdUploadHandler',
	'UploaderArguments' => '1',

	'Server' => array(
		'override_name' => function($name = null) { return \Str::random(10); },
		'script_url' => URL::to_route('upload'),
		'upload_dir' => path('public').'bundles/juploader/uploads/files/',
		'upload_url' => URL::base().'/bundles/juploader/uploads/files/',
		'max_width' => '2000',
		'max_height' => '2000',
		'image_versions' => array(
		    // Uncomment the following version to restrict the size of
		    // uploaded images:
		    /*
		    '' => array(
		        'max_width' => 1920,
		        'max_height' => 1200,
		        'jpeg_quality' => 95
		    ),
		    */
		    // Uncomment the following version to have a croped version of the uploaded images
		    // uploaded images:
			/*
			'fixed' => array(
				'max_width' => 64,'max_height' => 64, 'jpeg_quality' => 75, 'fixed_size' => true,
		    	// Uncomment the following rows to change the default dir for 'fixed'
				//'upload_dir' => path('public').'bundles/juploader/uploads/fixed/',
				//'upload_url' => URL::base().'/bundles/juploader/uploads/fixed/',
			),
			*/
			'thumbnail' => array(
				'max_width' => 120,'max_height' => 120, 'jpeg_quality' => 75, 'fixed_size' => false,
		    	// Uncomment the following rows to change the default dir for 'thumbnail'
				//'upload_dir' => path('public').'bundles/juploader/uploads/thumbnails/',
				//'upload_url' => URL::base().'/bundles/juploader/uploads/thumbnails/',
			),
		),

		'user_dirs' => false,
		'mkdir_mode' => 0755,
		'param_name' => 'files',

		// Set the following option to 'POST', if your server does not support
		// DELETE requests. This is a parameter sent to the client:
		'delete_type' => 'POST',

		'access_control_allow_origin' => '*',
		'access_control_allow_credentials' => false,
		'access_control_allow_methods' => array(
		    'OPTIONS',
		    'HEAD',
		    'GET',
		    'POST',
		    'PUT',
		    'PATCH',
		    'DELETE'
		),
		'access_control_allow_headers' => array(
		    'Content-Type',
		    'Content-Range',
		    'Content-Disposition'
		),

		// Enable to provide file downloads via GET requests to the PHP script:
		'download_via_php' => false,

		// Defines which files can be displayed inline when downloaded:
		'inline_file_types' => '/\.(gif|jpe?g|png)$/i',

		// Defines which files (based on their names) are accepted for upload:
		//for any file use; '/.+$/i',
		'accept_file_types' => '/\.(gif|jpe?g|png)$/i',

		// The php.ini settings upload_max_filesize and post_max_size
		// take precedence over the following max_file_size setting:
		'max_file_size' => null,
		'min_file_size' => 1,
		// The maximum number of files for the upload directory:
		'max_number_of_files' => 100,
		// Image resolution restrictions:
		'max_width' => null,
		'max_height' => null,
		'min_width' => 1,
		'min_height' => 1,

		// Set the following option to false to enable resumable uploads:
		'discard_aborted_uploads' => true,

		// Set to true to rotate images based on EXIF meta data, if available:
		'orient_image' => false,
	),
);