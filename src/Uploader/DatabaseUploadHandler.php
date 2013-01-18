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

class DatabaseUploadHandler extends BaseUploadHandler implements iUploaderHandler
{
    protected $folder;

    /**
     * These methods are handled by the BaseUploadHandler
     * 
     * public function Start();
     * public function get_response();
     * public function get_headers();
     * public function set_option(string $key, string $value);
    */

    function __construct($options, $arguments = null) 
    {
        $folder = $arguments;
        if (!($folder instanceof \Album) and 
            (!is_numeric($arguments) or !($folder = \Album::find($arguments))) )
            throw new \Exception("DatabaseUploadHandler needs the Album id or the Album model to start!");

        $this->folder = $folder;
        $options['upload_dir'] = $folder->upload_dir;
        $options['upload_url'] = $folder->upload_url;

        parent::__construct($options);
    }

    protected function get_file_objects($iteration_method = 'get_file_object') {
        $upload_dir = $this->get_upload_path();
        if (!is_dir($upload_dir)) return array();

        $caller = $this;
        $files = $this->folder->mapPicturesCallback(function ($file_name) use ($caller)
        { 
            return $caller->get_file_object($file_name); 
        });
        return $files;
    }

    public function get_file_object($file_name) 
    {
        return parent::get_file_object($file_name);
    }

    protected function count_file_objects() 
    {
        $counter = 0;
        foreach ($this->folder->getAlbumPictures() as $pic) 
        {
            if ($this->is_valid_file_object($pic)) $counter++;
        }
        return $counter;
    }

    public function post($print_response = true) 
    {
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            return $this->delete($print_response);
        }

        $result = parent::post($print_response);
        $files_name = $this->options['param_name'];
        if (isset($result[$files_name]))
        {
            foreach ($result[$files_name] as $key => $value) 
            {
                if (!isset($value->error) 
                    and isset($value->complete) 
                    and $value->complete === true)
                    $this->folder->pictures()->insert(array('file_name' => $value->name));
            }
        }
        return $result;
    }

    private function get_file_path($file_name)
    {
        return $this->folder->file_path. DS . $file_name;
    }

    public function delete($print_response = true) 
    {
        $result = parent::delete($print_response);

        if ($result['success'] === true)
        {
            $this->folder->deletePicturesByName($this->Files);
        }

       return $result;
    }
}