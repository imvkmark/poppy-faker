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
     * @param string|null $word
     * @param string      $font_color
     * @param string      $bg_color
     * @param string      $font_size
     * @return string
     * @example https://jdc.jd.com/img/500x300?color=6190e8&text=poppy&textColor=ffffff
     */
    public static function imageUrl($width = 640, $height = 480, $word = '', $font_color = 'eae0d0', $bg_color = '282828', $font_size = ''): string
    {
        $baseUrl = "https://jdc.jd.com/img";
        $url     = "/{$width}x{$height}";

        $url .= '?';
        if ($font_color) {
            $url .= "textColor={$font_color}&";
        }

        if ($word) {
            $url .= 'text=' . urlencode($word) . '&';
        }

        if ($bg_color) {
            $url .= 'color=' . $bg_color . '&';
        }

        if ($font_size) {
            $url .= 'fs=' . $font_size . '&';
        }
        else {
            // min: 20 /max 100
            $size = (($width / 10) <= 14)
                ? 14
                : (($width / 10) >= 100 ? 100 : round($width / 10));
            $url  .= 'fs=' . $size . '&';
        }

        return $baseUrl . rtrim($url, '&?');
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

        $url = static::imageUrl($width, $height);

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
