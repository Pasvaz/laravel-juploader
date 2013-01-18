<?php
/**
 * 
 * Javascript fileUploader Settings
 * 
 */
return array(
	// the form id
	'formId' => 'fileupload',
	// the url that point to the php script
	'url' => '/upload/upload/',
	// The file input field(s), that are listened to for change events.
	// If undefined, it is set to the file input fields inside
	// of the widget element on plugin initialization.
	// Set to null to disable the change listener.
	'fileInput' => 'undefined',
	// By default, the file input field is replaced with a clone after
	// each input field change event. This is required for iframe transport
	// queues and allows change events to be fired for the same file
	// selection, but can be disabled by setting the following option to false:
	'replaceFileInput' => true,
	// The parameter name for the file form data (the request argument name).
	// If undefined or empty, the name property of the file input field is
	// used, or "files[]" if the file input name property is also empty,
	// can be a string or an array of strings:
	'paramName' => 'undefined',
	// By default, each file of a selection is uploaded using an individual
	// request for XHR type uploads. Set to false to upload file
	// selections in one request each:
	'singleFileUploads' => true,
	// To limit the number of files uploaded with one XHR request,
	// set the following option to an integer greater than 0:
	'limitMultiFileUploads' => 'undefined',
	// Set the following option to true to issue all file upload requests
	// in a sequential order:
	'sequentialUploads' => false,
	// To limit the number of concurrent uploads,
	// set the following option to an integer greater than 0:
	'limitConcurrentUploads' => 'undefined',
	// Set the following option to true to force iframe transport uploads:
	'forceIframeTransport' => false,
	// Set the following option to the location of a redirect url on the
	// origin server, for cross-domain iframe transport uploads:
	'redirect' => 'undefined',
	// The parameter name for the redirect url, sent as part of the form
	// data and set to 'redirect' if this option is empty:
	'redirectParamName' => 'undefined',
	// Set the following option to the location of a postMessage window,
	// to enable postMessage transport uploads:
	'postMessage' => 'undefined',
	// By default, XHR file uploads are sent as multipart/form-data.
	// The iframe transport is always using multipart/form-data.
	// Set to false to enable non-multipart XHR uploads:
	'multipart' => true,
	// To upload large files in smaller chunks, set the following option
	// to a preferred maximum chunk size. If set to 0, null or undefined,
	// or the browser does not support the required Blob API, files will
	// be uploaded as a whole.
	'maxChunkSize' => 'undefined',
	// When a non-multipart upload or a chunked multipart upload has been
	// aborted, this option can be used to resume the upload by setting
	// it to the size of the already uploaded bytes. This option is most
	// useful when modifying the options object inside of the "add" or
	// "send" callbacks, as the options are cloned for each file upload.
	'uploadedBytes' => 'undefined',
	// By default, failed (abort or error) file uploads are removed from the
	// global progress calculation. Set the following option to false to
	// prevent recalculating the global progress data:
	'recalculateProgress' => true,
	// Interval in milliseconds to calculate and trigger progress events:
	'progressInterval' => 100,
	// Interval in milliseconds to calculate progress bitrate:
	'bitrateInterval' => 500,

	/*/		INTERFACE 		/*/

	// By default, files added to the widget are uploaded as soon
	// as the user clicks on the start buttons. To enable automatic
	// uploads, set the following option to true:
	'autoUpload' => false,
	// The following option limits the number of files that are
	// allowed to be uploaded using this widget:
	'maxNumberOfFiles' => 'undefined',
	// The maximum allowed file size:
	'maxFileSize' => 'undefined',
	// The minimum allowed file size:
	'minFileSize' => 'undefined',
	// The regular expression for allowed file types, matches
	// against either file type or file name:
	'acceptFileTypes' =>  '/.+$/i',
	// The regular expression to define for which files a preview
	// image is shown, matched against the file type:
	'previewSourceFileTypes' => '/^image\/(gif|jpeg|png)$/',
	// The maximum file size of images that are to be displayed as preview:
	'previewSourceMaxFileSize' => 5000000, // 5MB
	// The maximum width of the preview images:
	'previewMaxWidth' => 80,
	// The maximum height of the preview images:
	'previewMaxHeight' => 80,
	// By default, preview images are displayed as canvas elements
	// if supported by the browser. Set the following option to false
	// to always display preview images as img elements:
	'previewAsCanvas' => true,
	// The ID of the upload template:
	'uploadTemplateId' => 'template-upload',
	// The ID of the download template:
	'downloadTemplateId' => 'template-download',
	// The container for the list of files. If undefined, it is set to
	// an element with class "files" inside of the widget element:
	'filesContainer' => 'undefined',
	// By default, files are appended to the files container.
	// Set the following option to true, to prepend files instead:
	'prependFiles' => true,
	// The expected data type of the upload response, sets the dataType
	// option of the $.ajax upload requests:
	'dataType' => 'json',
);
