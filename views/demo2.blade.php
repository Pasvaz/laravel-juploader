@section('content')
<form id="fileupload" action="{{ URL::to_route('upload') }}" method="POST" enctype="multipart/form-data">
<?
$buttonFile = \Uploader\Button::fileButton()->with_label('Select File');
$buttonStart = new \Uploader\Button('Upload Now', "icon-upload icon-white", Uploader\Button::BUTTON_START, 'btn-success');
echo Uploader\ButtonBar::create(false, false, false)
		->with_button(Uploader\Button::BUTTON_FILE, $buttonFile)
		->with_button(Uploader\Button::BUTTON_START, $buttonStart);
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

echo Uploader\ButtonBar::create(false, false, false)
		->with_button(Uploader\Button::BUTTON_FILE, $buttonFile)
		->with_button(Uploader\Button::BUTTON_START, $buttonStart);
?>
&lt;/form>

{{ Uploader\Templater::showAll() }}
</pre>
@endsection
