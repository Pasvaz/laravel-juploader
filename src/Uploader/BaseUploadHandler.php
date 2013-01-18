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

abstract class BaseUploadHandler extends \UploadHandler implements iUploaderHandler
{
    /**
     * 	iUploaderHandler Methods
     */

    public function Start()
    {
        parent::initialize();
    }
    
    public function get_response()
    {
		return \Response::make($this->Body, 200, $this->Headers);
    }

    public function get_body()
    {
        return $this->Body;
    }

    public function get_headers()
    {
        return $this->Headers;
    }

	/**
   	 * @var boolean
	 */
	public $Success = false;
	public $Operation = iUploaderHandler::UNKNOWN;
	public $Files = array();

    protected $Headers = array();
    protected $Body = '';

    /**
     * 
     * UploaderHandler Overrides
     *
     */
    function __construct($options) 
    {
        $error_messages = \Lang::file('juploader', \Config::get('application.language'), 'errors');
        if (count($error_messages)==0) $error_messages = \Lang::file('juploader', 'en', 'errors');
        if (count($error_messages)>0) $this->error_messages = $error_messages;

        parent::__construct($options, true);
    }

    protected function body($str) 
    {
        $this->Body .= $str;
    }
    
    protected function header($str) 
    {
        $this->Headers[] = $str;
    }

    public function delete($print_response = true) 
    {
    	$this->operation = iUploaderHandler::DELETE;

        $file_name = $this->get_file_name_param();
        $file_path = $this->get_upload_path($file_name);
    	$this->Files = array( array('file_name' => $file_name, 'file_path' => $file_path) );
        $this->Success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
        
        if ($this->Success) {
            foreach($this->options['image_versions'] as $version => $options) 
            {
                if (!empty($version)) 
                {
                    $file = $this->get_upload_path($file_name, $version);
                    if (is_file($file)) 
                    {
                        unlink($file);
                    }
                }
            }
        }
        return $this->generate_response(array('success' => $this->Success), $print_response);
    }

    public function post($print_response = true) 
    {
        if (!isset($_REQUEST['_method']) or $_REQUEST['_method'] !== 'DELETE') 
            $this->operation = iUploaderHandler::UPLOAD;

        return parent::post($print_response);
    }

    public function file_uploaded_sucessfully($file, $file_path) 
    {
        $this->Files[] = array('file_name' => $file->name, 'file_path' => $file_path);
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
            $index = null, $content_range = null) 
    {
		$file = new \stdClass();
		$file->name = $this->get_file_name($name, $type, $index, $content_range);
		$file->size = $this->fix_integer_overflow(intval($size));
		$file->type = $type;
		$file->complete = false;

		if ($this->validate($uploaded_file, $file, $error, $index)) 
		{
		    $this->handle_form_data($file, $index);
		    $upload_dir = $this->get_upload_path();
		    if (!is_dir($upload_dir)) {
		        mkdir($upload_dir, $this->options['mkdir_mode'], true);
		    }
		    $file_path = $this->get_upload_path($file->name);
			$append_file = 	$content_range 
							&& is_file($file_path) 
							&& ($file->size > $this->get_file_size($file_path));

		    if ($uploaded_file && is_uploaded_file($uploaded_file)) {
		        // multipart/formdata uploads (POST method uploads)
		        if ($append_file) {
		            file_put_contents(
		                $file_path,
		                fopen($uploaded_file, 'r'),
		                FILE_APPEND
		            );
		        } else {
		            move_uploaded_file($uploaded_file, $file_path);
		        }
		    } else {
		        // Non-multipart uploads (PUT method support)
		        file_put_contents(
		            $file_path,
		            fopen('php://input', 'r'),
		            $append_file ? FILE_APPEND : 0
		        );
		    }

		    $file_size = $this->get_file_size($file_path, $append_file);
		    if ($file_size === $file->size) 
		    {
		    	$file->complete = true;

		    	if (isset($this->options['override_name']))
		    		$file->name = $this->override_file_name($file_path);

		        if ($this->options['orient_image']) 
		        {
		            $this->orient_image($file_path);
		        }

		        $file->url = $this->get_download_url($file->name);
		        foreach($this->options['image_versions'] as $version => $options)
		        {
		            if ($this->create_scaled_image($file->name, $version, $options)) 
		            {
		                if (!empty($version)) 
		                {
		                    $file->{$version.'_url'} = $this->get_download_url(
		                        $file->name,
		                        $version
		                    );
		                } else {
		                    $file_size = $this->get_file_size($file_path, true);
		                }
		            }
		        }

                $this->file_uploaded_sucessfully($file, $file_path);
		    } 
		    else if (!$content_range && $this->options['discard_aborted_uploads']) 
		    {
		        unlink($file_path);
		        $file->error = 'abort';
		    }
		    $file->size = $file_size;
		    $this->set_file_delete_properties($file);
		}
		return $file;
    }

