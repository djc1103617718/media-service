<?php

namespace common\components\ticket;

use yii\base\Object;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use common\models\Ticket;

/**
 * 票据ID号生成器
 *
 * ```php
 * $generator = \Yii::createObject([
 *     'class' => IdGenerator::className(),
 *     'tickets' => [
 *         'media' => [
 *             'timeAccuracy' => IdGenerator::TIME_ACCURACY_SECOND,
 *             'epoch' => gmmktime(0, 0, 0, 1, 1, 2016),
 *             'sequenceBit' => 13,
 *         ],
 *         'object' => [
 *             'timeAccuracy' => IdGenerator::TIME_ACCURACY_MILLISECOND,
 *             'epoch' => gmmktime(0, 0, 0, 1, 1, 2016),
 *             'sequenceBit' => 10,
 *         ],
 *     ],
 * ]);
 * echo $generator->generate('media'), PHP_EOL;
 * echo $generator->generate('object'), PHP_EOL;
 * ```
 *
 * @package common\components\ticket
 */
class IdGenerator extends Object
{
    /**
     * @const string 时间精度: 秒
     */
    const TIME_ACCURACY_SECOND = 'second';

    /**
     * @const string 时间精度: 毫秒
     */
    const TIME_ACCURACY_MILLISECOND = 'millisecond';

    /**
     * @var string 默认时间精度
     */
    public $defTimeAccuracy;

    /**
     * @var int 默认时间纪元(Unix时间戳格式): 2016-01-01 00:00:00 UTC
     */
    public $defEpoch = 1451606400;

    /**
     * @var int 默认顺序号所占二进制位数: pow(2, 13) = 8192
     */
    public $defSequenceBit = 13;

    /**
     * @var array 票据类型注册表
     */
    public $tickets = [];

    /**
     * @var array 不同时间精度对应的二进制位数
     */
    protected $timeBits = [];


    /**
     * @inheritdoc
     */
    public function init()
    {
        // 默认为秒级别
        $this->defTimeAccuracy = static::TIME_ACCURACY_SECOND;

        // 重新格式化票据类型注册表
        $this->tickets = $this->formatTicketConf($this->tickets);

        // 时间容量控制在17年左右
        $this->timeBits = [
            static::TIME_ACCURACY_SECOND => 29, // Max pow(2, 29) / 3600 / 24 / 365 = 17year
            static::TIME_ACCURACY_MILLISECOND => 39, // Max pow(2, 39) / 1000 / 3600 / 24 / 365 = 17year
        ];

        parent::init();
    }

    /**
     * 重新格式化票据类型配置
     *
     * @param array $tickets 原始配置
     * @return array
     * @throws InvalidConfigException
     */
    protected function formatTicketConf($tickets)
    {
        $return = [];
        foreach ($tickets as $name => $conf) {
            if (!is_array($conf)) {
                $name = $conf;
                $conf = [];
            }
            $conf = ArrayHelper::merge([
                'timeAccuracy' => $this->defTimeAccuracy,
                'epoch' => $this->defEpoch,
                'sequenceBit' => $this->defSequenceBit,
            ], $conf);
            if (!preg_match('/^[a-z]+[a-z0-9_\-]$/', $name)) {
                throw new InvalidConfigException("Invalid ticket type name: $name");
            }
            $return[$name] = $conf;
        }
        return $return;
    }

    /**
     * 生成一个ID号
     *
     * @param string $name 票据类型
     * @return integer
     * @throws InvalidParamException
     */
    public function generate($name)
    {
        if (!isset($this->tickets[$name])) {
            throw new InvalidParamException("Unknown ticket type name: $name");
        }

        $conf = $this->tickets[$name];
        $timeBit = $this->timeBits[$conf['timeAccuracy']];
        $sequenceBit = $conf['sequenceBit'];

        $time = microtime(true) - $conf['epoch'];
        if ($conf['timeAccuracy'] === static::TIME_ACCURACY_SECOND) {
            $time = intval($time);
        } else {
            $time = intval($time * 1000);
        }

        $sequence = $this->getSequence($name) % pow(2, $sequenceBit);
        return (1 << ($timeBit + $sequenceBit)) | ($time << $sequenceBit) | $sequence;
    }

    /**
     * 获取递增序号
     *
     * @param string $name 票据类型
     * @return integer
     */
    protected function getSequence($name)
    {
        $tableName = Ticket::tableName();
        $sql = "INSERT INTO $tableName SET `name` = :name, `sequence` = LAST_INSERT_ID(1) ON DUPLICATE KEY UPDATE `sequence` = LAST_INSERT_ID(`sequence` + 1)";

        // Update sequence
        Ticket::getDb()->createCommand($sql, [':name' => $name])->execute();

        // Get last insert id
        return Ticket::getDb()->createCommand("SELECT LAST_INSERT_ID()")->queryScalar();
    }
}
