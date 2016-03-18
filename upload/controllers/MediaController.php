<?php

namespace upload\controllers;

use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\UserException;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use common\models\CategoryRule;
use upload\components\rules\Rule;
use upload\components\s3\S3Helper;
use upload\components\base\Controller;
use upload\models\Media;

/**
 * Class CategoriesController
 *
 * @package upload\controllers
 *
 */
class MediaController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @return array
     * @throws UserException
     * @throws \Exception
     */
    public function actionCreate()
    {
        $filename = $this->saveInputFile();
        $fileAttr = $this->getFileAtrr($filename);

        $media = new Media();
        $allAttr = ArrayHelper::merge(
            $fileAttr,
            Yii::$app->request->get()
        );
        $media->type = $allAttr['type'];
        $media->object->attributes = $allAttr;
        $media->object->id = Yii::$app->ticketIdGenerator->generate('object');
        $media->object->storage_type = 1;

        $media->objectMetaImage->attributes = $allAttr;
        $media->objectMetaImage->id = $media->object->id;

        $media->setMedia($this->app, $this->category);

        if (!$media->validate() || !$this->categoryRule($media)) {
            throw new UserException('验证规则失败');
        }

        $object = $media->object->findOne([
            'md5' => $media->object->md5,
            'sha1' => $media->object->sha1,
        ]);

        if ($object) {
            $media->save(false);
            @unlink($filename);
            return $this->returnParams($media);
        }

        $s3Object = S3Helper::putS3($filename, 'temp');
        $media->setObjectStorageS3($s3Object, $filename);
        Yii::$app->db->transaction(function () use ($media) {
            $media->object->save(false);
            $media->objectMetaImage->save(false);
            $media->objectStorageS3->save(false);
            $media->save(false);
        });
        try {
            $result = S3Helper::copyS3($filename, 'main', 'temp');
            $media->updateS3($result, $filename);
        } catch (Exception $e) {
        }
        @unlink($filename);
        return $this->returnParams($media);
    }

    /**
     * 获取文件的属性
     * @param string $filename 文件名
     * @return array 返回一个文件属性的数组
     * @throws UserException
     */
    public function getFileAtrr($filename)
    {
        $size = filesize($filename);
        if ($size === 0) {
            throw new UserException ('传输内容为空');
        }
        $md5 = md5_file($filename);
        $sha1 = sha1_file($filename);
        $content_type = mime_content_type($filename);
        $time = time();
        $fileArr = [
            'md5' => $md5,
            'sha1' => $sha1,
            'content_type' => $content_type,
            'size' => $size,
            'create_time' => $time,
            'update_time' => $time,
        ];
        $gpsArray = S3Helper::getGps($filename);
        $typeArr = S3Helper::getType($content_type);
        return ArrayHelper::merge($fileArr,  $gpsArray, $typeArr);
    }

    /**
     * 返回参数
     *
     * @param Media $media 对象Media
     * @return array
     */
    public function returnParams($media)
    {
        unset($media->objectMetaImage['id']);
        $id = Yii::$app->hashids->encode($media->id);
        return[
            'id' => $id,
            'name' => $media->name,
            'description' =>$media->description,
            'content_type' => $media->content_type,
            'create_time' => $media->create_time,
            'update_time' => $media->update_time,
            'type' => $media->type,
            'size' => $media->object->size,
            //'url'=>'http://download.mp-media-service.app/' . Yii::$app->request->get('category_url_name') . '/' . $id,
            'url'=>'http://54.152.104.244:84/' . Yii::$app->request->get('category_url_name') . '/' . $id,
            'meta' => $media->objectMetaImage];
    }

    /**
     * 将输入的文件保存在临时文件中
     *
     * @return string $filename 返回文件名
     */
    public function saveInputFile()
    {
        // 打开输入文件
        $fp = @fopen("php://input", "rb");

        $uploadDir = Yii::getAlias('@upload');
        // 创建临时文件目录
        $this->makeTempDir($uploadDir . '/runtime/temp');
        // 获取唯一的临时文件
        $uniqid = uniqid();

        $filename = sprintf('%s/runtime/temp/%s', $uploadDir, $uniqid);
        // 打开准备写入的临时文件
        $fp2 = @fopen($filename, "wb");
        // 将打开的输入文件按照1024个字节一段一段的写入到临时文件$fp2中,直到读完为止
        while (($string = fread($fp, 1024)) !== false && !feof($fp)) {
            fwrite($fp2, $string);
        }

        // 关闭两个文件
        @fclose($fp);
        @fclose($fp2);
        return $filename;
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
    public function makeTempDir($path)
    {
        $arr=array();
        while(!is_dir($path)){
            array_push($arr,$path);// 把路径中的各级父目录压入到数组中去，直接有父目录存在为止（即上面一行is_dir判断出来有目录，条件为假退出while循环）
            $path=dirname($path);// 父目录
        }
        if(empty($arr)){// arr为空证明上面的while循环没有执行，即目录已经存在
            return true;
        }
        while(count($arr)){
            $parentdir=array_pop($arr);// 弹出最后一个数组单元
            mkdir($parentdir);// 从父目录往下创建
        }
    }


    /**
     * 验证文件规则
     *
     * @param $obj
     * @return bool
     * @throws InvalidConfigException
     */
    public function categoryRule($obj)
    {
        $rules = CategoryRule::find()->where(['category_id' => $this->category->id])->all();
        foreach ($rules as $rule) {
            $ruleName = $rule['rule_name'];
            $ruleParams = json_decode($rule['rule_params']);
            $ruleParams = get_object_vars($ruleParams);
            $ruleParams['media'] = $obj;
            $className = '\upload\components\rules\\' . Inflector::id2camel($ruleName);
            $ruleObj = \Yii::createObject([
                'class' => $className,
            ], [$ruleParams]);
            if (!($ruleObj instanceof Rule)) {
                return false;
            }
            if (!$ruleObj->check()) {
                return false;
            }
        }
        return true;
    }
}
