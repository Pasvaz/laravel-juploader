# Laravel jUploader
A jQuery-File-Upload bundle for the Laravel Framework

## Requirements
* [Bootstraper Enhanced Bundle](https://github.com/Pasvaz/bootstrapper) OR [Bootstraper Bundle](https://github.com/patricktalmadge/bootstrapper/)

----
<a name='installation'></a>
## Installation

Type the following in your Terminal :

```bash
php artisan bundle:install juploader
```

Add the following to your `bundles.php` file :

```php
'juploader' => array('handles' => 'upload'),
```

Install Bootstrapper if you didn't already :

```bash
php artisan bundle:install bootstrapper
```
I use my own Bootstrapper, you can take it from [here](https://github.com/Pasvaz/bootstrapper)

And finally publish the bundle assets :

```bash
php artisan bundle:publish
```

Visit http://127.0.0.1/upload and play with the demos in order to get used with jUploader

Alternatively you can download it directly from GitHub:
http://github.com/Pasvaz/laravel-juploader


----

<a name='usage'></a>
## Usage

### Assets

Load these Assets in order to make it working

```php
{{ Asset::container('bootstrapper')->styles() }}
{{ Asset::container('juploader')->styles() }}
{{ Asset::container('juploader-gallery')->styles() }}

{{ Asset::container('bootstrapper')->scripts() }}
{{ Asset::container('juploader')->scripts() }}
{{ Asset::container('juploader-gallery')->scripts() }}
/* The gallery is optional */
```


### Javascripter

The Javascripter is very important, I introduced it recentely in order to let the developer setup the jQuery-file-uploader at runtime, before I used the standard main.js, but if you wanted to setup several uploaders with different setting you had to produce one main.js for each uploader, or change the javascript in the page. Using the Javascripter class, you don't have to worry about it.

```php
    {{ Uploader\Javascripter::activate_uploader() }}
```
Just put this line somewhere in your page and it will produce the javascript that makes the jQuery-uploader work.
You can also change the options to fit your needs using the file ```/config/client.php``` but if you use multiple uploaders in your website you might want to set them up with differents options, so you can do something like this:

```php
<? 
// change the url of the uploader and the Form Id
{{ Uploader\Javascripter::with_option('url','/upload/dbupload')
                          ->with_option('formId','dbfileupload')
                          ->activate_uploader() }}

// change the url of the uploader and the Form Id
{{ Uploader\Javascripter::with_option('url','/upload/dbupload')
                          ->with_option('formId','dbfileupload')
                          ->activate_uploader() }}

// change the url of the uploader, the dilesContainer and makes the files to be uploaded with a single click
echo Uploader\Javascripter::with_option('url','/album/upload/')
                              ->with_option('filesContainer','filesContainer')
                              ->with_option('autoUpload', true)
                              ->activate_uploader();
?>
```
The ```/config/client.php``` contains a short description for each option, but I strongly suggest you to read the original [docs](https://github.com/blueimp/jQuery-File-Upload/wiki/Setup) to understand what every option does.


### Markup
Setup a multipart/form-data Form:

```html
<form id="fileupload" action="{{ URL::to_route('upload') }}" method="POST" enctype="multipart/form-data">
...
</form>
```
Create the ButtonBar inside the Form:

```php
{{Uploader\ButtonBar::create()}}
```

And finally add the templates:

```php
{{ Uploader\Templater::showAll() }}
```

There you go, you are done! The code below is enough to reproduce this [Demo](http://blueimp.github.com/jQuery-File-Upload/)

```php
<form id="fileupload" action="{{ URL::to_route('upload') }}" method="POST" enctype="multipart/form-data">

{{Uploader\ButtonBar::create()}}

</form>

{{ Uploader\Templater::showAll() }}
```


## Customization
You can customize every single element of the Uploader, here some example:

This create an Uploader without two buttons: BUTTON_CANCEL and BUTTON_SELECTALL

```php
<form id="fileupload" action="{{ URL::to_route('upload') }}" method="POST" enctype="multipart/form-data">
{{Uploader\ButtonBar::create()->delete_button(Uploader\Button::BUTTON_CANCEL)->delete_button(Uploader\Button::BUTTON_SELECTALL)}}
</form>
```

This create an Uploader with just two buttons: BUTTON_FILE and BUTTON_START.
Using <code>create(false, false, false)</code> the button bar will start with no buttons and no global loader bar.
Once the ButtonBar is created, it'll add the two buttons above using the function <code>with_button</code>

```php
<form id="fileupload" action="{{ URL::to_route('upload') }}" method="POST" enctype="multipart/form-data">
<?
$buttonFile = \Uploader\Button::fileButton()->with_label('Select File');
$buttonStart = new \Uploader\Button('Upload Now', "icon-upload icon-white", Uploader\Button::BUTTON_START, 'btn-success');
echo Uploader\ButtonBar::create(false, false, false)
    ->with_button(Uploader\Button::BUTTON_FILE, $buttonFile)
    ->with_button(Uploader\Button::BUTTON_START, $buttonStart);
?>
</form>
```


## Upload Handler
jQuery-File-Upload, ships with a basic ```UploadHandler.php```, I took it as base to develop my own handler and, in order to let you extend it, I created an interface called iUploadHandler.
This bundle ships with three handlers, ```FileUploadHandler.php```, ```DatabaseUploadHandler.php``` and ```DbIdUploadHandler.php```, they can be used as they are or can be extended themself.
The whole upload process is controlled by the *UploadServer.php*, it takes care of the whole upload and generally you can just use it as it is.

The ```UploadServer.php``` uses the ```/config/settings.php``` to load the proper UploadHandler and set it up. Your controller should just use the ```UploadServer``` class.
By default, the ```UploadServer``` uses the ```FileUploadHandler```, so, if you don't change it, you'll upload and magage your files using the file system, this is the basic usage:

```php
<?
  // BASIC UPLOAD
  $uploader = IoC::resolve('Uploader');
  $uploader->Start();
  return $uploader->get_response();

  // OR USING THE SHORT CUT
  return IoC::resolve('Uploader')->Start()->get_response();
?>
```
This is enough to make it work. Just load the Uploader by the IoC container, ```Start()``` it and it'll handle the upload, eventually you can get and send to Laravel the result using the methos ```get_response()``` that renders a Laravel\Response using the proper headers and format.

As usual, the UploadServer can be customized by editing the file ```/config/settings.php``` or at runtime doing something like this:

```php
<?
  $uploader = IoC::resolve('Uploader');
    $uploader
      ->with_option('override_name' , 'UseAfixedName')
      ->with_option('image_versions', 
            array('fixed' => array('max_width' => 64,'max_height' => 64, 'fixed_size' => true))
      ->Start();
  return $uploader->get_response();
?>
```

### Database

Never the less, you can use the **DatabaseUploadHandler**, it works as the FileUploadHandler but it uses your DB:connection to manage files. The files will be still stored into the file system, however the Database is used to serve them to the user and restrict the accesses.
In order to use the Database, you **must** run the migration, as usual run the following artisan task:

```bash
php artisan migrate juploader
```
Doing this you'll create two tables into your database: ```albums``` and ```pictures```. This allows you much more flexibility handling the files. Think at the Album like a logic folder, regardless it's path, it separe the files and serve to the user only those inside the chosen album. You could create one album for all the users, one album per user, or even several album for the same user, it's up to you.

```php
<?
    $uploader = IoC::resolve('Uploader');
    $uploader
      ->with_uploader('Uploader\DatabaseUploadHandler')
      ->with_argument('1')
      ->with_option('script_url' , URL::to_action('juploader::dbupload@index'))
      ->Start();
    return $uploader->get_response();
?>
```
The above example (it's used by the dbupload.php controller) basically takes all the uploads inside one folder, the default one, let's see what it does row per row: ```with_uploader('Uploader\DatabaseUploadHandler')``` it says to the UploadServer to use the DatabaseUploadHandler instead of the one configured inside the ```/config/settings.php```
```with_argument('1')``` here is where you setup the folder, by default I used one album for all the users, the Argument is the album ID or the album model itself.
```with_option('script_url' , URL::to_action('juploader::dbupload@index'))``` This option just change the uploader url, assuming that you are using /upload for the main demo, you need to change it in order to run more than one upload in the same website. The 'script_url' is where your controller listen for uploads requestes.
Let's make another example, like if you want to split the files for each user. All you need is to create one album for each user, for the sake of the semplicity, let's assume the the albums have the same ID as the User, it's not realistic but it's simple. I don't care about the album_path right now, because the files can be stored in the same path, the DatabaseUploadHandler takes care of serving only the ones belonging to the selected album. Here is the code:

```php
<?
    $uploader = IoC::resolve('Uploader');
    $uploader
      ->with_uploader('Uploader\DatabaseUploadHandler')
      ->with_argument(Auth::user()->id)
      ->Start();
    return $uploader->get_response();
?>
```
The magic is done by ```with_argument(Auth::user()->id)```, it used the user IDs to get their own album. As we said before, it assumes that you create one record for each user in the albums table and gave to the albums the same ID of the user.



----

# jQuery File Upload
## Demo
[jQuery-File-Upload](http://blueimp.github.com/jQuery-File-Upload/)

## Setup
[How to setup the plugin on your website](https://github.com/blueimp/jQuery-File-Upload/wiki/Setup)

## Features
* **Multiple file upload:**  
  Allows to select multiple files at once and upload them simultaneously.
* **Drag & Drop support:**  
  Allows to upload files by dragging them from your desktop or filemanager and dropping them on your browser window.
* **Upload progress bar:**  
  Shows a progress bar indicating the upload progress for individual files and for all uploads combined.
* **Cancelable uploads:**  
  Individual file uploads can be canceled to stop the upload progress.
* **Resumable uploads:**  
  Aborted uploads can be resumed with browsers supporting the Blob API.
* **Chunked uploads:**  
  Large files can be uploaded in smaller chunks with browsers supporting the Blob API.
* **Client-side image resizing:**  
  Images can be automatically resized on client-side with browsers supporting the required JS APIs.
* **Preview images:**  
  A preview of image files can be displayed before uploading with browsers supporting the required JS APIs.
* **No browser plugins (e.g. Adobe Flash) required:**  
  The implementation is based on open standards like HTML5 and JavaScript and requires no additional browser plugins.
* **Graceful fallback for legacy browsers:**  
  Uploads files via XMLHttpRequests if supported and uses iframes as fallback for legacy browsers.
* **HTML file upload form fallback:**  
  Allows progressive enhancement by using a standard HTML file upload form as widget element.
* **Cross-site file uploads:**  
  Supports uploading files to a different domain with cross-site XMLHttpRequests or iframe redirects.
* **Multiple plugin instances:**  
  Allows to use multiple plugin instances on the same webpage.
* **Customizable and extensible:**  
  Provides an API to set individual options and define callBack methods for various upload events.
* **Multipart and file contents stream uploads:**  
  Files can be uploaded as standard "multipart/form-data" or file contents stream (HTTP PUT file upload).
* **Compatible with any server-side application platform:**  
  Works with any server-side platform (PHP, Python, Ruby on Rails, Java, Node.js, Go etc.) that supports standard HTML form file uploads.

## License
Released under the [MIT license](http://www.opensource.org/licenses/MIT).
