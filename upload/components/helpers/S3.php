<?php

namespace upload\components\helpers;

use yii;

/**
 * Class S3
 * @package upload\components\s3
 */
class S3
{
    /**
     * 往S3上面上传数据
     *
     * @param $sub
     * @param $filename
     * @return mixed
     */
    public static function putS3($filename, $sub)
    {
        $awssdk = Yii::$app->awssdk;
        $contentType = mime_content_type($filename);
        $key = self::getKey($filename);
        $bucket = $awssdk->sdkOptions['bucket'];
        $result = $awssdk->s3Client->putObject([
            'Bucket' => $bucket,
            'Key' => $sub . '/' . $key,
            'SourceFile' => $filename,
            'ContentType' => $contentType,
            'ACL' => 'authenticated-read',
        ]);
        return $result;
    }

    /**
     * 将S3上临时存放的图片复制到main目录下去
     *
     * @param string $filename 文件名
     * @param string $targetSub 要复制到目标文件目录
     * @param string $sourceSub 源文件目录
     * @return mixed
     */
    public static  function copyS3($filename, $targetSub, $sourceSub)
    {
        $key = self::getKey($filename);
        $contentType = mime_content_type($filename);
        $sourceKeyname = $sourceSub . '/' . $key;
        $targetKeyname = $targetSub . '/' . $key;
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
     * 根据文件名获得在s3上创建的文件目录和文件名
     *
     * @param $filename
     * @return string
     */
    public static function getKey($filename)
    {
        $md5 = md5_file($filename);
        $sha1 = sha1_file($filename);
        $key1 = substr($md5, 0, 2);
        $key2 = substr($md5, 2, 2);
        $keyArray = [$md5, $sha1];
        $key3 = join('_', $keyArray);
        $key = "$key1/$key2/$key3";
        return $key;
    }

    /**
     * 删除S3上面的临时文件
     *
     * @param $filename string 文件名
     * @param $sourceSub string 临时文件目录
     * @return mixed
     */
    public static function deleteS3($filename, $sourceSub)
    {
        $key = self::getKey($filename);
        $bucket = Yii::$app->awssdk->sdkOptions['bucket'];
        $keyname = $sourceSub . '/' . $key;
        $result = Yii::$app->awssdk->s3Client->deleteObject(array(
                'Bucket' => $bucket,
                'Key' => $keyname,
            )
        );
        return $result;
    }
}
