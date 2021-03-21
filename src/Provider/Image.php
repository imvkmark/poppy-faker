<?php

namespace Poppy\Faker\Provider;

use InvalidArgumentException;
use RuntimeException;

/**
 * Depends on image generation from http://fakeimg.pl/
 */
class Image extends Base
{

    /**
     * Generate the URL that will return a random image
     *
     * Set randomize to false to remove the random GET parameter at the end of the url.
     * https://fakeimg.pl/
     * @param integer     $width
     * @param integer     $height
     * @param string      $font_color
     * @param string      $bg_color
     * @param string|null $word
     * @param string      $font noto/lobster
     * @return string
     * @example 'http://fakeimg.pl/640x480'
     */
    public static function imageUrl($width = 640, $height = 480, $word = '', $font_color = '282828', $bg_color = 'eae0d0', $font = ''): string
    {
        $baseUrl = "https://fakeimg.pl/";
        $url     = "{$width}x{$height}/";

        if ($font_color) {
            $url .= "{$font_color}/{$bg_color}";
        }

        $url .= '?';

        if ($word) {
            $url .= 'text=' . urlencode($word) . '&';
        }
        if ($font) {
            $url .= 'font=' . $font . '&';
        }

        return $baseUrl . $url;
    }

    /**
     * 头像URL
     * https://pravatar.cc/
     * @param int    $size
     * @param string $type
     * @return string
     */
    public static function avatarUrl($size = 300, $type = 'rand')
    {
        $baseUrl = "https://i.pravatar.cc/";
        if ($size > 1000) {
            $size = 1000;
        }
        $url = $size;

        $url .= '?';
        if ($type === 'girl') {
            $images = array_merge([1, 5, 9, 10, 16], range(19, 32), range(36, 49));
        }
        elseif ($type === 'boy') {
            $images = array_merge([2, 3, 6, 7, 8, 11, 12, 13, 14, 15, 17, 18, 33], range(50, 70));
        }
        else {
            $images = range(1, 70);
        }
        shuffle($images);
        $url .= 'img=' . current($images);
        return $baseUrl . $url;
    }


    /**
     * Svg Url
     * https://avatars.dicebear.com/
     * @param int    $width
     * @param int    $height
     * @param string $type
     * @return string
     */
    public static function svgUrl($width = 300, $height = 300, $type = 'bottts')
    {
        $baseUrl = "https://avatars.dicebear.com/api/";
        $url     = "$type/" . self::randomNumber(5) . '.svg';
        $url     .= '?';
        if ($width) {
            $url .= "width=" . $width . '&';
        }
        if ($height) {
            $url .= "height=" . $height . '&';
        }
        $url = rtrim($url, '&');
        return $baseUrl . $url;
    }

    /**
     * Download a remote random image to disk and return its location
     *
     * Requires curl, or allow_url_fopen to be on in php.ini.
     *
     * @param null $dir
     * @param int  $width
     * @param int  $height
     * @param bool $fullPath
     * @return false|RuntimeException|string
     * @example '/path/to/dir/13b73edae8443990be1aa8f1a483bc27.jpg'
     */
    public static function image($dir = null, $width = 640, $height = 480, $fullPath = true)
    {
        $dir = is_null($dir) ? sys_get_temp_dir() : $dir; // GNU/Linux / OS X / Windows compatible
        // Validate directory path
        if (!is_dir($dir) || !is_writable($dir)) {
            throw new InvalidArgumentException(sprintf('Cannot write to directory "%s"', $dir));
        }

        // Generate a random filename. Use the server address so that a file
        // generated at the same time on a different server won't have a collision.
        $name     = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
        $filename = $name . '.jpg';
        $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

        $url = static::phUrl($width, $height);

        // save file
        if (function_exists('curl_exec')) {
            // use cURL
            $fp = fopen($filepath, 'w');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            $success = curl_exec($ch) && curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200;
            fclose($fp);
            curl_close($ch);

            if (!$success) {
                unlink($filepath);

                // could not contact the distant URL or HTTP error - fail silently.
                return false;
            }
        }
        elseif (ini_get('allow_url_fopen')) {
            // use remote fopen() via copy()
            copy($url, $filepath);
        }
        else {
            return new RuntimeException('The image formatter downloads an image from a remote HTTP server. Therefore, it requires that PHP can request remote hosts, either via cURL or fopen()');
        }

        return $fullPath ? $filepath : $filename;
    }
}
