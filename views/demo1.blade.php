@section('content')
<form id="fileupload" action="{{ URL::to_route('upload') }}" method="POST" enctype="multipart/form-data">
{{Uploader\ButtonBar::create()->delete_button(Uploader\Button::BUTTON_CANCEL)->delete_button(Uploader\Button::BUTTON_SELECTALL)}}
</form>

{{ Uploader\Templater::showAll() }}
<hr>
<h3>View's Code:</h3>
<pre class="prettyprint">
&lt;form id="fileupload" action="&lt;?php echo URL::to_route('upload'); ?>" method="POST" enctype="multipart/form-data">
{ { Uploader\ButtonBar::create()->delete_button(Uploader\Button::BUTTON_CANCEL)->delete_button(Uploader\Button::BUTTON_SELECTALL) }}
&lt;/form>

&#123;&#123; Uploader\Templater::showAll() }}
&#123;&#123; Uploader\Javascripter::activate_uploader() }}
</pre>
<h3>Controller's Code:</h3>
<pre class="prettyprint">
$uploader = IoC::resolve('Uploader');
$uploader->Start();
return $uploader->get_response();
</pre>
@endsection
