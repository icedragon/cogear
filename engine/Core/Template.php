<?php
/**
 *  Template handler
 *
 * @author		Dmitriy Belyaev <admin@cogear.ru>
 * @copyright		Copyright (c) 2011, Dmitriy Belyaev
 * @license		http://cogear.ru/license.html
 * @link		http://cogear.ru
 * @package		Core
 * @subpackage
 * @version		$Id$
 */
class Template extends Adapter{
    /**
     * Default handler
     *
     * @var string
     */
    public static $handler;
    /**
     * Constants
     */
    const FILE = 0;
    const DB = 1;
    /**
     * Constructor
     *
     * @param   string  $name
     * @param   string  $handler
     */
    public function __construct($name,$handler = NULL){
        if(!self::$handler){
            $cogear = getInstance();
            self::$handler = $cogear->get('template.handler',self::FILE);
        }
        $handler OR $handler = self::$handler;
        switch($handler){
            case self::DB:
                $this->adapter = new Template_Db($name);
                break;
            case self::FILE:
            default:
                $this->adapter = new Template_File($name);
        }
    }

    /*
     * We avoid usage of __callStatic method to have better compatibilty with PHP versions under 5.3.
     * That's because we need to make a couple of aliases ↓
     */
    
    /**
     * Set global variable
     */
    public static function setGlobal() {
        $args = func_get_args();
        return call_user_func_array(array('Template_Abstract','setGlobal'),$args);
    }
    /**
     * Bind global variable
     */
    public static function bindGlobal() {
        $args = func_get_args();
        return call_user_func_array(array('Template_Abstract','bindGlobal'),&$args);
    }
    /**
     * Get global
     */
    public static function getGlobal() {
        $args = func_get_args();
        return call_user_func_array(array('Template_Abstract','getGlobal'),$args);
    }
}
