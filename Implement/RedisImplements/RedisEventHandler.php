<?php
/**
 * User: Roog
 * Date: 2018/4/5/005
 * Time: 21:45
 */

namespace EventStatistics\Implement\RedisImplement;


use EventStatistics\Abstracts\EventHandlerAbstract;
use EventStatistics\Interfaces\EventRegisterInterface;
use Redis;

class RedisEventHandler extends EventHandlerAbstract {

    public $prefix = 'EventStatistics';

    /**
     * @var Redis
     */
    public $redis;


    public function __construct(EventRegisterInterface $register,Redis $redis, $errorMsgType = self::ERROR_FALSE)
    {
        $this->redis = $redis;
        parent::__construct($register, $errorMsgType);
    }

    public function hashExist($eventName, $hash)
    {
        // TODO: Implement hashExist() method.
    }

    public function getEventNum($eventName)
    {
        $this->redis->get($this->prefix.'_'.$eventName);
    }

    public function increase($eventName, $num, $data=NULL) {
        if(is_callable($this->register[$eventName])){
            $num = $this->formatCallableNum($this->register[$eventName]($data));
        }

        return $this->redis->incrBy($this->prefix.'_'.$eventName,$num);
    }

    public function reduce($eventName, $num ,$data=NULL) {
        if(is_callable($this->register[$eventName])){
            $num = $this->formatCallableNum($this->register[$eventName]($data));
        }

        return $this->redis->decrBy($this->prefix.'_'.$eventName,$num);
    }

    public function reduceHash($eventName, $num, $hash,$data=NULL) {
        return parent::reduceHash($eventName, $num, $hash);
    }

    public function increaseHash($eventName, $num, $hash,$data=NULL) {
        return parent::increaseHash($eventName, $num, $hash);
    }

}