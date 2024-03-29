<?php

namespace App\Utils;
use Illuminate\Support\Facades\Storage;

class Oss
{
    private static $_oss;

    protected function __construct(){
    }

    protected function __clone(){}

    public static function getInstance(){
        if (empty(self::$_oss)) {
            self::$_oss = Storage::disk('oss');
        }
        return self::$_oss;
    }
}

/*
 * // create a file
$disk->put('avatars/filename.jpg', $fileContents);

// check if a file exists
$exists = $disk->has('file.jpg');

// get timestamp
$time = $disk->lastModified('file1.jpg');
$time = $disk->getTimestamp('file1.jpg');

// copy a file
$disk->copy('old/file1.jpg', 'new/file1.jpg');

// move a file
$disk->move('old/file1.jpg', 'new/file1.jpg');

// get file contents
$contents = $disk->read('folder/my_file.txt');

// get file url
$url = $disk->getUrl('folder/my_file.txt');
*/
