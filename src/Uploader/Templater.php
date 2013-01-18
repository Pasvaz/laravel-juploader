<?php
namespace Uploader;

/**
 * Template System.
 *
 * @category   HTML/UI
 * @package    Uploader
 * @author     Pasquale Vazzana - <pasqualevazzana@gmail.com>
 * @license    MIT License <http://www.opensource.org/licenses/mit>
 *
 * @see        https://github.com/blueimp/jQuery-File-Upload
 */
class Templater
{

	static function showAll()
	{
		static::showGallery();
		static::showUpload();
		static::showDownload();
	}

	static function showGallery($parameters = array())
	{
        $showDownload = $showSlideshow = $showPrev = $showNext = true;
        $filter='data-filter=":odd"';
        $preButtons = $postButtons = array();
        
        if (isset($parameters['filter'])) $filter=$parameters['filter'];

        if (isset($parameters['hidden']))
        {
            $showDownload = !(in_array('download', $parameters['hidden']));
            $showSlideshow = !(in_array('slideshow', $parameters['hidden']));
            $showPrev = !(in_array('prev', $parameters['hidden']));
            $showNext = !(in_array('next', $parameters['hidden']));
        }

        if (isset($parameters['add-before']))
        {
            foreach ($parameters['add-before'] as $value) 
            {
                $preButtons[] = $value;
            }
        }

        if (isset($parameters['add-after']))
        {
            foreach ($parameters['add-after'] as $value) 
            {
                $postButtons[] = $value;
            }
        }

        $Download = __('juploader::interface.download');
        $Slideshow = __('juploader::interface.slideshow');
        $Previous = __('juploader::interface.previous');
        $Next = __('juploader::interface.next');

		echo <<<EOF
<div id="modal-gallery" class="modal modal-gallery hide fade" $filter>
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3 class="modal-title"></h3>
	</div>
	<div class="modal-body"><div class="modal-image"></div></div>
	<div class="modal-footer">
EOF;
        foreach ($preButtons as $value) echo $value;

        if ($showDownload)
            echo <<<EOF
		<a class="btn modal-download" target="_blank">
			<i class="icon-download"></i>
			<span>$Download</span>
		</a>
EOF;
        if ($showSlideshow)
            echo <<<EOF
		<a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
			<i class="icon-play icon-white"></i>
			<span>$Slideshow</span>
		</a>
EOF;
        if ($showPrev)
            echo <<<EOF
		<a class="btn btn-info modal-prev">
			<i class="icon-arrow-left icon-white"></i>
			<span>$Previous</span>
		</a>
EOF;
        if ($showNext)
            echo <<<EOF
		<a class="btn btn-primary modal-next">
			<span>$Next</span>
			<i class="icon-arrow-right icon-white"></i>
		</a>
EOF;
        foreach ($postButtons as $value) echo $value;
        echo <<<EOF
	</div>
</div>
EOF;
	}

	static function showUpload($parameters = array())
	{
        $btn_cancel = __('juploader::interface.cancel');
        $btn_start = __('juploader::interface.start');
        $error = __('juploader::interface.error');
        $showPreview = $showName = $showSize = $showStart = $showCancel = true;
        if (isset($parameters['hidden']))
        {
            $showPreview = !(in_array('preview', $parameters['hidden']));
            $showName = !(in_array('name', $parameters['hidden']));
            $showSize = !(in_array('size', $parameters['hidden']));
            $showStart = !(in_array('start', $parameters['hidden']));
            $showCancel = !(in_array('cancel', $parameters['hidden']));
        }

		echo <<<EOF
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload">
EOF;
        if ($showPreview) echo '<td class="preview"><span class=""></span></td>';
        if ($showName) echo '<td class="name"><span>{%=file.name%}</span></td>';
        if ($showSize) echo '<td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>';
        echo <<<EOF
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">$error</span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="bar" style="width:0%;"></div>
                </div>
            </td>
            <td class="start">
EOF;
        if ($showStart)
            echo <<<EOF
                {% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>$btn_start</span>
                </button>
                {% } %}
EOF;
        echo <<<EOF
            </td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
EOF;
        if ($showCancel)
            echo <<<EOF
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>$btn_cancel</span>
            </button>
EOF;
        echo <<<EOF
        {% } %}</td>
    </tr>
{% } %}
</script>
EOF;
	}

	static function showDownload()
	{
        $btn_delete = __('juploader::interface.delete');
        $error = __('juploader::interface.error');
		echo <<<EOF
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">$error</span> {%=file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a data-suca="{%=file.id%}" href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="icon-trash icon-white"></i>
                <span>$btn_delete</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>
EOF;
	}
}
