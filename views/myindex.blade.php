@layout('layouts.main')

@section('addstyles')
{{ Asset::container('juploader')->styles() }}
{{ Asset::container('juploader-gallery')->styles() }}
@endsection

@section('dynamicscripts')
{{ Asset::container('juploader')->scripts() }}
{{ Asset::container('juploader-gallery')->scripts() }}
{{Bootstrapper\Javascripter::write_javascript()}}
@endsection

@section('content')
<form id="fileupload" action="<?php echo URL::to_route('upload'); ?>" method="POST" enctype="multipart/form-data">
{{Uploader\ButtonBar::create()}}
</form>

<!-- modal-gallery is the modal dialog used for the image gallery -->
{{ Uploader\Templater::showGallery() }}
<!-- The template to display files available for upload -->
{{ Uploader\Templater::showUpload() }}
<!-- The template to display files available for download -->
{{ Uploader\Templater::showDownload() }}
@endsection