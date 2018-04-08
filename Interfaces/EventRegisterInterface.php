<?php
/**
 * EventRegisterInterface
 * User: Roog
 * Date: 2018/4/4/004
 * Time: 21:45
 */
namespace EventStatistics\Interfaces;

/**
 * Interface EventRegisterInterface
 * @package EventStatistics\Interfaces
 */
Interface EventRegisterInterface {

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
    public function setEvent($eventName,$function = false);

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
    public function addEvent($eventName,$function = false);

    /**
     * FBI WARNING
     * FBI WARNING
     * FBI WARNING
     * remove the event will remove all data! That's Danger!
     * @param $eventName
     * @return bool
     */
    public function removeEvent($eventName);

    /**
     * if event already exist will return true
     * @param $eventName
     * @return boolean
     */
    public function existEvent($eventName);

}