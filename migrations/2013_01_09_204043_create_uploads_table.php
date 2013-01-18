<?php

class juploade_create_uploads_table {

	/**
	 * Just an example to show how to handle 
	 * the databbase insertion for uploads
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('albums', function($table) {
			if (Config::get('database.default')=='mysql')
				$table->engine = 'InnoDB';
			$table->create();
			$table->increments('id');
			$table->string('album_name', 100);
			$table->text('album_path');
			$table->timestamps();
		});

		Schema::table('pictures', function($table) {
			if (Config::get('database.default')=='mysql')
				$table->engine = 'InnoDB';
			$table->create();
			$table->increments('id');
			$table->integer('album_id')->unsigned();
			$table->string('file_name', 256)->index();
			$table->timestamps();
			$table->foreign('album_id')->references('id')->on('albums')->on_delete('cascade')->on_update('cascade');
		});

		DB::table('albums')->insert(array(
			'id' => 1,
			'album_path' => 'bundles/juploader/uploads/db/',
			'album_name' => 'Default Album',
			'created_at' => new \DateTime,
			'updated_at' => new \DateTime,
			));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pictures');
		Schema::drop('albums');
	}

}