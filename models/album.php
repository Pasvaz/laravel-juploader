<?php

class Album extends Eloquent 
{
	public static $table = 'albums';

	/**
	 * Has Many relationship to `pictures` table.
	 *
	 * @access public
	 * @return Picture
	 */
	public function pictures()
	{
		return $this->has_many('Picture');
	}

	/**
	 * Getter for upload_dir attributes.
	 * 
	 * @return string
	 */
	public function get_upload_dir()
	{
		return path('public').$this->get_attribute('album_path');
	}

	/**
	 * Getter for upload_url attributes.
	 * 
	 * @return string
	 */
	public function get_upload_url()
	{
		return URL::base().'/'.$this->get_attribute('album_path');
	}

	/**
	 * delete the pictures by name.
	 * 
	 * @return array
	 */
	public function deletePicturesByName(array $files)
	{
        foreach ($files as $file) 
        {
	        $file_name = $file['file_name'];
			$deleted_pictures = $this->pictures()->where('file_name', '=', $file_name)->delete();
        }
		return $deleted_pictures;
	}

	/**
	 * Get all the pictures of this folder.
	 * 
	 * @return array
	 */
	public function getAlbumPictures()
	{
		$pictures = array();
		$db_pictures = $this->pictures()->order_by('updated_at', 'desc')->get();
		foreach ($db_pictures as $value) 
		{
			$pictures[] = $value->file_name;
		}
		return $pictures;
	}

    /**
     * Iterate the pictures trough a callback
     * 
     * @param mixed $callback Description.
     *
     * @access public
     *
     * @return array
     */
	public function mapPicturesCallback($callback)
	{
		$pictures = array();
		$db_pictures = $this->pictures()->order_by('updated_at', 'desc')->get();

		foreach ($db_pictures as $value) 
		{
			if ($callback instanceof Closure)
			{
				$pictures[] = $callback($value->file_name, $value->id);
			}
		}
		return $pictures;
	}
}