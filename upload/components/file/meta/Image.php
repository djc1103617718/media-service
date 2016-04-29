<?php

namespace upload\components\file\meta;

class Image extends Meta
{
    /**
     * 根据图片自身60进制gps属性计算100进制GPS的经纬度属性
     *
     * @param string $gps gps60进制的经度或者纬度的属性
     * @return int gps的经度或者纬度
     */
    public static function CalculateGps($gps)
    {
        $gpsArray = explode(', ', $gps);
        $num = count($gpsArray);
        $arrayA = [];
        for ($i = 0; $i < $num; $i++) {
            $array = explode('/', $gpsArray[$i]);
            $arrayA[] = $array['0'];
        }
        $d = intval($arrayA['0']);
        $s = intval($arrayA['1'])/60;
        $m = (intval($arrayA['2'])/60)/10000;
        $gps = $d + $s +$m;
        return $gps;
    }

    /**
     * 获得文件gps的四个属性:经度/纬度/宽度/高度
     *
     * @param string $fileName 文件名
     * @return array gps的属性
     */
    public static function getGps($fileName)
    {
        list($width, $height) = getimagesize($fileName);
        $imagick = new \Imagick($fileName);
        $result = $imagick->getImageProperties("exif:*");
        if (isset($result['exif:GPSLatitude']) && isset($result['exif:GPSLongitude'])) {
            $GPSLatitudeRef = $result['exif:GPSLatitudeRef'];
            $GPSLongitudeRef = $result['exif:GPSLongitudeRef'];
            $gpsLatitude = self::CalculateGps($result['exif:GPSLatitude']);
            $gpsLongitude = self::CalculateGps($result['exif:GPSLongitude']);
            if ($GPSLatitudeRef !== 'N') {
                $gpsLatitude = -$gpsLatitude;
            }
            if ($GPSLongitudeRef !== 'E') {
                $gpsLongitude = -$gpsLongitude;
            }
        } else {
            $gpsLatitude = null;
            $gpsLongitude = null;
        }

        return $gpsArray = [
            'latitude' => $gpsLatitude,
            'longitude' => $gpsLongitude,
            'width' => $width,
            'height' => $height
        ];
    }

    /**
     * @param $filename
     * @return array
     */
    public function getImageMeta($filename)
    {
        return ['meta' => self::getGps($filename)];
    }
}
