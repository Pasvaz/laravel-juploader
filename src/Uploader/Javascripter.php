<?php
namespace Uploader;

/**
 * Laravel jUploader bundle
 *
 * @package    Uploader
 * @author     Pasquale Vazzana - <pasqualevazzana@gmail.com>
 * @license    MIT License <http://www.opensource.org/licenses/mit>
 *
 * @see        https://github.com/Pasvaz/laravel-juploader
 */

class Javascripter
{

    /**
     * @var array 	Javascript code queue
     */
    static private $Options = array();

    /**
     *     DO NOT EDIT THIS ARRAY: $DefaultOptions
     */
    static private $DefaultOptions = array(
        'formId' => 'fileupload',
        'url' => '/upload/upload/',
        'fileInput' => 'undefined',
        'replaceFileInput' => true,
        'paramName' => 'undefined',
        'singleFileUploads' => true,
        'limitMultiFileUploads' => 'undefined',
        'sequentialUploads' => false,
        'limitConcurrentUploads' => 'undefined',
        'forceIframeTransport' => false,
        'redirect' => 'undefined',
        'redirectParamName' => 'undefined',
        'postMessage' => 'undefined',
        'multipart' => true,
        'maxChunkSize' => 'undefined',
        'uploadedBytes' => 'undefined',
        'recalculateProgress' => true,
        'progressInterval' => 100,
        'bitrateInterval' => 500,
        'autoUpload' => false,
        'maxNumberOfFiles' => 'undefined',
        'maxFileSize' => 'undefined',
        'minFileSize' => 'undefined',
        'acceptFileTypes' =>  '/.+$/i',
        'previewSourceFileTypes' => '/^image\/(gif|jpeg|png)$/',
        'previewSourceMaxFileSize' => 5000000, // 5MB
        'previewMaxWidth' => 80,
        'previewMaxHeight' => 80,
        'previewAsCanvas' => true,
        'uploadTemplateId' => 'template-upload',
        'downloadTemplateId' => 'template-download',
        'filesContainer' => 'undefined',
        'prependFiles' => false,
        'dataType' => 'json',
    );

    /**
     * create the necessary javascript 
     * @return string 	The Javascript code
     */
    public static function activate_uploader($empty = true)
    {
        $clientOptions = array_merge( \Config::get('juploader::client'), static::$Options);

        $url = $clientOptions['url'];
        $formId = $clientOptions['formId'];
        $filesContainer = $clientOptions['filesContainer'];
        unset($clientOptions['url']);
        unset($clientOptions['formId']);
        unset($clientOptions['filesContainer']);

        $options = array_diff_assoc($clientOptions, static::$DefaultOptions);

        echo '<script type="text/javascript">';
        echo '$(function () { $(\'#'.$formId.'\').fileupload({';
        if (is_null($filesContainer))
            echo 'filesContainer: null, ';
        else if ($filesContainer !== 'undefined')
            echo 'filesContainer: $(\'.'.$filesContainer.'\'), ';
        echo 'url: '. static::js_quote($url);
        foreach ($options as $key => $value) {
            echo $key.': '. static::js_quote($value);
        }
        echo '});'.PHP_EOL;

        echo '$.ajax({ ';
        echo 'url: '. static::js_quote($url);
        echo 'dataType: '. static::js_quote($clientOptions['dataType']);
        echo 'context: $(\'#'.$formId.'\')[0]';
        echo '}).done(function (result) { $(this).fileupload(\'option\', \'done\').call(this, null, {result: result});';
        echo '});});'.PHP_EOL.'</script>'.PHP_EOL;

		if ($empty) static::$Options = array();
    }

    private static function js_quote($value)
    {
        if (is_null($value) or $value === 'null') return $value.'null, ';
        if (is_bool($value)) return (($value===true) ? 'true':'false').', ';
        if ($value == 'undefined' or is_numeric($value)) return $value.', ';
        return "'$value', ";
    }

    /**
     * Set options at runtime, it's chainable
     *
     * @param string $key       The option to change
     * @param array  $value     Its value
     *
     * @return Javascripter
     */
    public static function with_option($key, $value)
    {
        static::$Options[$key] = $value;
        return new static();
    }
}