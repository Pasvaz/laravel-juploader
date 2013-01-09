<?php

// Autoload Uploader
Autoloader::namespaces(
    array('Uploader' => Bundle::path('jupload') . 'src' .DS. 'Uploader')
);

Asset::container('jupload')
    ->bundle('jupload')

    ->add('fileupload-ui-css',	'css/jquery.fileupload-ui.css')
    ->add('style',         		'css/style.css')

    ->add('jquery-ui',			'js/vendor/jquery.ui.widget.js')
    ->add('tmpl',				'js/extra/tmpl.min.js')
    //DEBUG ->add('tmpl',		'js/extra/tmpl.js')
    ->add('load-image',			'js/extra/load-image.min.js')
    //DEBUG ->add('load-image',	'js/extra/load-image.js')
    ->add('iframe-transport',	'js/jquery.iframe-transport.js')
    ->add('fileupload',			'js/jquery.fileupload.js')
    ->add('fileupload-fp',      'js/jquery.fileupload-fp.js')
    ->add('fileupload-ui',		'js/jquery.fileupload-ui.js')
    ->add('main',				'js/main.js')
    ->add('locale',				'js/locale.js');

Asset::container('jupload-gallery')
    ->bundle('jupload')
    //->add('bootstrap-gallery-css',	'css/extra/bootstrap-image-gallery.css')
    ->add('bootstrap-gallery-css',		'css/extra/bootstrap-image-gallery.min.css')
    //->add('bootstrap-gallery',		'js/extra/bootstrap-image-gallery.js');
    ->add('bootstrap-gallery',			'js/extra/bootstrap-image-gallery.min.js');

Asset::container('jupload-optional')
    ->bundle('jupload')
    //->add('canvas-to-blob',			'js/extra/canvas-to-blob.js');
    ->add('canvas-to-blob',				'js/extra/canvas-to-blob.min.js');
