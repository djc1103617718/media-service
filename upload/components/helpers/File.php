<?php

namespace upload\components\helpers;

use yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use common\dict\Dict;
use upload\components\exception\BussinessLogicException;
use upload\components\file\meta\Meta;
use upload\components\errors\Code;

class File
{
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
        return ['type' => $type];
    }

    /**
     * 获取文件属性
     *
     * @param $filename string 文件名
     * @return array
     * @throws BussinessLogicException
     * @throws yii\base\InvalidConfigException
     */
    public static function getFileAtrr($filename)
    {
        $size = filesize($filename);
        $md5 = md5_file($filename);
        $sha1 = sha1_file($filename);
        $content_type = mime_content_type($filename);
        $typeArr = File::getType($content_type);
        $fileArr = ArrayHelper::merge([
            'md5' => $md5,
            'sha1' => $sha1,
            'content_type' => $content_type,
            'size' => $size,
        ], $typeArr);
        $className = '\upload\components\file\meta\\' . Inflector::id2camel(Dict::$objectTypes[$typeArr['type']]);
        $metaObj = Yii::createObject($className);
        if (!$metaObj instanceof Meta) {
            throw new BussinessLogicException(Code::FILE_CATEGORY_ERROR);
        }
        $meta = $metaObj->getImageMeta($filename);
        return ArrayHelper::merge($fileArr,  $meta);
    }

    /**
     * quote from @http://www.ruesin.com/php/mkdir-97.html
     * #################################################
     *
     * 迭代创建级联目录
    ×
     * @param string $path
     * @return bool
     */
    public static function makeTempDir($path)
    {
        $arr = array();
        while (!is_dir($path)) {
            // 把路径中的各级父目录压入到数组中去，直接有父目录存在为止（即上面一行is_dir判断出来有目录，条件为假退出while循环）
            array_push($arr, $path);
            // 父目录
            $path = dirname($path);
        }
        // arr为空证明上面的while循环没有执行，即目录已经存在
        if (empty($arr)) {
            return true;
        }
        while (count($arr))  {
            // 弹出最后一个数组单元
            $parentdir=array_pop($arr);
            // 从父目录往下创建
            mkdir($parentdir);
        }
    }

    /**
     * @param $fp resource 源文件
     * @param $filename string 写入的目标文件
     * @return resource
     */
    public static function writeFile($fp, $filename)
    {
        $fp2 = @fopen($filename, "wb");
        // 将打开的输入文件按照1024个字节一段一段的写入到临时文件$fp2中,直到读完为止
        while (($string = fread($fp, 1024)) !== false && !feof($fp)) {
            fwrite($fp2, $string);
        }
        @fclose($fp);
        @fclose($fp2);
        return $filename;
    }
}
