<?php
/**
 * EventRegisterInterface
 * User: Roog
 * Date: 2018/4/4/004
 * Time: 21:45
 */
namespace EventStatistics\Interfaces;

/**
 * Interface EventHandlerInterface
 * @package EventStatistics\Interfaces
 */
Interface EventHandlerInterface {

    /**
     * increase
     * if event have a callable ,num will be callable function return
     * @param $eventName    string
     * @param $num          integer
     * @param $data         mixed   callable use it
     * @return boolean
     */
    public function increase ($eventName,$num,$data=NULL);

    /**
     * reduce
     * @param $eventName    string
     * @param $num          integer
     * @param $data         mixed   callable use it
     * @return boolean
     */
    public function reduce ($eventName,$num,$data=NULL);

    /**
     * increaseHash
     * if Hash already exist,
     * depending on your configuration ,it will return false or throw Exceptions
     * if event have a callable ,num will be callable function return
     * @param $eventName    string
     * @param $num          int
     * @param $hash         mixed
     * @param $data         mixed   callable use it
     * @return boolean
     * @throws \Exception
     */
    public function increaseHash($eventName,$num,$hash,$data=NULL);

    /**
     * reduceHash
     * if Hash already exist,
     * depending on your configuration ,it will return false or throw Exceptions
     * if event have a callable ,num will be callable function return
     * @param $eventName    string
     * @param $num          int
     * @param $hash         mixed
     * @param $data         mixed   callable use it
     * @return boolean
     */
    public function reduceHash ($eventName,$num,$hash,$data=NULL);

    /**
     * get event statistics num
     * @param $eventName
     * @return int
     */
    public function getEventNum ($eventName);

    /**
     * hashExist
     * @param $eventName
     * @param $hash
     */
    public function hashExist($eventName,$hash);

    /**
     * createHash
     * @param $eventName
     * @param $hash
     * @return mixed
     */
    public function createHash($eventName,$hash);

}
