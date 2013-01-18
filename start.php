<?php

/**
 * 	Autoload Uploader namespace
 */
Autoloader::namespaces(
    array('Uploader' => Bundle::path('juploader') . 'src' .DS. 'Uploader')
);

// Load Interface iUploadHandler
require dirname(__FILE__) .DS. 'src' .DS. 'Uploader' .DS. 'iUploadHandler.php';

Autoloader::directories(array(
    Bundle::path('juploader').'models',
    Bundle::path('juploader').'libraries',
));

/**
* 	IoC Management
*
*   You can also change the $options here
*       $name = (Auth::user()) ? Auth::user()->name : 'Anonymous';
*       $options['upload_dir'] = path('public').'/pictures/'.$name.'/';
*       $options['upload_url'] = URL::base().'/pictures/'.$name.'/';
*
*   However it's better to change the options per controller, like this:
*       $uploader = IoC::resolve('Uploader');
*       $uploader
*           ->with_option('override_name' , 'MyFixedName')
*           ->with_option('script_url' , URL::to_route('dbupload'))
*       ->Start();
*/
Laravel\IoC::register('Uploader', function()
{
    $options = Config::get('juploader::settings');
    $uploader = isset($options['UploaderClass']) ? $options['UploaderClass'] : 'Uploader\FileUploadHandler';
    $arguments = isset($options['UploaderArguments']) ? $options['UploaderArguments'] : null;
    $server_options = $options['Server'];

    return new Uploader\UploadServer($uploader, $arguments, $server_options);
});


/**
 * 	Assets Management
 */
Asset::container('juploader')
    ->bundle('juploader')

    ->add('fileupload-ui-css',		'css/jquery.fileupload-ui.css')
    ->add('style',         			'css/style.css')
	
    ->add('jquery-ui',				'js/vendor/jquery.ui.widget.js')
    ->add('tmpl',					'js/extra/tmpl.min.js')
    ->add('load-image',				'js/extra/load-image.min.js')
    ->add('iframe-transport',		'js/jquery.iframe-transport.js')
    ->add('fileupload',				'js/jquery.fileupload.js')
    ->add('fileupload-fp',      	'js/jquery.fileupload-fp.js')
    ->add('fileupload-ui',			'js/jquery.fileupload-ui.js')
    // main.js was REMOVED, it's no longer necessary
    // now the main is written in realtime by Uploader\Javascripter
    //->add('main',					'js/main.js')
    ->add('locale',					'js/locale.js');

Asset::container('juploader-gallery')
    ->bundle('juploader')
    ->add('bootstrap-gallery-css',	'css/extra/bootstrap-image-gallery.min.css')
    ->add('bootstrap-gallery',		'js/extra/bootstrap-image-gallery.min.js');

/**
 * Use this asset only if you are going to 
 * use the library canvas-to-blob
 * mode details here: https://github.com/blueimp/jQuery-File-Upload/wiki
 */
Asset::container('juploader-optional')
    ->bundle('juploader')
    ->add('canvas-to-blob',			'js/extra/canvas-to-blob.min.js');

/**
 * Debug assets, don't use these assets 
 * unless you don't need to debug the js
 */
Asset::container('juploader-debug')
    ->bundle('juploader')
    ->add('tmpl',					'js/extra/tmpl.js')
    ->add('load-image',				'js/extra/load-image.js')
    ->add('bootstrap-gallery-css',	'css/extra/bootstrap-image-gallery.css')
    ->add('bootstrap-gallery',		'js/extra/bootstrap-image-gallery.js')
    ->add('canvas-to-blob',			'js/extra/canvas-to-blob.js');
