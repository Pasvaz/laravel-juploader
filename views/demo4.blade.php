@section('content')
<h2>Pay attention!!</h2>
<h3>This demo uses the DatabaseUploadHandler!</h3>
<h4>in order to play with this demo you MUST migrate the bundle</h4>
<pre>php artisan migrate juploader</pre>
</br>
<form id="dbfileupload" action="<?php echo URL::to_action('juploader::dbupload@index'); ?>" method="POST" enctype="multipart/form-data">
<?
echo Uploader\ButtonBar::create()
		->with_button(Uploader\Button::BUTTON_FILE, null, null, 'btn-inverse')
		->with_button(Uploader\Button::BUTTON_START, null, null, 'btn-inverse')
		->with_button(Uploader\Button::BUTTON_CANCEL, null, null, 'btn-inverse')
		->with_button(Uploader\Button::BUTTON_DELETE, null, null, 'btn-inverse')
		->with_button(Uploader\Button::BUTTON_SELECTALL, null, 'icon-check icon-white', 'btn-inverse');
?>
</form>

{{ Uploader\Templater::showAll() }}

<hr>
<h3>View's Code:</h3>
<pre class="prettyprint">
&lt;form id="fileupload" action="&lt;?php echo URL::to_action('juploader::dbupload@index'); ?>" method="POST" enctype="multipart/form-data">
&lt;?
$buttonFile = \Uploader\Button::fileButton()->with_label('Select File');
$buttonStart = new \Uploader\Button('Upload Now', "icon-upload icon-white", Uploader\Button::BUTTON_START, 'btn-success');
echo Uploader\ButtonBar::create()
		->with_button(Uploader\Button::BUTTON_FILE, null, null, 'btn-inverse')
		->with_button(Uploader\Button::BUTTON_START, null, null, 'btn-inverse')
		->with_button(Uploader\Button::BUTTON_CANCEL, null, null, 'btn-inverse')
		->with_button(Uploader\Button::BUTTON_DELETE, null, null, 'btn-inverse')
		->with_button(Uploader\Button::BUTTON_SELECTALL, null, 'icon-check icon-white', 'btn-inverse');
?>
&lt;/form>

&#123;&#123; Uploader\Templater::showAll() }}
&#123;&#123; Uploader\Javascripter::with_option('url','upload/dbupload')->with_option('formId','dbfileupload')->activate_uploader() }}
</pre>
<h3>Controller's Code:</h3>
<pre class="prettyprint">
$uploader = IoC::resolve('Uploader');
$uploader 	->with_uploader('Uploader\DatabaseUploadHandler')
		->with_argument('1')
		->with_option('script_url' , URL::to_action('juploader::dbupload@index'))
		->Start();
return $uploader->get_response();
</pre>
@endsection
