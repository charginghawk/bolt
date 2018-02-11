<?php

namespace Bolt;

use Gregwar\Image\Image;
use Gregwar\Image\GarbageCollect;
use ColorThief\ColorThief;
use PHPExif\Exif;
use PHPExif\Reader\Reader as ExifReader;


class Images {


  function __construct() {
    // @todo: update to use Bolt manifest data
    $lastRunLog = getcwd() . '/www/last-run.log';


    /**
    * Handle garbage collection w/ the temporary images generated locally
    */
    if (file_exists($lastRunLog)) {
      $lastRun = file_get_contents($lastRunLog);
      //its been more than a day so run our cleanup task
      if (time() - $lastRun >= 86400) { // @todo: expose cache duration as config option?


        // This could be a cron called each day @3:00AM for instance
        // Removes all the files from ../cache that are more than 30 days
        // old. A verbose output will explain which files are deleted

        GarbageCollect::dropOldFiles(getcwd() .'/cache', 30, true);

        //update lastrun.log with current time
        file_put_contents($lastRunLog, time());
      }
    } else {
      // If this is the first time we're running our cleanup task, create the initial cache file
      file_put_contents($lastRunLog, time());
    }
  }




  // @todo: update to support publicDir via Bolt manifest data
  public static function generate_base64_image_placeholder($relativeImagePath) {
    $absoluteImagePath = Utils::get_absolute_path($relativeImagePath);

    if(file_exists($absoluteImagePath)){
      $fileExt = Utils::get_file_ext($absoluteImagePath);

      if (($fileExt != "jpg") && ($fileExt != "png")){
        return; // Skip over non-jpg or png files.
      }

      $base64ImagePlaceholder = Image::open($absoluteImagePath)->resize('16,16')->smooth('1')->jpeg($quality = 50);

      return Image::open($base64ImagePlaceholder)->inline();
    }
  }


  // Converts an RGB color to hex
  public static function rgb2hex($rgb) {
    $hex = "#";
    $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
    $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
    $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);
    return $hex; // returns the hex value including the number sign (#)
  }



  // @todo: update to support publicDir via Bolt manifest data
  public static function calculate_average_image_color($relativeImagePath) {
    // If this isn't a production compile, let's not do this long very memory intensive process.
    if (getenv('NODE_ENV') !== 'production') {
      // @todo: update to point to Bolt color swatch value
      return 'hsl(233, 33%, 97%)'; // lightest gray from our colors to use as default when in dev mode
    }

    $absoluteImagePath = Utils::get_absolute_path($relativeImagePath);

    if(file_exists($absoluteImagePath)){
      $fileExt = Utils::get_file_ext($absoluteImagePath);

      if (($fileExt != "jpg") && ($fileExt != "png")){ // Skip over non-jpg or png files.
        return;
      }

      // Resize and optimize the image before running through ColorThief
      $resizedImage = \Gregwar\Image\Image::open($absoluteImagePath)->resize('640,640')->jpeg($quality = 50);
        $color = ColorThief::getColor($resizedImage, 5);
        return self::rgb2hex($color);
      // }
    } else {
      return;
    }
  }


  public static function get_image_dimensions($relativeImagePath) {
    $absoluteImagePath = Utils::get_absolute_path($relativeImagePath);

    if (file_exists($absoluteImagePath)){
      $size = getimagesize($absoluteImagePath);
      return ($size[0]);
    }
  }


  // @todo: how best should we handle remote image urls?
  public static function calculate_image_aspect_ratio($relativeImagePath, $heightOrWidthRatio = 'width') {
    $absoluteImagePath = Utils::get_absolute_path($relativeImagePath);

    if (file_exists($absoluteImagePath)){
      $fileExt = Utils::get_file_ext($absoluteImagePath);

      if ($fileExt == "svg"){
        $svgfile = simplexml_load_file($filePath);

        $viewport = explode(" ", $svgfile['viewBox']);
        $svgHeight = $svgfile['height']; // if it exists
        $svgWidth = $svgfile['width']; // if it exists
        $height = '';
        $width = '';

        // If the SVG height / width values exist, use those first
        if ($svgHeight && $svgWidth) {
          $height = $svgHeight;
          $width = $svgWidth;

        // Otherwise try to calculate the aspect ratio via the viewport
        } else if ($viewport[3] && $viewport[2]){
          $height = $viewport[3];
          $width = $viewport[2];
        }

        // Only return a ratio value if we have the data to back it up
        if ($height != '' && $width != ''){
          if ($heightOrWidthRatio == 'width'){
            return $width;
          } else {
            return $height;
          }
        }

      } else if (($fileExt == "jpg") || ($fileExt == "png")){
        // Get the dimensions of the image
        $size = getimagesize($absoluteImagePath);

        if ($heightOrWidthRatio == 'width'){
          return $size[0];
        } else {
          return $size[1];
        }
      }
    } else {
      // @todo: throw error if image path can't be found
    }
  }
}
