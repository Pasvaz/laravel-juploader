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

interface iUploaderHandler
{
	const DOWNLOAD = 'DOWNLOAD';
	const UPLOAD = 'UPLOAD';
	const DELETE = 'DELETE';
	const GET = 'GET';
	const UNKNOWN = 'UNKNOWN';

	public function Start();
	public function get_response();
	public function get_body();
	public function get_headers();
}