<?php
chdir(__DIR__);

ini_set('display_errors', 'on'); // Turn on display

$rewriteDirectories = [
    '/css/', '/img/', '/js/', '/vendors/'
];

/*
 * This shouldn't work like this.  This is from a separate project and will be replaced with a more common setup soon.
 * i.e. if(file_exists(...)) return false;
 */
foreach ($rewriteDirectories as $dir) {
    if (substr($_SERVER['REQUEST_URI'], 0, strlen($dir)) === $dir) {
        $realFilename = '../public' . $_SERVER['REQUEST_URI'];

        if (is_file($realFilename) && is_readable($realFilename)) {

            $ext = strtolower(substr($realFilename, strrpos($realFilename, '.')));
            if($ext === '.css') {
                header("Content-Type: text/css");
            } elseif($ext === '.js') {
                header("Content-Type: application/javascript");
            } elseif($ext === '.png') {
                header("Content-Type: image/png");
            } elseif($ext === '.jpg') {
                header("Content-Type: image/jpeg");
            } else {
                $z = fopen('php://stdout', 'ab');
                fwrite($z, "NO MIME TYPE FOR EXTENSION: $ext");
            }

            $fp = fopen($realFilename, 'rb');
            fpassthru($fp);
            fclose($fp);
            exit;
        }
        // return false;
    }
}

require 'index.php';