    private function override_file_name($path)
    {
    	$path_parts = pathinfo($path);
		$file_path = $path_parts['dirname'] . DS;
		$basename = $path_parts['basename'];
		$file_name = $path_parts['filename'];
		$file_ext = '.' . $path_parts['extension'];

    	$change_name = $this->options['override_name'];
		if (is_callable($change_name))
	    	$newname = call_user_func($change_name, $file_name);
	    else if (is_string($change_name))
	    	$newname = $change_name;
	    else 
	    	return $basename;

    	$counter = 1;
    	do
		{
			$final_name = $newname . (($counter > 1) ? '('.$counter.')' : '') . $file_ext;
    		$counter++;
		}
		while( is_file($file_path . $final_name) );
		
		if ($final_name != $basename 
			and !empty($final_name)
			and @rename($path, $file_path . $final_name))
			return $final_name;
		else
	    	return $basename;
    }

    protected function create_scaled_image($file_name, $version, $options) 
    {
        $file_path = $this->get_upload_path($file_name);
        if (!empty($version)) {
            $version_dir = $this->get_upload_path(null, $version);
            if (!is_dir($version_dir)) {
                mkdir($version_dir, $this->options['mkdir_mode'], true);
            }
            $new_file_path = $version_dir.'/'.$file_name;
        } else {
            $new_file_path = $file_path;
        }

        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }

        $thumb_width = $options['max_width'];
        $thumb_height = $options['max_height'];
        $crop = isset($options['fixed_size']) && $options['fixed_size'];

        if ($crop)
        {
            $original_aspect = $img_width / $img_height;
            $thumb_aspect = $thumb_width / $thumb_height;

            if ( $original_aspect >= $thumb_aspect )
            {
               // If image is wider than thumbnail (in aspect ratio sense)
               $new_height = $thumb_height;
               $new_width = ( int ) ($thumb_height * $original_aspect);
            }
            else
            {
               // If the thumbnail is wider than the image
               $new_width = $thumb_width;
               $new_height = ( int ) ($thumb_width / $original_aspect);
            }
        }
        else
        {
            $scale = min(
                $thumb_width / $img_width,
                $thumb_height / $img_height
            );
            if ($scale >= 1) {
                if ($file_path !== $new_file_path) {
                    return copy($file_path, $new_file_path);
                }
                return true;
            }
            $new_width = $img_width * $scale;
            $new_height = $img_height * $scale;
        }

        $new_img = @imagecreatetruecolor($new_width, $new_height);
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                $image_quality = isset($options['jpeg_quality']) ?
                    $options['jpeg_quality'] : 75;
                break;
            case 'gif':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                $image_quality = null;
                break;
            case 'png':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                $image_quality = isset($options['png_quality']) ?
                    $options['png_quality'] : 9;
                break;
            default:
                $src_img = null;
        }

        if ($src_img == null)
            return false;

        //imagecopyresampled ( resource $dst_image , resource $src_image , 
        //int $dst_x , int $dst_y , 
        //int $src_x , int $src_y , 
        //int $dst_w , int $dst_h , 
        //int $src_w , int $src_h )
        if (! @imagecopyresampled($new_img, $src_img,
            0, 0, 
            0, 0, 
            $new_width, $new_height,
            $img_width, $img_height
        )) return false;

        if ($crop)
        {
            $center_x = ($new_width - $thumb_width) / 2; // Center the image horizontally
            $center_y = ($new_height - $thumb_height) / 2; // Center the image vertically
            $crop_img = @imagecreatetruecolor($thumb_width, $thumb_height);
            if (! @imagecopy($crop_img, $new_img,
                0, 0,
                $center_x, $center_y,
                $thumb_width, $thumb_height
            )) return false;            

            $success = $write_image($crop_img, $new_file_path, $image_quality);
            @imagedestroy($crop_img);
        }
        else
        {
            $success = $write_image($new_img, $new_file_path, $image_quality);
        }

        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($src_img);
        @imagedestroy($new_img);
        return $success;
    }
}
