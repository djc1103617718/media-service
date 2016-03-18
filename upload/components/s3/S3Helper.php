<?php

namespace upload\components\s3;

use yii;
use common\dict\Dict;

/**
 * Class S3Helper
 * @package upload\components\s3
 */
class S3Helper
{
    /**
     * 往S3上面上传数据
     *
     * @param $sub
     * @param $fileName
     * @return mixed
     */
    public static function putS3($fileName, $sub)
    {
        $awssdk = Yii::$app->awssdk;
        $contentType = mime_content_type($fileName);
        $key = self::getKey($fileName);
        $bucket = $awssdk->sdkOptions['bucket'];
        $result = $awssdk->s3Client->putObject([
            'Bucket' => $bucket,
            'Key' => "$sub/$key",
            'SourceFile' => $fileName,
            'ContentType' => $contentType,
            'ACL' => 'authenticated-read',
        ]);
        return $result;
    }

    /**
     * 将S3上临时存放的图片复制到main目录下去
     *
     * @param string $fileName 文件名
     * @param string $targetSub 要复制到目标文件目录
     * @param string $sourceSub 源文件目录
     * @return mixed
     */
    public static  function copyS3($fileName, $targetSub, $sourceSub)
    {
        $key = self::getKey($fileName);
        $contentType = mime_content_type($fileName);
        $sourceKeyname = "$sourceSub/$key";
        $targetKeyname = "$targetSub/$key";
        $bucket = Yii::$app->awssdk->sdkOptions['bucket'];
        $result = Yii::$app->awssdk->s3Client->copyObject(array(
            'Bucket' => $bucket,
            'Key' => $targetKeyname,
            'CopySource' => "{$bucket}/{$sourceKeyname}",
            'ContentType' => $contentType,
            'ACL' => 'authenticated-read',
        ));
        return $result;
    }

    /**
     * 根据文件名获得要创建的文件目录和文件名
     *
     * @param $fileName
     * @return string
     */
    public static function getKey($fileName)
    {
        $md5 = md5_file($fileName);
        $sha1 = sha1_file($fileName);
        $key1 = substr($md5, 0, 2);
        $key2 = substr($md5, 2, 2);
        $keyArray = [$md5, $sha1];
        $key3 = join('_', $keyArray);
        $key = "$key1/$key2/$key3";
        return $key;
    }

    /**
     * 计算GPS的经纬度
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
     * 计算文件类型的常量
     *
     * @param string $mimeContentType 文件类型
     * @return int|string 文件类型的常量
     */
    public static function getType($mimeContentType)
    {
        $type = null;
        $image_array = explode('/', $mimeContentType);
        // 判断文件类型的type
        $mimeType = $image_array['0'];
        $dict = new Dict();
        $dictArray = $dict::$objectTypes;
        foreach ($dictArray as $key => $value) {
            if ($value === $mimeType) {
                $type = $key;
            }
        }
        return ['mimeType' => $mimeType, 'type' => $type];
    }
}
