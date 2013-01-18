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

class FileUploadHandler extends BaseUploadHandler implements iUploaderHandler
{
    /**
     * These methods are handled by the BaseUploadHandler
     * 
     * public function Start();
     * public function get_response();
     * public function get_headers();
     * public function set_option(string $key, string $value);
     * 
     * Actually the BaseUploadHandler itself already
     * handles the files so really nothing to do here.
     * 
    */
    
    function __construct($options, $arguments = null) 
    {
        parent::__construct($options);
    }
}