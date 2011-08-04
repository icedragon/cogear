<?php

/**
 * Gear
 *
 * @author		Dmitriy Belyaev <admin@cogear.ru>
 * @copyright		Copyright (c) 2011, Dmitriy Belyaev
 * @license		http://cogear.ru/license.html
 * @link		http://cogear.ru
 * @package		Core
 * @subpackage
 * @version		$Id$
 */
abstract class Gear extends Cogearable{

    /**
     * Gear name
     * @var string
     */
    protected $name;
    /**
     * Gear description
     * @var string
     */
    protected $description;
    /**
     * Gear version
     *
     * By default it equals Cogear version
     *
     * @var string
     */
    protected $version = COGEAR;
    /**
     * Core version
     *
     * By default it equals Cogear version

     * * @var string
     */
    protected $core = COGEAR;
    /**
     * Gear type
     *
     * @var int
     */
    protected $type = Gear::CORE;
    /**
     * Package
     * 
     * @var string 
     */
    protected $package = 'Core';
    /**
     * Gear authors name
     *
     * @var string
     */
    protected $author = 'Dmitriy Belyaev';
    /**
     * Gear email
     *
     * Contact email to resolve everything
     * @var string
     */
    protected $email = 'admin@cogear.ru';
    /**
     * Gear website
     *  
     * @var string
     */
    protected $site = 'http://cogear.ru';
    /**
     * Path to class file
     *
     * @var string
     */
    protected $path;
    /**
     * Directory where gear is located
     * @var string
     */
    protected $dir;
    /**
     * Relative path to folder with class
     *
     * @var string
     */
    protected $folder;
    /**
     * Order in gear stack
     *
     * Value can be positive or negative to load after or before other gears.
     *
     * @var int
     */
    protected $order = 0;
    /**
     * Class reflection
     *
     * Metaclass that stores all the info about current class
     *
     * @var ReflectionClass
     */
    protected $reflection;
    
    /**
     * Gear name
     *
     * How does it stored in $cogear->gears->$name
     *
     * @param   string
     */
    protected $gear;
    /**
     * Info about gear file
     * 
     * @var SplFileInfo 
     */
    protected $file;
    /**
     * Simple uri name
     * It can be set in configuration, but if empty — will be default gear_name
     * 
     * @var string 
     */
    protected $base;
    /**
     * Gear settings
     * 
     * @var Core_ArrayObject
     */
    protected $settings = array();
    /**
     * If gear is requested by router
     * @var boolean 
     */
    protected $is_requested;
    /**
     * Flag indicates if gear is active
     * 
     * @var boolean
     */
    public $active;
    /**
     * Required gears [version is optoinal]
     *
     * array(
     *  'Phpinfo',
     *   // or with version
     *  'Phpinfo 1.1',
     *   // or even with condition
     *  'Phpinfo > 1.1',
     * )
     * @var array
     */
    protected $required = array();
    const CORE = 0;
    const MODULE = 1;
    const THEME = 2;

    /**
     * Constructor
     */
    public function __construct() {
        $this->reflection = new ReflectionClass($this);
        $this->getPath();
        $this->getDir();
        $this->getFolder();
        $this->getGear();
        $this->getBase();
        $this->getSettings();
        $this->file = new SplFileInfo($this->path);
    }
    /**
     * Initialize
     */
    public function init() {
        $scripts = $this->dir . DS . 'js';
        $styles = $this->dir . DS . 'css';
        is_dir($scripts) && $this->assets->addScriptsFolder($scripts);
        is_dir($styles) && $this->assets->addStylesFolder($styles);
        $this->router->addRoute($this->base . ':maybe', array($this, 'index'));
        event('gear.init', $this);
    }
    /**
     * Magic __get method
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        return isset($this->$name) ? $this->$name : parent::__get($name);
    }
    /**
     * Gear info
     *
     * @param   string  $var
     * @return  array
     */
    public function info($var = NULL) {
        if ($var) {
            return isset($this->$var) ? $this->$var : NULL;
        }
        else
            return array(
                'name' => t($this->name,'Gears'),
                'gear' => strtolower($this->gear),
                'base' => $this->base,
                'description' => t($this->description,'Gears'),
                'version' => $this->version,
                'package' => $this->package,
                'type' => $this->type,
                'author' => $this->author,
                'email' => $this->email,
                'site' => $this->site,
                'has_admin' => method_exists ($this, 'admin'),
                'path' => $this->path,
                'dir' => $this->dir,
                'folder' => $this->folder,
                'active' => $this->active,
            );
    }

    /**
     * Install
     */
    public function install() {
        
    }

    /**
     * Uninstall
     */
    public function uninstall() {
        
    }

    /**
     * Activate
     */
    public function activate() {
        
    }

    /**
     * Deactivate
     */
    public function deactivate() {
        
    }

