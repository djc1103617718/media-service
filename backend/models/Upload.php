<?php
namespace backend\models;

use yii;
use GuzzleHttp\Client;

class Upload extends yii\base\Model
{
    /**
     * @param $url
     * @param $params
     * @param $fileName
     * @return \Psr\Http\Message\StreamInterface|resource
     * @throws yii\base\Exception
     */
    public static function send($url, $params, $fileName)
    {
        $client = new Client([
            'base_uri' => $url,
            'timeout'  => 600,
        ]);

        $sendUrl = self::buildUrl($url, $params);
        $body = fopen($fileName, 'rb');
        if (empty($body)) {
            throw new yii\base\Exception('该上传文件有误');
        }

        $results = $client->post($sendUrl, ['body' => $body]);
        $res = $results->getBody(true);
        //echo $res;die;
        unlink($fileName);
        return $res->getContents();
    }

    /**
     * @param $url
     * @param $params
     * @return string
     */
    private static function buildUrl($url, $params)
    {
        $signature = self::generateSignature($params);
        $params['signature'] = $signature;
        $string = http_build_query($params);
        $sendUrl = $url . '?' . $string;
        return $sendUrl;
    }

    /**
     * @param $params
     * @return string
     */
    private static function generateSignature($params)
    {
        ksort($params);
        $string = http_build_query($params);
        $signature = md5($string);
        return $signature;
    }
}