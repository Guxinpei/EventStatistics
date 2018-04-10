<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/5/005
 * Time: 20:13
 */
namespace EventStatistics\Abstracts;

use EventStatistics\Exceptions\EventHandlerException;
use EventStatistics\Interfaces\EventRegisterInterface;
use EventStatistics\Interfaces\EventHandlerInterface;

abstract class EventHandlerAbstract implements EventHandlerInterface{

    /**
     *  error return false
     */
    const ERROR_FALSE = 1;

    /**
     *  error return Exception
     */
    const ERROR_EXCEPTION = 2;

    /**
     * ERROR_FALSE or ERROR_EXCEPTION
     * @var string
     */
    public $errorMsgType;


    /**
     * event register
     * @var EventRegisterInterface
     */
    public $register;

    public function __construct(EventRegisterInterface $register,$errorMsgType = self::ERROR_FALSE) {
        $this->register = $register;
        $this->errorMsgType = $errorMsgType;
    }

    /**
     * increaseHash
     * if Hash already exist,
     * depending on your configuration ,it will return false or throw Exceptions
     * @param $eventName    string
     * @param $num          int
     * @param $hash         mixed
     * @param $data         mixed
     * @return boolean
     * @throws \Exception
     */
    public function increaseHash($eventName,$num,$hash,$data = NULL) {

        if($this->hashExist($eventName,$hash)){
            return $this->returnError('Hash has already existed');
        }

        return $this->increase($eventName,$num,$data);

    }

    /**
     * reduceHash
     * if Hash already exist,
     * depending on your configuration ,it will return false or throw Exceptions
     * if event have a callable ,num will be callable function return
     * @param $eventName    string
     * @param $num          int
     * @param $hash         mixed
     * @param $data         mixed callable use it
     * @return boolean
     */
    public function reduceHash ($eventName,$num,$hash,$data = NULL){

        if($this->hashExist($eventName,$hash)){
            return $this->returnError('Hash has already existed');
        }

        return $this->reduce($eventName,$num);

    }

    /**
     * return error
     * @param $errMsg
     * @return bool
     * @throws EventHandlerException
     */
    private function returnError($errMsg){
        switch ($this->errorMsgType){
            case self::ERROR_EXCEPTION:
                throw new EventHandlerException($errMsg,'');
            case self::ERROR_FALSE:
                return false;
            default:
                return false;
        }
    }

    /**
     * formateCallableNum
     * @param $num
     * @return int
     */
    protected function formatCallableNum($num){

        if($num === true){
            return 1;
        }

        if($num === false){
            return -1;
        }

        return $num;

    }


}