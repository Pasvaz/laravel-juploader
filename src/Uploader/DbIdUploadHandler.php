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

class DbIdUploadHandler extends BaseUploadHandler implements iUploaderHandler
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
        $files = $this->folder->mapPicturesCallback(function ($file_name, $id) use ($caller)
        { 
            return $caller->get_file_object($file_name, $id); 
        });
        return $files;
    }

    public function get_file_object($file_name, $id = 0) 
    {
        $file_path = path('public') . DS . $this->folder->album_path . DS . $file_name;
        if (is_file($file_path) && $file_name[0] !== '.') 
        {
            $file = new \stdClass();
            $file->name = $file_name;
            $file->id = $id;
            $file->size = $this->get_file_size($file_path);
            $file->url = $this->get_download_url($file->name);

            foreach($this->options['image_versions'] as $version => $options) {
                if (!empty($version)) {
                    if (is_file($this->get_upload_path($file_name, $version))) {
                        $file->{$version.'_url'} = $this->get_download_url(
                            $file->name,
                            $version
                        );
                    }
                }
            }
            $this->set_file_delete_properties($file);
            return $file;
        }
        return null;
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

    public function file_uploaded_sucessfully($file, $file_path) 
    {
        $file->id=0;
        if (!isset($file->error) 
            and isset($file->complete) 
            and $file->complete === true)
        {
            $pic = $this->folder->pictures()->insert(array('file_name' => $file->name));
            $file->id = $pic->id;
        }

        $this->Files[] = array('file_id' => $file->id, 'file_name' => $file->name, 'file_path' => $file_path);
    }

    protected function set_file_delete_properties($file) {
        $file->delete_url = $this->options['script_url']
            .'?id='.$file->id;
        $file->delete_type = $this->options['delete_type'];
        if ($file->delete_type !== 'DELETE') {
            $file->delete_url .= '&_method=DELETE';
        }
        if ($this->options['access_control_allow_credentials']) {
            $file->delete_with_credentials = true;
        }
    }

    public function delete($print_response = true) 
    {
        $this->operation = iUploaderHandler::DELETE;
        $album_path = path('public') . DS . $this->folder->album_path;

        $file_id = intval($_GET['id']);
        $picture = $this->folder->pictures()->find($file_id);
        $this->folder->pictures()->find($file_id)->delete();

        $file_name = $picture->file_name;
        $file_path = $album_path . DS . $file_name;
        $this->Files = array( array('file_name' => $file_name, 'file_path' => $file_path) );
        $this->Success = is_file($file_path) && $file_name !== '.' && unlink($file_path);
        
        if ($this->Success) {
            foreach($this->options['image_versions'] as $version => $options) 
            {
                if (!empty($version)) 
                {
                    $version_path = empty($version) ? '' : $version.'/';

                    $file = $album_path . DS . $version . DS . $file_name;
                    if (is_file($file)) unlink($file);
                }
            }
        }
        return $this->generate_response(array('success' => $this->Success), $print_response);
    }
}