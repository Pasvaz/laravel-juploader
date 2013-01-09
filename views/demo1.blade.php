@section('content')
<form id="fileupload" action="<?php echo URL::to_route('upload'); ?>" method="POST" enctype="multipart/form-data">
{{Uploader\ButtonBar::create()->delete_button(Uploader\Button::BUTTON_CANCEL)->delete_button(Uploader\Button::BUTTON_SELECTALL)}}
</form>

{{ Uploader\Templater::showAll() }}
<hr>
<h3>Code:</h3>
<pre class="prettyprint">
&lt;form id="fileupload" action="&lt;?php echo URL::to_route('upload'); ?>" method="POST" enctype="multipart/form-data">
{ { Uploader\ButtonBar::create()->delete_button(Uploader\Button::BUTTON_CANCEL)->delete_button(Uploader\Button::BUTTON_SELECTALL) }}
&lt;/form>

{{ Uploader\Templater::showAll() }}
</pre>
@endsection
