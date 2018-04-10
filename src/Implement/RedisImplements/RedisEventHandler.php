<?php
/**
 * User: Roog
 * Date: 2018/4/5/005
 * Time: 21:45
 */

namespace EventStatistics\Implement\RedisImplements;


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

    /**
     * hashExist
     * @param $eventName
     * @param $hash
     * @return bool
     */
    public function hashExist($eventName, $hash)
    {
        $keyName = $this->prefix.'_'.$eventName.'_hash';
        $hashString = $this->hash($hash);
        return $this->redis->sIsMember($keyName,$hashString);
    }

    /**
     * getEventNum
     * @param $eventName
     * @return int|void
     */
    public function getEventNum($eventName)
    {
        $this->redis->get($this->prefix.'_'.$eventName);
    }

    /**
     * increase
     * @param string $eventName
     * @param int $num
     * @param null $data
     * @return bool|int
     */
    public function increase($eventName, $num, $data=NULL) {
        if(!empty($this->register->eventList[$eventName])){
            if(is_callable($this->register->eventList[$eventName])){
                $num = $this->formatCallableNum($this->register[$eventName]($data));
            }
        }

        return $this->redis->incrBy($this->prefix.'_'.$eventName,$num);
    }

    /**
     * reduce
     * @param string $eventName
     * @param int $num
     * @param null $data
     * @return bool|int
     */
    public function reduce($eventName, $num ,$data=NULL) {
        if(is_callable($this->register[$eventName])){
            $num = $this->formatCallableNum($this->register[$eventName]($data));
        }

        return $this->redis->decrBy($this->prefix.'_'.$eventName,$num);
    }

    /**
     * reduceHash
     * @param string $eventName
     * @param int $num
     * @param mixed $hash
     * @param null $data
     * @return bool
     */
    public function reduceHash($eventName, $num, $hash,$data=NULL) {
        return parent::reduceHash($eventName, $num, $hash);
    }

    /**
     * increaseHash
     * @param string $eventName
     * @param int $num
     * @param mixed $hash
     * @param null $data
     * @return bool
     * @throws \Exception
     */
    public function increaseHash($eventName, $num, $hash,$data=NULL) {
        return parent::increaseHash($eventName, $num, $hash);
    }

    /**
     * createHash
     * @param $eventName
     * @param $hash
     * @return int|mixed
     */
    public function createHash($eventName,$hash){
        $keyName = $this->prefix.'_'.$eventName.'_hash';
        $hashString = $this->hash($hash);
        return $this->redis->sAdd($keyName,$hashString);
    }



}