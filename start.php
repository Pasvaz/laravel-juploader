<?php

/**
 * 	Autoload Uploader namespace
 */
Autoloader::namespaces(
    array('Uploader' => Bundle::path('juploader') . 'src' .DS. 'Uploader')
);

/**
 * 	IoC Management
 */
$options = Config::get('juploader::settings');
//You can also change the $options at runtime
//$name = (Auth::user()) ? Auth::user()->name : 'Anonymous';
//$options['upload_dir'] = path('public').'/pictures/'.$name.'/';
//$options['upload_url'] = URL::base().'/pictures/'.$name.'/';
Laravel\IoC::register('Uploader', function() use ($options)
{
	return new Uploader\UploadHandler($options, false);
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
    ->add('main',					'js/main.js')
    ->add('locale',					'js/locale.js');

Asset::container('juploader-gallery')
    ->bundle('juploader')
    ->add('bootstrap-gallery-css',	'css/extra/bootstrap-image-gallery.min.css')
    ->add('bootstrap-gallery',		'js/extra/bootstrap-image-gallery.min.js');

Asset::container('juploader-optional')
    ->bundle('juploader')
    ->add('canvas-to-blob',			'js/extra/canvas-to-blob.min.js');

Asset::container('juploader-debug')
    ->bundle('juploader')
    ->add('tmpl',					'js/extra/tmpl.js')
    ->add('load-image',				'js/extra/load-image.js')
    ->add('bootstrap-gallery-css',	'css/extra/bootstrap-image-gallery.css')
    ->add('bootstrap-gallery',		'js/extra/bootstrap-image-gallery.js')
    ->add('canvas-to-blob',			'js/extra/canvas-to-blob.js');
