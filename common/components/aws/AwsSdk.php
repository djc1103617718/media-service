<?php

namespace common\components\aws;

use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use Aws\Sdk;

/**
 * Class AwsSdk
 *
 * @package common\components\aws
 */
class AwsSdk extends Object
{
    /**
     * @var array AWS SDK Config options
     * @link http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html
     */
    public $sdkOptions = [];

    /**
     * @var Sdk AWS SDK instance
     */
    protected $sdk;

    /**
     * @var array AWS Clients
     */
    protected $clients = [];


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sdkOptions = ArrayHelper::merge([
            'region' => 'us-east-1',
            'version' => 'latest',
        ], $this->sdkOptions);
        parent::init();
    }

    /**
     * Get AWS SDK
     *
     * @return Sdk
     */
    public function getSdk()
    {
        if (!is_object($this->sdk)) {
            $this->sdk = new Sdk($this->sdkOptions);
        }
        return $this->sdk;
    }

    /**
     * Auto create AWS client
     *
     * @param string $name AWS client name, eg. s3Client
     * @return mixed the property value
     */
    public function __get($name)
    {
        $words = Inflector::camel2words($name);
        $words = explode(' ', $words);
        if (array_pop($words) === 'Client') {
            $service = strtolower(join('', $words));
            if (!isset($this->clients[$service])) {
                $this->clients[$service] = $this->getSdk()->createClient($service);
            }
            return $this->clients[$service];
        }
        return parent::__get($name);
    }
}