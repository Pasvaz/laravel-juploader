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

class UploadServer implements iUploaderHandler
{
	protected $Uploader;
	protected $UploaderClass;
	protected $UploaderOptions;
	protected $UploaderArguments;

	function __construct($uploader, $arguments, $options) 
    {
        $this->UploaderClass = $uploader;
        $this->UploaderOptions= $options;
        $this->UploaderArguments = $arguments;
    }

    public function Start()
    {
    	$this->Uploader = new $this->UploaderClass($this->UploaderOptions, $this->UploaderArguments);
        //$this->Uploader->initialize();
    }
    
    public function get_response()
    {
		$this->check_started();
        return $this->Uploader->get_response();
    }

    public function get_body()
    {
		$this->check_started();
        return $this->Uploader->get_body();
    }

    public function get_headers()
    {
		$this->check_started();
        return $this->Uploader->get_headers();
    }

    public function with_option($key, $value)
    {
        $this->UploaderOptions[$key] = $value;
        return $this;
    }

    public function with_argument($argument)
    {
        $this->UploaderArguments = $argument;
        return $this;
    }

    public function with_uploader($uploader)
    {
        $this->UploaderClass = $uploader;
        return $this;
    }

    private function check_started()
    {
    	if (!$this->Uploader)
            throw new \Exception("The Upload Server has not been started!");
    }
}