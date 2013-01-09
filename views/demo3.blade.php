@section('content')
<form id="fileupload" action="<?php echo URL::to_route('upload'); ?>" method="POST" enctype="multipart/form-data">
<?
echo Uploader\ButtonBar::create()
		->with_button(Uploader\Button::BUTTON_FILE, 'File', '', 'btn-danger')
		->with_button(Uploader\Button::BUTTON_START, 'Upload', '', 'btn-danger')
		->with_button(Uploader\Button::BUTTON_CANCEL, 'Stop', '', 'btn-danger')
		->with_button(Uploader\Button::BUTTON_DELETE, 'Delete', '', 'btn-danger')
		->with_button(Uploader\Button::BUTTON_SELECTALL, 'Select', '', 'btn-danger');
?>
</form>

{{ Uploader\Templater::showAll() }}

<hr>
<h3>Code:</h3>
<pre class="prettyprint">
&lt;form id="fileupload" action="&lt;?php echo URL::to_route('upload'); ?>" method="POST" enctype="multipart/form-data">
&lt;?
$buttonFile = \Uploader\Button::fileButton()->with_label('Select File');
$buttonStart = new \Uploader\Button('Upload Now', "icon-upload icon-white", Uploader\Button::BUTTON_START, 'btn-success');
echo Uploader\ButtonBar::create()
		->with_button(Uploader\Button::BUTTON_FILE, 'File', '', 'btn-danger')
		->with_button(Uploader\Button::BUTTON_START, 'Upload', '', 'btn-danger')
		->with_button(Uploader\Button::BUTTON_CANCEL, 'Stop', '', 'btn-danger')
		->with_button(Uploader\Button::BUTTON_DELETE, 'Delete', '', 'btn-danger')
		->with_button(Uploader\Button::BUTTON_SELECTALL, 'Select', '', 'btn-danger');
?>
&lt;/form>

{{ Uploader\Templater::showAll() }}
</pre>
@endsection