    /**
     * Update gear
     */
    public function update() {
        
    }

    /**
     * Get Gear Path
     *
     * @return string
     */
    protected function getPath() {
        return $this->path = $this->reflection->getFileName();
    }

    /**
     * Get Gear directory
     *
     * @return  string
     */
    protected function getDir() {
        if (!$this->path)
            $this->getPath();
        return $this->dir = dirname($this->path);
    }

    /**
     * Get Gear relative folder
     *
     * @return string
     */
    protected function getFolder() {
        if (!$this->dir)
            $this->getDir();
        $this->folder = str_replace(array(ROOT, DS), array('', '/'), $this->dir);
        return self::normalizePath($this->dir);
    }

    /**
     * Get Gear name
     *
     * @return  string
     */
    protected function getGear() {
        return $this->gear ? $this->gear : $this->gear = Cogear::prepareGearNameFromClass($this->reflection->getName());
    }

    /**
     * Get base name
     */
    protected function getBase() {
        $cogear = getInstance();
        $base = str_replace('_', '/', strtolower($this->gear));
        return $this->base ? $this->base : $this->base = $cogear->get($this->gear . '.base', $base);
    }

    /**
     * Get gear options
     */
    protected function getSettings() {
        $this->settings = new Core_ArrayObject($this->settings);
        if ($config = Config::read(find(basename($this->dir) . DS . 'settings' . EXT))) {
            return $this->settings ? $this->settings->mix($config) : $this->settings = $config;
        }
        return NULL;
    }

    /**
     * Set theme
     * 
     * Only for this gear
     * 
     * @param   string  $theme 
     */
    public function setTheme($theme = '') {
        $theme OR $theme = $this->settings->theme->current;
        if (!$theme)
            return NULL;
        $cogear = getInstance();
        $cogear->setTheme($theme) && $cogear->theme->current->init();
    }

    /**
     * Normalize relative path
     *
     * For example, under windows it look like \cogear\Theme\Default\, but wee need good uri to load css, js or anything else.
     * It transorm that path to /cogear/Theme/Default/.
     * @param   string  $path
     * @return  string
     */
    public static function normalizePath($path) {
        $path = str_replace(DS, '/', $path);
        return $path;
    }

    /**
     * Get gear name by path
     *
     * @param   string  $path
     * @return  string|boolean  Gear name or FALSE if path is not correct.
     */
    public static function getGearNameFromPath($path) {
        foreach (array(SITE . DS . GEARS_FOLDER, GEARS, ENGINE) as $dir) {
            if (strpos($path, $dir) !== FALSE) {
                is_file($path) && $path = dirname($path);
                $path = str_replace($dir, '', $path);
                $path = trim($path, DS);
                $pieces = explode(DS, $path);
                $gear_folder = '';
                foreach ($pieces as $piece) {
                    $gear_folder .= $piece . DS;
                    $gear_name = str_replace(DS, '_', trim($gear_folder, DS));
                    $gear_class = $gear_name . '_Gear';
                    if (file_exists($dir . DS . $gear_folder . DS . 'Gear' . EXT) && class_exists($gear_class)) {
                        return $gear_name;
                    }
                }
            }
        }
        return FALSE;
    }

    /**
     * Prepare path
     *
     * Errors.index = Core/Errors/$dir/index
     *
     * @param	string	$name
     * @param   string  $dir
     * @param   string  $default
     * @return	string  Path without file extension
     */
    public static function preparePath($name, $dir = '', $default = 'index') {
        if ($pieces = preg_split('#[\s><.-]#', $name, -1, PREG_SPLIT_NO_EMPTY)) {
            if (sizeof($pieces) == 1) {
                array_push($pieces, $default);
            }
            $gear = strtolower(array_shift($pieces));
            $cogear = getInstance();
            if (isset($cogear->gears->$gear)) {
                $gear_dir = $cogear->gears->$gear->dir;
                $file_name = implode(DS, $pieces);
                return $path = $gear_dir . DS . $dir . DS . $file_name;
            } elseif ($found = find(ucfirst(str_replace('_', DS, $gear)) . DS . 'Gear' . EXT)) {
                $gear_dir = dirname($found);
                $file_name = implode(DS, $pieces);
                return $path = $gear_dir . DS . $dir . DS . $file_name;
            }
        }
        return NULL;
    }

    /**
     * Notify gear that it's requested by uri
     */
    public function request() {
        $this->is_requested = TRUE;
        if(!event('gear.request',$this)){
            return;
        }
        event('gear.request.' . strtolower($this->gear));
    }

    /**
     * Dispatcher
     * @param string $action
     */
    public function index() {
        if(!$args = func_get_args()){
            $args[] = 'index';
        }
        method_exists($this, $args[0].'_action') && call_user_func_array(array($this,$args[0].'_action'),array_slice($args,1));
    }

}