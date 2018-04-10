<?php
/**
 * EventRegisterAbstract
 * User: Roog
 * Date: 2018/4/5/005
 * Time: 11:08
 */
namespace EventStatistics\Abstracts;

use EventStatistics\Exceptions\EventRegisterException;
use EventStatistics\Interfaces\EventRegisterInterface;

abstract class EventRegisterAbstract implements EventRegisterInterface{

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
     * all eventList
     * @var array
     */
    public $eventList;

    /**
     * all event Callable
     * @var array(
     *    'event'=>callable
     * )
     */
    public $eventCallable;

    public function __construct($errorMsgType = self::ERROR_FALSE) {
        $this->errorMsgType = $errorMsgType;
    }

    /**
     * regist event
     * if eventName already exist ,old event will be covered
     * eventName must use [0-9|_|a-z|A-Z]
     * function must be return bool or false or num
     * If the number is greater than 0, the number of events will increase, and true will increase by 1.
     * If the number is less than 0, the number of events will be reduced, and false will be reduced by 1.
     * Return to null not to do any processing, 0 is the same
     * @param  $eventName string
     * @param  $function  boolean|callable
     * @return boolean
     */
    public function setEvent($eventName,$function = false){

        $this->eventList[] = $eventName;

        if(is_callable($function)){
            $this->eventCallable[$eventName] = $function;
        }

        return true;

    }

    /**
     * regist event
     * if eventName already exist ,old event will not be covered and return false
     * eventName must use [0-9|_|a-z|A-Z]
     * function must be return bool or false or num
     * If the number is greater than 0, the number of events will increase, and true will increase by 1.
     * If the number is less than 0, the number of events will be reduced, and false will be reduced by 1.
     * Return to null not to do any processing, 0 is the same
     * @param  $eventName string
     * @param  $function  boolean|callable
     * @return boolean
     */
    public function addEvent($eventName,$function = false){

        if($this->existEvent($eventName)){
            return $this->returnError('Event already exist!');
        }

        return $this->setEvent($eventName,$function);

    }

    /**
     * remove the event
     * @param $eventName
     * @return bool
     */
    public function removeEvent($eventName){

        if(!in_array($eventName,$this->eventList)){
            return $this->returnError('Event not exist');
        }

    }

    /**
     * if event already exist will return true
     * @param $eventName
     * @return boolean
     */
    public function existEvent($eventName){
        return in_array($eventName,$this->eventList);
    }

    /**
     * return error
     * @param $errMsg
     * @return bool
     * @throws EventRegisterException
     */
    private function returnError($errMsg){
        switch ($this->errorMsgType){
            case self::ERROR_EXCEPTION:
                throw new EventRegisterException($errMsg,'');
            case self::ERROR_FALSE:
                return false;
            default:
                return false;
        }
    }

}