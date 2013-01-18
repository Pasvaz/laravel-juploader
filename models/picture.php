<?php

class Picture extends Eloquent 
{
	public static $table = 'pictures';
	
	/**
	 * Belongs to `albums` table.
	 *
	 * @access public
	 * @return Album
	 */
	public function album()
	{
		return $this->belong_to('Album');
	}
}